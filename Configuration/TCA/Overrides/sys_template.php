<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'slub_forms',
    'Configuration/TypoScript',
    'SLUB: Form Extension'
);
