<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_slubforms_domain_model_fields'] = array(
	'ctrl' => $TCA['tx_slubforms_domain_model_fields']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, type, is_sender_email, is_sender_name, configuration, required, validation',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title, type, configuration, required, validation,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'),
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
				'foreign_table' => 'tx_slubforms_domain_model_fields',
				'foreign_table_where' => 'AND tx_slubforms_domain_model_fields.pid=###CURRENT_PID### AND tx_slubforms_domain_model_fields.sys_language_uid IN (-1,0)',
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
			'label' => 'LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_fields.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'type' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_fields.type',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('-- Label --', 0),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'configuration' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_fields.configuration',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
		'is_sender_email' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_fields.is_sender_email',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),
		'is_sender_name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_fields.is_sender_name',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),

		'required' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_fields.required',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),
		'validation' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_fields.validation',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('-- Label --', 0),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
	),
);

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

$TCA['tx_slubforms_domain_model_fields']['types'] = array (
				'1' => array('showitem' => 'sys_language_uid;;;;1-1-1,'.
				'l10n_parent, l10n_diffsource, hidden;;1, '.
				'title, type, '.
				'--palette--;LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_field.configuration;configuration,'.
				'required, validation,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'),
);
$TCA['tx_slubforms_domain_model_fields']['palettes'] = array (
		'configuration' => array(
			'showitem' => 'is_sender_email, is_sender_name, configuration',
			'canNotCollapse' => TRUE
		),
);

$TCA['tx_slubforms_domain_model_fields']['columns']['type'] = array(

			'exclude' => 0,
			'label' => 'LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_fields.type',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('-- please choose --', '--div--'),
					array('Textfield', 'Textfield'),
					array('Textarea', 'Textarea'),
					array('Checkbox', 'Checkbox'),
					array('Radio', 'Radio'),
					array('Submit', 'Submit'),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
);
$TCA['tx_slubforms_domain_model_fields']['columns']['validation'] = array(
			'exclude' => 0,
			'label' => 'LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_fields.validation',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('no validation', 0),
					array('Email', 1),
					array('Telephone', 2),
					array('Number', 3),
					array('...', 4),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
);
?>
