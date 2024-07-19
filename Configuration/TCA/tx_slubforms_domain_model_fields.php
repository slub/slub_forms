<?php

return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_fields',
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
        'searchFields' => 'title,type,configuration,required,validation,',
        'iconfile' => 'EXT:slub_forms/Resources/Public/Icons/tx_slubforms_domain_model_fields.gif'
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid,' .
            'l10n_parent, l10n_diffsource, hidden,--palette--;;1, ' .
            'title, shortname, type, description, ' .
            '--palette--;LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_field.configuration;configuration,' .
            'required, validation,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'],
    ],
    'palettes' => [
        'configuration' => [
            'showitem' => 'is_sender_email, is_sender_name, configuration',
            'canNotCollapse' => true
        ],
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
                'foreign_table' => 'tx_slubforms_domain_model_fields',
                'foreign_table_where' => 'AND tx_slubforms_domain_model_fields.pid=###CURRENT_PID### AND tx_slubforms_domain_model_fields.sys_language_uid IN (-1,0)',
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
            'label' => 'LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_fields.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'shortname' => [
            'exclude' => 0,
            'l10n_mode' => 'exclude',
            'label' => 'LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_fields.shortname',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,lower'
            ],
        ],
        'type' => [
            'exclude' => 0,
            'onChange' => 'reload',
            'label' => 'LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_fields.type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['-- please choose form field--', '--div--'],
                    ['', ''],
                    ['Textfield', 'Textfield'],
                    ['Textarea', 'Textarea'],
                    ['Select', 'Select'],
                    ['Checkbox', 'Checkbox'],
                    ['Radio', 'Radio'],
                    ['Hidden', 'Hidden'],
                    ['File', 'File'],
                    ['Submit', 'Submit'],
                    ['-- special fields --', '--div--'],
                    ['Description', 'Description'],
                    ['Captcha', 'Captcha'],
                ],
                'size' => 1,
                'maxitems' => 1,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ],
            ],
        ],
        'configuration' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_fields.configuration',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ],
            ],
        ],
        'description' => [
            'displayCond' => 'FIELD:type:=:Description',
            'exclude' => 0,
            'label' => 'LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_fields.description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
                'fieldControl' => [
                    'fullScreenRichtext' => [
                        'disabled' => false,
                        'options' => [
                            'title' => 'LLL:EXT:cms/locallang_ttc.xlf:bodytext.W.RTE',
                        ],
                    ],
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ],
                'default' => '',
            ],
        ],
        'is_sender_email' => [
            'displayCond' => 'FIELD:type:=:Textfield',
            'exclude' => 0,
            'l10n_mode' => 'exclude',
            'label' => 'LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_fields.is_sender_email',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],
        'is_sender_name' => [
            'displayCond' => 'FIELD:type:=:Textfield',
            'exclude' => 0,
            'l10n_mode' => 'exclude',
            'label' => 'LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_fields.is_sender_name',
            'config' => [
                'type' => 'check',
                'default' => 0
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
        'validation' => [
            'exclude' => 0,
            'l10n_mode' => 'exclude',
            'label' => 'LLL:EXT:slub_forms/Resources/Private/Language/locallang_db.xlf:tx_slubforms_domain_model_fields.validation',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['no validation', ''],
                    ['Text', 'text'],
                    ['Email', 'email'],
                    ['Telephone', 'tel'],
                    ['Number', 'number'],
                    ['Url', 'url'],
                    ['Checkbox', 'checkbox'],
                    ['Radiobutton', 'radiobutton'],
                    ['Captcha', 'captcha'],
                ],
                'size' => 1,
                'maxitems' => 1,
            ],
        ],
    ],
];
