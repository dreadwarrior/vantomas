<?php
class Tx_Vantomas_ViewHelpers_Resource_GetFileIdentifiersViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	public function initializeArguments() {
		parent::initializeArguments();

		$this->registerArgument('table', 'string', 'Name of the table to fetch file identifiers for.', TRUE);
		$this->registerArgument('field', 'string', 'Name of the field to fetch file identifiers for.', TRUE);
		$this->registerArgument('uid', 'integer', 'UID of the row in table.', TRUE);
	}

	public function render() {
		$fileIdentifiers = array();

		$fileRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\FileRepository');

		$table = $this->arguments['table'];
		$field = $this->arguments['field'];
		$uid = \TYPO3\CMS\Core\Utility\MathUtility::convertToPositiveInteger($this->arguments['uid']);

		$fileObjects = $fileRepository->findByRelation($table, $field, $uid);

		foreach ($fileObjects as $file) {
			$fileIdentifiers[] = $file->getIdentifier();
		}

		return implode(',', $fileIdentifiers);
	}
}
?>
