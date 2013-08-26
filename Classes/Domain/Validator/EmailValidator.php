<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Alexander Bigga <alexander.bigga@slub-dresden.de>, SLUB Dresden
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
class Tx_SlubForms_Domain_Validator_EmailValidator extends Tx_Extbase_Validation_Validator_AbstractValidator {

	/**
	 * emailRepository
	 *
	 * @var Tx_SlubForms_Domain_Repository_EmailRepository
	 * @inject
	 */
	protected $emailRepository;

	/**
	 * Object Manager
	 *
	 * @var Tx_Extbase_Object_ObjectManagerInterface
	 * @inject
	 */
	protected $objectManager;


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
	 * @param Tx_SlubForms_Domain_Model_Email $newEmail
	 * @return bool
	 */
	public function isValid($newEmail) {

//			t3lib_utility_Debug::debug($newSubscriber->getEditcode(), 'getEditcode:... ');
//t3lib_utility_Debug::debug($newSubscriber, '$subscriber is empty:... ');
		if (strlen($newEmail->getSenderName())<3) {
			$error = $this->objectManager->get('Tx_Extbase_Error_Error', 'val_name', 1000);
			$this->result->forProperty('senderName')->addError($error);
			// usually $this->addError is enough but this doesn't set the CSS errorClass in the form-viewhelper :-(
//			$this->addError('val_name', 1000);

			$this->isValid = false;
		}
		if (!t3lib_div::validEmail($newEmail->getSenderEmail())) {
			$error = $this->objectManager->get('Tx_Extbase_Error_Error', 'val_email', 1100);
			$this->result->forProperty('senderEmail')->addError($error);
//			$this->addError('val_email', 1100);

			$this->isValid = false;
		}
		if ($newEmail->getEditcode() != $this->getSessionData('editcode')) {
			$error = $this->objectManager->get('Tx_Extbase_Error_Error', 'val_editcode', 1140);
			$this->result->forProperty('editcode')->addError($error);
//			$this->addError('val_editcode', 1140);
			$this->isValid = false;
		}

		return $this->isValid;
  	}
}
?>
