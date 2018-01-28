<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'slub_forms',
    'Configuration/TypoScript',
    'SLUB: Form Extension'
);
