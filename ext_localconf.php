<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
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

if (t3lib_extMgm::isLoaded('realurl')) {
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/realurl/class.tx_realurl_autoconfgen.php']['extensionConfiguration'][$_EXTKEY] =
		'EXT:' . $_EXTKEY . '/Classes/Hooks/RealUrlAutoConfiguration.php:Tx_SlubForms_Hooks_RealUrlAutoConfiguration->addFormsConfig';
}

/**
 * provide Slots
 */
	if (t3lib_utility_VersionNumber::convertVersionNumberToInteger(TYPO3_version) <  '6000000') {
		// TYPO3 4.7
		$signalSlotDispatcher = t3lib_div::makeInstance('Tx_Extbase_Object_Manager')->get('Tx_Extbase_SignalSlot_Dispatcher');
	} else {
		// TYPO3 6.x
		/** @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher */
		$signalSlotDispatcher =
			\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');
	}


?>
