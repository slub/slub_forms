<?php
namespace Slub\SlubForms\Domain\Validator;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Alexander Bigga <typo3@slub-dresden.de>, SLUB Dresden
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

 use Slub\SlubForms\Domain\Repository\EmailRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Error\Error;

/**
 *
 *
 * @package slub_forms
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class EmailValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator {

	/**
	 * emailRepository
	 *
	 * @var \Slub\SlubForms\Domain\Repository\EmailRepository
	 */
	protected $emailRepository;

	/**
     * @param \Slub\SlubForms\Domain\Repository\EmailRepository $emailRepository
     */
    public function injectEmailRepository(EmailRepository $emailRepository)
    {
        $this->emailRepository = $emailRepository;
    }

    public function setOptions(array $options): void
    {
        // This method is upwards compatible with TYPO3 v12, it will be implemented
        // by AbstractValidator in v12 directly and is part of v12 ValidatorInterface.
        // @todo: Remove this method when v11 compatibility is dropped.
        $this->initializeDefaultOptions($options);
    }

	/**
	 * Return variable
	 *
	 * @var bool
	 */
	private $isValid = true;

	/**
	 * Get session data
	 *
	 * @return
	 */
	public function getSessionData($key) {

		return $GLOBALS["TSFE"]->fe_user->getKey("ses", $key);

	}

	/**
	 * Validation of given Params
	 *
	 * @param \Slub\SlubForms\Domain\Model\Email $newEmail
	 * @return bool
	 */
	public function isValid($newEmail) {

		if ($newEmail->getEditcode() != $this->getSessionData('editcode')) {
			$error = GeneralUtility::makeInstance(Error::class, 'val_editcode', 1140);
			$this->result->forProperty('editcode')->addError($error);
			$this->isValid = false;
		}

		return $this->isValid;
  	}
}
