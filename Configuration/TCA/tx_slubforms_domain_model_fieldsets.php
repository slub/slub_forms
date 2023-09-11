<?php

return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_fieldsets',
        'label' => 'title',
        'label_alt' => 'required, shortname',
        'label_alt_force' => true,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'sortby' => 'sorting',
        'versioningWS' => true,
        'origUid' => 't3_origuid',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'title,fields,',
        'iconfile' => 'EXT:slub_forms/Resources/Public/Icons/tx_slubforms_domain_model_fieldsets.gif'
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid,
        l10n_parent, l10n_diffsource, hidden,--palette--;;1, title, shortname, required,
        fields,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'],
    ],
    'palettes' => [
        '1' => ['showitem' => ''],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'language'
            ]
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_slubforms_domain_model_fieldsets',
                'foreign_table_where' => 'AND tx_slubforms_domain_model_fieldsets.pid=###CURRENT_PID### AND tx_slubforms_domain_model_fieldsets.sys_language_uid IN (-1,0) ORDER BY tx_slubforms_domain_model_fieldsets.title',
                'default' => 0,
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.enabled',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 0,
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ]
        ],
        'starttime' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => [
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ],
            ],
        ],
        'endtime' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => [
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ],
            ],
        ],
        'title' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_fieldsets.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'shortname' => [
            'exclude' => 0,
            'l10n_mode' => 'exclude',
            'label' => 'LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_fieldsets.shortname',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,lower'
            ],
        ],
        'required' => [
            'exclude' => 0,
            'l10n_mode' => 'exclude',
            'label' => 'LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_fields.required',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],
        'fields' => [
            'exclude' => 0,
            'l10n_mode' => 'exclude',
            'label' => 'LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_fieldsets.fields',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_slubforms_domain_model_fields',
                'foreign_table_where' => ' AND (tx_slubforms_domain_model_fields.sys_language_uid IN (-1,0) OR tx_slubforms_domain_model_fields.l10n_parent = 0) AND tx_slubforms_domain_model_fields.pid = ###CURRENT_PID### ORDER BY tx_slubforms_domain_model_fields.sorting',
                'MM' => 'tx_slubforms_fieldsets_fields_mm',
                'size' => 10,
                'autoSizeMax' => 30,
                'maxitems' => 9999,
                'multiple' => 0,
                'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                        'options' => [
                            'title' => 'Edit',
                            'windowOpenParameters' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
                        ],
                    ],
                    'addRecord' => [
                        'disabled' => false,
                        'options' => [
                            'pid' => '###CURRENT_PID###',
                            'setValue' => 'prepend',
                            'table' => 'tx_slubforms_domain_model_fields',
                            'title' => 'Create new',
                        ]
                    ],
                ],
                'wizards' => [
                    '_PADDING' => 1,
                    '_VERTICAL' => 1,
                    'suggest' => [
                            'type' => 'suggest'
                    ],
                ],
            ],
        ],
    ],
];
