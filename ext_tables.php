<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Sf',
	'SLUB: Forms'
);

$pluginSignature = str_replace('_','',$_EXTKEY) . '_sf';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_sf.xml');

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'SLUB Forms');

t3lib_extMgm::addLLrefForTCAdescr('tx_slubforms_domain_model_fieldsets', 'EXT:slub_forms/Resources/Private/Language/locallang_csh_tx_slubforms_domain_model_fieldsets.xlf');
t3lib_extMgm::allowTableOnStandardPages('tx_slubforms_domain_model_fieldsets');
$TCA['tx_slubforms_domain_model_fieldsets'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_fieldsets',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'requestUpdate' => 'sys_language_uid',
		'searchFields' => 'title,fields,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Fieldsets.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_slubforms_domain_model_fieldsets.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_slubforms_domain_model_forms', 'EXT:slub_forms/Resources/Private/Language/locallang_csh_tx_slubforms_domain_model_forms.xlf');
t3lib_extMgm::allowTableOnStandardPages('tx_slubforms_domain_model_forms');
$TCA['tx_slubforms_domain_model_forms'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_forms',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'requestUpdate' => 'sys_language_uid',
		'searchFields' => 'title,recipient,fieldsets,parent,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Forms.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_slubforms_domain_model_forms.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_slubforms_domain_model_fields', 'EXT:slub_forms/Resources/Private/Language/locallang_csh_tx_slubforms_domain_model_fields.xlf');
t3lib_extMgm::allowTableOnStandardPages('tx_slubforms_domain_model_fields');
$TCA['tx_slubforms_domain_model_fields'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_fields',
		'label' => 'title',
		'label_alt' => 'required, shortname',
		'label_alt_force' => TRUE,
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'requestUpdate' => 'sys_language_uid,type',
		'searchFields' => 'title,type,configuration,required,validation,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Fields.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_slubforms_domain_model_fields.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_slubforms_domain_model_email', 'EXT:slub_forms/Resources/Private/Language/locallang_csh_tx_slubforms_domain_model_email.xlf');
t3lib_extMgm::allowTableOnStandardPages('tx_slubforms_domain_model_email');
$TCA['tx_slubforms_domain_model_email'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_email',
		'label' => 'sender_name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'sender_name,sender_email,content,form,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Email.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_slubforms_domain_model_email.gif'
	),
);

?>
