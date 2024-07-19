<?php

namespace Slub\SlubForms\Task;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 Alexander Bigga <typo3@slub-dresden.de>, SLUB Dresden
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package slub_forms
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */

use TYPO3\CMS\Core\Utility\MathUtility;
use TYPO3\CMS\Scheduler\AbstractAdditionalFieldProvider;
use TYPO3\CMS\Scheduler\Task\Enumeration\Action;

class CleanUpTaskAdditionalFieldProvider extends AbstractAdditionalFieldProvider
{

    /**
     * Render additional information fields within the scheduler backend.
     *
     * @param array $taskInfo Array information of task to return
     * @param CleanUpTask $task Task object
     * @param \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $schedulerModule Reference to the BE module of the Scheduler
     *
     * @return array Additional fields
     * @see \TYPO3\CMS\Scheduler\AdditionalFieldProviderInterface->getAdditionalFields($taskInfo, $task, $schedulerModule)
     */
    public function getAdditionalFields(
        array                                                     &$taskInfo,
                                                                  $task,
        \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $schedulerModule
    )
    {
        $additionalFields = [];

        if (empty($taskInfo['storagePid'])) {
            if ($schedulerModule->getCurrentAction() == Action::ADD) {
                $taskInfo['storagePid'] = '';
            } elseif ($schedulerModule->getCurrentAction() == Action::EDIT) {
                $taskInfo['storagePid'] = $task->getStoragePid();
            } else if ($task) {
                $taskInfo['storagePid'] = $task->getStoragePid();
            }
        }

        if (empty($taskInfo['cleanupDays'])) {
            if ($schedulerModule->getCurrentAction() == Action::ADD) {
                $taskInfo['cleanupDays'] = '';
            } elseif ($schedulerModule->getCurrentAction() == Action::EDIT) {
                $taskInfo['cleanupDays'] = $task->getCleanupDays();
            } else {
                $taskInfo['cleanupDays'] = $task->getCleanupDays();
            }
        }

        $fieldId = 'task_storagePid';
        $fieldCode = '<input type="text" name="tx_scheduler[slub_forms][storagePid]" id="' . $fieldId . '" value="' . htmlspecialchars($taskInfo['storagePid']) . '"/>';
        $label = $GLOBALS['LANG']->sL('LLL:EXT:slub_forms/Resources/Private/Language/locallang_be.xlf:tasks.cleanup.storagePid');
        $additionalFields[$fieldId] = [
            'code' => $fieldCode,
            'label' => $label
        ];

        $fieldId = 'task_cleanupDays';
        $fieldCode = '<input type="text" name="tx_scheduler[slub_forms][cleanupDays]" id="' . $fieldId . '" value="' . htmlspecialchars($taskInfo['cleanupDays']) . '"/>';
        $label = $GLOBALS['LANG']->sL('LLL:EXT:slub_forms/Resources/Private/Language/locallang_be.xlf:tasks.cleanup.cleanupDays');
        $additionalFields[$fieldId] = [
            'code' => $fieldCode,
            'label' => $label
        ];

        return $additionalFields;
    }

    /**
     * This method checks any additional data that is relevant to the specific task.
     * If the task class is not relevant, the method is expected to return TRUE.
     *
     * @param array $submittedData Reference to the array containing the data submitted by the user
     * @param \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $schedulerModule Reference to the BE module of the Scheduler
     *
     * @return boolean TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
     */
    public function validateAdditionalFields(
        array                                                     &$submittedData,
        \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $schedulerModule
    )
    {
        $isValid = true;

        // if (!MathUtility::canBeInterpretedAsInteger($submittedData['slub_forms']['storagePid'])) {
        //     $isValid = false;
        //     $schedulerModule->addMessage(
        //         $GLOBALS['LANG']->sL('LLL:EXT:slub_forms/Resources/Private/Language/locallang_be.xlf:tasks.cleanup.invalidStoragePid') . ': ' . $submittedData['slub_forms']['storagePid'],
        //         \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR
        //     );
        // }

        if (!MathUtility::canBeInterpretedAsInteger($submittedData['slub_forms']['cleanupDays'])) {
            $isValid = false;
            $this->addMessage(
                $GLOBALS['LANG']->sL('LLL:EXT:slub_forms/Resources/Private/Language/locallang_be.xlf:tasks.cleanup.invalidCleanupDays') . ': ' . $submittedData['slub_forms']['cleanupDays'],
                \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR
            );
        }

        return $isValid;
    }

    /**
     * This method is used to save any additional input into the current task object
     * if the task class matches.
     *
     * @param array $submittedData Array containing the data submitted by the user
     * @param \TYPO3\CMS\Scheduler\Task\AbstractTask $task Reference to the current task object
     *
     * @return void
     */
    public function saveAdditionalFields(array $submittedData, \TYPO3\CMS\Scheduler\Task\AbstractTask $task)
    {
        /** @var $task CleanUpTask */
        $task->setStoragePid($submittedData['slub_forms']['storagePid']);
        $task->setCleanupDays($submittedData['slub_forms']['cleanupDays']);
    }
}
