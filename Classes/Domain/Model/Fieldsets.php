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
class Fieldsets extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

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
	 * required
	 *
	 * @var boolean
	 */
	protected $required = FALSE;

	/**
	 * fields
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Slub\SlubForms\Domain\Model\Fields>
	 */
	protected $fields;

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
		$this->fields = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Adds a Fields
	 *
	 * @param \Slub\SlubForms\Domain\Model\Fields $field
	 * @return void
	 */
	public function addField(\Slub\SlubForms\Domain\Model\Fields $field) {
		$this->fields->attach($field);
	}

	/**
	 * Removes a Fields
	 *
	 * @param \Slub\SlubForms\Domain\Model\Fields $fieldToRemove The Fields to be removed
	 * @return void
	 */
	public function removeField(\Slub\SlubForms\Domain\Model\Fields $fieldToRemove) {
		$this->fields->detach($fieldToRemove);
	}

	/**
	 * Returns the fields
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Slub\SlubForms\Domain\Model\Fields> $fields
	 */
	public function getFields() {
		return $this->fields;
	}

	/**
	 * Sets the fields
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Slub\SlubForms\Domain\Model\Fields> $fields
	 * @return void
	 */
	public function setFields(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $fields) {
		$this->fields = $fields;
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
	 * Returns the required
	 *
	 * @return boolean required
	 */
	public function getRequired() {
		return $this->required;
	}

	/**
	 * Sets the required
	 *
	 * @param boolean $required
	 * @return boolean required
	 */
	public function setRequired($required) {
		$this->required = $required;
	}

}
