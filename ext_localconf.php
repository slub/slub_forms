<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Slub.' . $_EXTKEY,
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
 * realurl Hook
 */

if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('realurl')) {
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/realurl/class.tx_realurl_autoconfgen.php']['extensionConfiguration'][$_EXTKEY] =
		'EXT:' . $_EXTKEY . '/Classes/Hooks/RealUrlAutoConfiguration.php:RealUrlAutoConfiguration->addFormsConfig';
}

/**
 * provide Slots
 */
/** @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher */
$signalSlotDispatcher =
	\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');

if (TYPO3_MODE === 'BE') {
	$languageDir = $_EXTKEY . '/Resources/Private/Language/';
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Slub\\SlubForms\\Task\\CleanUpTask'] = [
			'extension'        => $_EXTKEY,
			'title'            => 'LLL:EXT:' . $languageDir . 'locallang_be.xlf:tasks.cleanup.name',
			'description'      => 'LLL:EXT:' . $languageDir . 'locallang_be.xlf:tasks.cleanup.description',
			'additionalFields' => Slub\SlubForms\Task\CleanUpTaskAdditionalFieldProvider::class
	];
}
