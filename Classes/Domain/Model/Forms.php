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
class Tx_SlubForms_Domain_Model_Forms extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * title
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $title;

	/**
	 * shortname
	 *
	 * @var string
	 */
	protected $shortname;

	/**
	 * Email of Recipient
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $recipient;

	/**
	 * fieldsets
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_SlubForms_Domain_Model_Fieldsets>
	 */
	protected $fieldsets;

	/**
	 * parent form
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_SlubForms_Domain_Model_Forms>
	 * @lazy
	 */
	protected $parent;

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all Tx_Extbase_Persistence_ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		/**
		 * Do not modify this method!
		 * It will be rewritten on each save in the extension builder
		 * You may modify the constructor of this class instead
		 */
		$this->fieldsets = new Tx_Extbase_Persistence_ObjectStorage();

		$this->parent = new Tx_Extbase_Persistence_ObjectStorage();
	}

	/**
	 * Returns the title
	 *
	 * @return string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the shortname
	 *
	 * @return string $shortname
	 */
	public function getShortname() {
		return $this->shortname;
	}

	/**
	 * Sets the shortname
	 *
	 * @param string $shortname
	 * @return void
	 */
	public function setShortname($shortname) {
		$this->shortname = $shortname;
	}

	/**
	 * Adds a Fieldsets
	 *
	 * @param Tx_SlubForms_Domain_Model_Fieldsets $fieldset
	 * @return void
	 */
	public function addFieldset(Tx_SlubForms_Domain_Model_Fieldsets $fieldset) {
		$this->fieldsets->attach($fieldset);
	}

	/**
	 * Removes a Fieldsets
	 *
	 * @param Tx_SlubForms_Domain_Model_Fieldsets $fieldsetToRemove The Fieldsets to be removed
	 * @return void
	 */
	public function removeFieldset(Tx_SlubForms_Domain_Model_Fieldsets $fieldsetToRemove) {
		$this->fieldsets->detach($fieldsetToRemove);
	}

	/**
	 * Returns the fieldsets
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_SlubForms_Domain_Model_Fieldsets> $fieldsets
	 */
	public function getFieldsets() {
		return $this->fieldsets;
	}

	/**
	 * Sets the fieldsets
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_SlubForms_Domain_Model_Fieldsets> $fieldsets
	 * @return void
	 */
	public function setFieldsets(Tx_Extbase_Persistence_ObjectStorage $fieldsets) {
		$this->fieldsets = $fieldsets;
	}

	/**
	 * Returns the recipient
	 *
	 * @return string $recipient
	 */
	public function getRecipient() {
		return $this->recipient;
	}

	/**
	 * Sets the recipient
	 *
	 * @param string $recipient
	 * @return void
	 */
	public function setRecipient($recipient) {
		$this->recipient = $recipient;
	}

	/**
	 * Adds a Forms
	 *
	 * @param Tx_SlubForms_Domain_Model_Forms $parent
	 * @return void
	 */
	public function addParent(Tx_SlubForms_Domain_Model_Forms $parent) {
		$this->parent->attach($parent);
	}

	/**
	 * Removes a Forms
	 *
	 * @param Tx_SlubForms_Domain_Model_Forms $parentToRemove The Forms to be removed
	 * @return void
	 */
	public function removeParent(Tx_SlubForms_Domain_Model_Forms $parentToRemove) {
		$this->parent->detach($parentToRemove);
	}

	/**
	 * Returns the parent
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_SlubForms_Domain_Model_Forms> $parent
	 */
	public function getParent() {
		return $this->parent;
	}

	/**
	 * Sets the parent
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_SlubForms_Domain_Model_Forms> $parent
	 * @return void
	 */
	public function setParent(Tx_Extbase_Persistence_ObjectStorage $parent) {
		$this->parent = $parent;
	}

}
?>
