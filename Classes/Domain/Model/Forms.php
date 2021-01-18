<?php
namespace Slub\SlubForms\Domain\Model;

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
use TYPO3\CMS\Extbase\Annotation as Extbase;

/**
 *
 *
 * @package slub_forms
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Forms extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * title
	 *
	 * @var string
	 * @Extbase\Validate("NotEmpty")
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
	 * @Extbase\Validate("NotEmpty")
	 */
	protected $recipient;

	/**
	 * fieldsets
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Slub\SlubForms\Domain\Model\Fieldsets>
	 */
	protected $fieldsets;

	/**
	 * parent form
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Slub\SlubForms\Domain\Model\Forms>
	 * @Extbase\ORM\Lazy
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
	 * Initializes all \TYPO3\CMS\Extbase\Persistence\ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		/**
		 * Do not modify this method!
		 * It will be rewritten on each save in the extension builder
		 * You may modify the constructor of this class instead
		 */
		$this->fieldsets = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

		$this->parent = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
	 * @param \Slub\SlubForms\Domain\Model\Fieldsets $fieldset
	 * @return void
	 */
	public function addFieldset(\Slub\SlubForms\Domain\Model\Fieldsets $fieldset) {
		$this->fieldsets->attach($fieldset);
	}

	/**
	 * Removes a Fieldsets
	 *
	 * @param \Slub\SlubForms\Domain\Model\Fieldsets $fieldsetToRemove The Fieldsets to be removed
	 * @return void
	 */
	public function removeFieldset(\Slub\SlubForms\Domain\Model\Fieldsets $fieldsetToRemove) {
		$this->fieldsets->detach($fieldsetToRemove);
	}

	/**
	 * Returns the fieldsets
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Slub\SlubForms\Domain\Model\Fieldsets> $fieldsets
	 */
	public function getFieldsets() {
		return $this->fieldsets;
	}

	/**
	 * Sets the fieldsets
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Slub\SlubForms\Domain\Model\Fieldsets> $fieldsets
	 * @return void
	 */
	public function setFieldsets(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $fieldsets) {
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
	 * @param \Slub\SlubForms\Domain\Model\Forms $parent
	 * @return void
	 */
	public function addParent(\Slub\SlubForms\Domain\Model\Forms $parent) {
		$this->parent->attach($parent);
	}

	/**
	 * Removes a Forms
	 *
	 * @param \Slub\SlubForms\Domain\Model\Forms $parentToRemove The Forms to be removed
	 * @return void
	 */
	public function removeParent(\Slub\SlubForms\Domain\Model\Forms $parentToRemove) {
		$this->parent->detach($parentToRemove);
	}

	/**
	 * Returns the parent
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Slub\SlubForms\Domain\Model\Forms> $parent
	 */
	public function getParent() {
		return $this->parent;
	}

	/**
	 * Sets the parent
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Slub\SlubForms\Domain\Model\Forms> $parent
	 * @return void
	 */
	public function setParent(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $parent) {
		$this->parent = $parent;
	}

}
