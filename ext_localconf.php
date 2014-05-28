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

?>
