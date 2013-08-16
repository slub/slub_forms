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
class Tx_SlubForms_Domain_Model_Fields extends Tx_Extbase_DomainObject_AbstractValueObject {

	/**
	 * title
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $title;

	/**
	 * type
	 *
	 * @var integer
	 */
	protected $type;

	/**
	 * configuration
	 *
	 * @var string
	 */
	protected $configuration;

	/**
	 * required
	 *
	 * @var boolean
	 */
	protected $required = FALSE;

	/**
	 * validation
	 *
	 * @var integer
	 */
	protected $validation;

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
	 * Returns the type
	 *
	 * @return string $type
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Sets the type
	 *
	 * @param string $type
	 * @return void
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * Returns the configuration
	 *
	 * @return string $configuration
	 */
	public function getConfiguration() {
		return $this->configuration;
	}

	/**
	 * Sets the configuration
	 *
	 * @param string $configuration
	 * @return void
	 */
	public function setConfiguration($configuration) {
		$this->configuration = $configuration;
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

	/**
	 * Returns the validation
	 *
	 * @return integer $validation
	 */
	public function getValidation() {
		return $this->validation;
	}

	/**
	 * Sets the validation
	 *
	 * @param integer $validation
	 * @return void
	 */
	public function setValidation($validation) {
		$this->validation = $validation;
	}

}

?>