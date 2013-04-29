<?php
namespace Dreadwarrior\Vantomas\Task;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Thomas Juhnke (tommy@van-tomas.de)
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Taskcenter\TaskInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * CommentsDisqusExportTask exports ext:comments records
 *
 * @author Thomas Juhnke <tommy@van-tomas.de>
 */
class CommentsDisqusExportTask implements TaskInterface {

	/**
	 *
	 * @var \TYPO3\CMS\Taskcenter\Controller\TaskModuleController
	 */
	protected $taskObject;

	/**
	 *
	 * @var \TYPO3\CMS\Core\Database\QueryGenerator
	 */
	protected $queryGenerator;

	/**
	 *
	 * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
	 */
	protected $cObj;

	/**
	 *
	 * @param \TYPO3\CMS\Taskcenter\Controller\TaskModuleController $taskObject
	 */
	public function __construct(\TYPO3\CMS\Taskcenter\Controller\TaskModuleController $taskObject) {
		$this->taskObject = $taskObject;

		$this->queryGenerator = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Database\\QueryGenerator');

		$this->cObj = GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer');
	}

	public function getTask() {
		$content = '';

		$content = $this->getForm();

		if (NULL !== GeneralUtility::_GP('submit')) {
			$content .= '<br><h2>Export:</h2>';
			$content .= '<div style="width: 550px; height: 300px; overflow: auto; padding: 10px; border: 1px solid #cecece; background-color: #ffffff;">' . $this->processExport(intval(GeneralUtility::_GP('page'))) . '</div>';
		}

		return $content;
	}

	public function getOverview() {
		return '<p>I will export all ext:comments records into a Disqus generic import file (WXR).</p>';
	}

	protected function getForm() {
		$content = '<br><h2>Export options</h2>
		<form action="" method="post" enctype="multipart/form-data">
			<fieldset class="fields">
				<div class="row">
					<label for="page">Starting pint:</label>
					<select id="page" name="page">
						' . $this->getPagesAsOptions() .'
					</select>
				</div>
				<div class="row">
					<label for="linkPrefix">Article link prefix:</label>
					<input id="linkPrefix" name="linkPrefix" type="text" value="http://www.example.org/" size="30" />
				</div>
				<div class="row">
					<label for="anonymousMail">Enable anonymous mail:</label>
					<input id="anonymousMail" name="anonymousMail" type="checkbox" value="1" checked="checked" />
				</div>
				<div class="row">
					<label for="anonymousMailAddress">Anonymous mail address:</label>
					<input id="anonymousMailAddress" name="anonymousMailAddress" type="input" value="anonymous@example.org" size="30" />
				</div>
				<div class="row">
					<label for="removeNewlinesAfterNl2br">Remove newlines after applying nl2br() on comment content:</label>
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

		/* @var $treeView \TYPO3\CMS\Backend\View\PageTreeView */
		$treeView = GeneralUtility::makeInstance('TYPO3\\CMS\\Backend\\View\\PageTreeView');
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
				GeneralUtility::_GP('linkPrefix') . $pageLink,
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
			$GLOBALS['TSFE'] = new \stdClass();

			/* @var $template \TYPO3\CMS\Core\TypoScript\TemplateService */
			$template = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\TypoScript\\TemplateService');
			// do not log time-performance information
			$template->tt_track = 0;
			$template->init();
			$template->getFileName_backPath = PATH_site;

			// Get the root line
			/* @var $sysPage \TYPO3\CMS\Frontend\Page\PageRepository */
			$sysPage = GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\Page\\PageRepository');

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
			$GLOBALS['TSFE']->sys_page = GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\Page\\PageRepository');

			if (!is_object($GLOBALS['TT'])) {
				$GLOBALS['TT'] = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\TimeTracker\\TimeTracker');
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

			if (1 == GeneralUtility::_GP('removeNewlinesAfterNl2br')) {
				$commentContent = str_replace("\r\n", "", $commentContent);
				$commentContent = str_replace("\n" , "", $commentContent);
			}

			$content .= sprintf($commentTemplate,
				$comment['uid'],
				$comment['firstname'] . ('' !== $comment['lastname'] ? ' ' . $comment['lastname'] : ''),
				1 != GeneralUtility::_GP('anonymousMail') ? $comment['email'] : GeneralUtility::_GP('anonymousMailAddress'),
				date('Y-m-d H:i:s', $comment['crdate']),
				$commentContent
			);
		}

		return $content;
	}
}
?>