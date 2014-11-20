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

?>
