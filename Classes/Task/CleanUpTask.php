<?php
namespace Slub\SlubForms\Task;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 Alexander Bigga <alexander.bigga@slub-dresden.de>, SLUB Dresden
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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;

class CleanUpTask extends \TYPO3\CMS\Scheduler\Task\AbstractTask
{

    /**
     * PID of storage folder to work with
     *
     * @var integer
     */
    protected $storagePid;

    /**
     * Age (in days) of emails allowed.
     *
     * @var integer
     */
    protected $cleanupDays;

    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     */
    protected $configurationManager;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     */
    protected $persistenceManager;

    /**
     * emailRepository
     *
     * @var \Slub\SlubForms\Domain\Repository\EmailRepository
     * @inject
     */
    protected $emailRepository;

    /**
     * injectConfigurationManager
     *
     * @param \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager
     *
     * @return void
     */
    public function injectConfigurationManager(
        \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager
    ) {
        $this->configurationManager = $configurationManager;

        $this->settings = $this->configurationManager->getConfiguration(
            \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS
        );
    }

    /**
     * Set the value of the storage pid
     *
     * @param integer $storagePid UID of the storage folder for this task.
     *
     * @return void
     */
    public function setStoragePid($storagePid)
    {
        $this->storagePid = $storagePid;
    }

    /**
     * Get the value of the storage pid
     *
     * @return integer $storagePid UID of the storage folder for this task.
     */
    public function getStoragePid()
    {
        return $this->storagePid;
    }

    /**
     * Set the maximum days, emails are stored
     *
     * @param integer $cleanupDays days
     *
     * @return void
     */
    public function setCleanupDays($cleanupDays)
    {
        $this->cleanupDays = $cleanupDays;
    }

    /**
     * Get the value of the storage pid
     *
     * @return integer $cleanupDays days
     */
    public function getCleanupDays()
    {
        return $this->cleanupDays;
    }

    /**
     * initializeAction
     *
     * @return void
     */
    protected function initializeAction()
    {

        $objectManager = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class);

        $this->emailRepository = $objectManager->get(
            \Slub\SlubForms\Domain\Repository\EmailRepository::class
        );

        $this->configurationManager = $objectManager->get(
            \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::class
        );

        $this->persistenceManager = $objectManager->get(
            \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class
        );
    }

    /**
     * Function execute from the Scheduler
     *
     * @return boolean TRUE on successful execution, FALSE on error
     * @throws \InvalidArgumentException if the email template file can not be read
     */
    public function execute()
    {
        $successfullyExecuted = true;

        // do some init work...
        $this->initializeAction();

        // if a valid storagePid is given, only delete in this repository
        if (MathUtility::canBeInterpretedAsInteger($this->storagePid)) {
          // set storagePid to point extbase to the right repositories
          $configurationArray = [
              'persistence' => [
                  'storagePid' => $this->storagePid,
              ],
          ];
          $this->configurationManager->setConfiguration($configurationArray);

          // start the work...
          // Get old emails to be deleted.
          $oldEmails = $this->emailRepository->findOlderThan($this->cleanupDays);
          foreach ($oldEmails AS $object) {
            // remove one by one
              $this->emailRepository->remove($object);
          }
          // persist the repository
          $this->persistenceManager->persistAll();
        } else {
            // delete old mails global
            $this->emailRepository->deleteOlderThan($this->cleanupDays);
        }

        return $successfullyExecuted;
    }
}
