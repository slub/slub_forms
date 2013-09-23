<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_slubforms_domain_model_forms'] = array(
	'ctrl' => $TCA['tx_slubforms_domain_model_forms']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, recipient, fieldsets, parent',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title, shortname, recipient, fieldsets, parent,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_slubforms_domain_model_forms',
				'foreign_table_where' => 'AND tx_slubforms_domain_model_forms.pid=###CURRENT_PID### AND tx_slubforms_domain_model_forms.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'title' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_forms.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'shortname' => array(
			'displayCond' => 'FIELD:sys_language_uid:=:0',
			'exclude' => 0,
			'label' => 'LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_forms.shortname',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,lower'
			),
		),
		'recipient' => array(
			'displayCond' => 'FIELD:sys_language_uid:=:0',
			'exclude' => 0,
			'label' => 'LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_forms.recipient',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'fieldsets' => array(
			'displayCond' => 'FIELD:sys_language_uid:=:0',
			'exclude' => 0,
			'label' => 'LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_forms.fieldsets',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_slubforms_domain_model_fieldsets',
				'MM' => 'tx_slubforms_forms_fieldsets_mm',
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'script' => 'wizard_edit.php',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						),
					'add' => Array(
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'add.gif',
						'params' => array(
							'table' => 'tx_slubforms_domain_model_fieldsets',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
							),
						'script' => 'wizard_add.php',
					),
				),
			),
		),
		'parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:=:0',
			'exclude' => 0,
			'displayCond' => 'FIELD:sys_language_uid:=:0',
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:slub_events/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_forms.parent',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_slubforms_domain_model_forms',
				'foreign_table_where' => ' AND (tx_slubforms_domain_model_forms.sys_language_uid = 0 OR tx_slubforms_domain_model_forms.l10n_parent = 0) AND tx_slubforms_domain_model_forms.pid = ###CURRENT_PID### ORDER BY tx_slubforms_domain_model_forms.sorting',

				'renderMode' => 'tree',
				'subType' => 'db',
				'treeConfig' => array(
					'parentField' => 'parent',
					'appearance' => array(
						'expandAll' => TRUE,
						'showHeader' => FALSE,
						'maxLevels' => 10,
						'width' => 400,
					),
				),
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems'      => 2,
			),
		),
		'forms' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
	),
);

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

?>
