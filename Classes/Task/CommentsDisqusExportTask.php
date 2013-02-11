<?php

require_once PATH_typo3 . 'class.webpagetree.php';
require_once PATH_t3lib . 'class.t3lib_querygenerator.php';

class Tx_Vantomas_Task_CommentsDisqusExportTask implements tx_taskcenter_Task {
	protected $taskObject;

	/**
	 *
	 * @var t3lib_queryGenerator
	 */
	protected $queryGenerator;

	/**
	 *
	 * @var tslib_cObj
	 */
	protected $cObj;

	public function __construct(SC_mod_user_task_index $taskObject) {
		$this->taskObject = $taskObject;

		$this->queryGenerator = t3lib_div::makeInstance('t3lib_queryGenerator');

		$this->cObj = t3lib_div::makeInstance('tslib_cObj');
	}

	public function getTask() {
		$content = '';

		$content = $this->getForm();

		if (NULL !== t3lib_div::_GP('submit')) {
			$content .= '<br><h2>Export:</h2>';
			$content .= '<div style="width: 550px; height: 300px; overflow: auto; padding: 10px; border: 1px solid #cecece; background-color: #ffffff;">' . $this->processExport(intval(t3lib_div::_GP('page'))) . '</div>';
		}

		return $content;
	}

	public function getOverview() {
		return '<p>I will export all ext:comments records into a Disqus generic import file (WXR).</p>';
	}

	protected function getForm() {
		$content = '<form action="" method="post" enctype="multipart/form-data">
			<fieldset class="fields">
				<div class="row">
					<label for="page">page:</label>
					<select id="page" name="page">
						' . $this->getPagesAsOptions() .'
					</select>
				</div>
				<div class="row">
					<label for="linkPrefix">link prefix:</label>
					<input id="linkPrefix" name="linkPrefix" type="text" value="http://www.example.org/" size="30" />
				</div>
				<div class="row">
					<label for="anonymousMail">enable anonymous mail:</label>
					<input id="anonymousMail" name="anonymousMail" type="checkbox" value="1" checked="checked" />
				</div>
				<div class="row">
					<label for="anonymousMailAddress">anonymous mail address:</label>
					<input id="anonymousMailAddress" name="anonymousMailAddress" type="input" value="anonymous@example.org" size="30" />
				</div>
				<div class="row">
					<label for="removeNewlinesAfterNl2br">remove newlines after applying nl2br() on comment content:</label>
					<input id="removeNewlinesAfterNl2br" name="removeNewlinesAfterNl2br" type="checkbox" value="1" checked="checked" />
				</div>
				<div class="row">
					<input type="submit" name="submit" value="Do it!" />
				</div>
			</fieldset>
		</form>';

		return $content;
	}

	protected function getPagesAsOptions() {
		$options = '';

		/* @var $treeView webPageTree */
		$treeView = t3lib_div::makeInstance('webPageTree');
		$treeHTML = $treeView->getBrowsableTree();

		foreach ($treeView->tree as $treeItem) {
			$depth = str_repeat('-', 1000 - $treeItem['invertedDepth']);

			$disabled = '';
			if (0 === $treeItem['row']['uid']) {
				$disabled = ' disabled="disabled"';
			}

			$options .= sprintf('<option value="%s"%s>%s%s</option>',
				$treeItem['row']['uid'],
				$disabled,
				$depth,
				$treeItem['row']['title']
			);
		}

		return $options;
	}

	protected function processExport($pid) {
		$this->simulateFrontendEnvironment($pid);

		$pids = $this->queryGenerator->getTreeList($pid, 1, 0, 1);

		$content = '';

		$selectFields = 'uid, pid, title, crdate';
		$whereClause = 'pid IN (' . $pids . ') AND nav_hide = 0 AND hidden = 0';

		$pages = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
			$selectFields,
			'pages',
			$whereClause,
			'',
			'crdate DESC'
		);

		$pageTemplate = <<<PAGETEMPLATE
		<item>
			<title>%s</title>
			<link>%s</link>
			<dsq:thread_identifier>page_%s</dsq:thread_identifier>
			<wp:post_date_gmt>%s</wp:post_date_gmt>
			<wp:comment_status>open</wp:comment_status>
%s
		</item>

PAGETEMPLATE;

		while ($page = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($pages)) {
			if (0 === $this->countPageComments($page['uid'])) {
				continue;
			}

			$pageLink = $this->cObj->getTypoLink_URL($page['uid']);

			$content .= sprintf($pageTemplate,
				$page['title'],
				t3lib_div::_GP('linkPrefix') . $pageLink,
				$page['uid'],
				date('Y-m-d H:i:s', $page['crdate']),
				$this->getComments($page['uid'])
			);
		}

		if ('' !== $content) {
			$documentTemplate = <<<DOCUMENTTEMPLATE
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:dsq="http://www.disqus.com/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:wp="http://wordpress.org/export/1.0/">
	<channel>
%s
	</channel>
</rss>
DOCUMENTTEMPLATE;

			$content = sprintf($documentTemplate,
				$content
			);
		}

		return '<textarea style="width: 100%; height: 100%; font-family: monospace; font-size: 10px;">' . htmlspecialchars($content) . '</textarea>';
	}

	protected function countPageComments($pid) {
		$whereClause = 'hidden = 0 AND deleted = 0 AND approved = 1 AND external_prefix = \'pages\' AND pid = ' . $pid;

		$comments = $GLOBALS['TYPO3_DB']->exec_SELECTcountRows(
			'*',
			'tx_comments_comments',
			$whereClause
		);

		return (integer) $comments;
	}

	protected function simulateFrontendEnvironment($currentPageId) {
			$GLOBALS['TSFE'] = new stdClass();

			$template = t3lib_div::makeInstance('t3lib_TStemplate');
			// do not log time-performance information
			$template->tt_track = 0;
			$template->init();
			$template->getFileName_backPath = PATH_site;

			// Get the root line
			$sysPage = t3lib_div::makeInstance('t3lib_pageSelect');

			// get the rootline for the current page
			$rootline = $sysPage->getRootLine($currentPageId);

			// This generates the constants/config + hierarchy info for the template.
			$template->runThroughTemplates($rootline, 0);
			$template->generateConfig();

			$typoScriptSetup = $template->setup;

			$GLOBALS['TSFE']->tmpl = $template;
			$GLOBALS['TSFE']->tmpl->setup = $typoScriptSetup;
			$GLOBALS['TSFE']->config = array(
				'config' => $typoScriptSetup['config.'],
				// necessary for realurl
				'mainScript' => 'index.php'
			);
			$GLOBALS['TSFE']->sys_page = t3lib_div::makeInstance('t3lib_pageSelect');

			if (!is_object($GLOBALS['TT'])) {
				$GLOBALS['TT'] = t3lib_div::makeInstance('t3lib_timeTrack');
				$GLOBALS['TT']->start();
			}
	}

	protected function getComments($pid) {
		$content = '';

		$selectFields = 'uid, firstname, lastname, homepage, content, crdate, email';
		$whereClause = 'hidden = 0 AND deleted = 0 AND approved = 1 AND external_prefix = \'pages\' AND pid = ' . $pid;

		$comments = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
			$selectFields,
			'tx_comments_comments',
			$whereClause,
			'',
			'crdate ASC'
		);

		$commentTemplate = <<<COMMENTTEMPLATE
			<wp:comment>
				<wp:comment_id>%s</wp:comment_id>
				<wp:comment_author>%s</wp:comment_author>
				<wp:comment_author_email>%s</wp:comment_author_email>
				<wp:comment_date_gmt>%s</wp:comment_date_gmt>
				<wp:comment_content><![CDATA[%s]]></wp:comment_content>
				<wp:comment_approved>1</wp:comment_approved>
				<wp:comment_parent>0</wp:comment_parent>
			</wp:comment>

COMMENTTEMPLATE;

		while ($comment = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($comments)) {
			$commentContent = nl2br($comment['content']);

			if (1 == t3lib_div::_GP('removeNewlinesAfterNl2br')) {
				$commentContent = str_replace("\r\n", "", $commentContent);
				$commentContent = str_replace("\n" , "", $commentContent);
			}

			$content .= sprintf($commentTemplate,
				$comment['uid'],
				$comment['firstname'] . ('' !== $comment['lastname'] ? ' ' . $comment['lastname'] : ''),
				1 != t3lib_div::_GP('anonymousMail') ? $comment['email'] : t3lib_div::_GP('anonymousMailAddress'),
				date('Y-m-d H:i:s', $comment['crdate']),
				$commentContent
			);
		}

		return $content;
	}
}
?>