<?php
defined('TYPO3') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Slub.SlubForms',
	'Sf',
	array(
		'Email' => 'new, create',
	),
	// non-cacheable actions
	array(
		'Email' => 'new, create',
	)
);

/**
 * provide Slots
 */
/** @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher */
$signalSlotDispatcher =
	\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');

$languageDir = $_EXTKEY . '/Resources/Private/Language/';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Slub\\SlubForms\\Task\\CleanUpTask'] = [
        'extension'        => $_EXTKEY,
        'title'            => 'LLL:EXT:' . $languageDir . 'locallang_be.xlf:tasks.cleanup.name',
        'description'      => 'LLL:EXT:' . $languageDir . 'locallang_be.xlf:tasks.cleanup.description',
        'additionalFields' => Slub\SlubForms\Task\CleanUpTaskAdditionalFieldProvider::class
];
