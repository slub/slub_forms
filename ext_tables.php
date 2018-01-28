<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Slub.' . $_EXTKEY,
	'Sf',
	'SLUB: Forms'
);

$pluginSignature = str_replace('_','',$_EXTKEY) . '_sf';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_sf.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tt_content.pi_flexform.'.$pluginSignature.'.list', 'EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_csh_be.xlf');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_slubforms_domain_model_fieldsets', 'EXT:slub_forms/Resources/Private/Language/locallang_csh_tx_slubforms_domain_model_fieldsets.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_slubforms_domain_model_fieldsets');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_slubforms_domain_model_forms', 'EXT:slub_forms/Resources/Private/Language/locallang_csh_tx_slubforms_domain_model_forms.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_slubforms_domain_model_forms');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_slubforms_domain_model_fields', 'EXT:slub_forms/Resources/Private/Language/locallang_csh_tx_slubforms_domain_model_fields.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_slubforms_domain_model_fields');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_slubforms_domain_model_email', 'EXT:slub_forms/Resources/Private/Language/locallang_csh_tx_slubforms_domain_model_email.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_slubforms_domain_model_email');
