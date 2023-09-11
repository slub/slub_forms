<?php
defined('TYPO3') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'SlubForms',
    'Sf',
    [
        \Slub\SlubForms\Controller\EmailController::class => 'new, create',
    ],
    // non-cacheable actions
    [
        \Slub\SlubForms\Controller\EmailController::class => 'new, create',
    ]
);

/**
 * provide Slots
 */
/** @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher */
$signalSlotDispatcher =
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');

$languageDir = 'slub_forms/Resources/Private/Language/';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Slub\\SlubForms\\Task\\CleanUpTask'] = [
    'extension' => 'slub_forms',
    'title' => 'LLL:EXT:' . $languageDir . 'locallang_be.xlf:tasks.cleanup.name',
    'description' => 'LLL:EXT:' . $languageDir . 'locallang_be.xlf:tasks.cleanup.description',
    'additionalFields' => Slub\SlubForms\Task\CleanUpTaskAdditionalFieldProvider::class
];
