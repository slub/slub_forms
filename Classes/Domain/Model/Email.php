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
class Email extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * senderName
	 *
	 * @var string
	 */
	protected $senderName;

	/**
	 * senderEmail
	 *
	 * @var string
	 */
	protected $senderEmail;

	/**
	 * content
	 *
	 * @var string
	 */
	protected $content;

	/**
	 * form
	 *
	 * @var \Slub\SlubForms\Domain\Model\Forms
	 */
	protected $form;

	/**
	 * Edit Code
	 *
	 * @var string
	 */
	protected $editcode;

	/**
	 * Returns the form
	 *
	 * @return \Slub\SlubForms\Domain\Model\Forms $form
	 */
	public function getForm() {
		return $this->form;
	}

	/**
	 * Sets the form
	 *
	 * @param \Slub\SlubForms\Domain\Model\Forms $form
	 * @return void
	 */
	public function setForm(\Slub\SlubForms\Domain\Model\Forms $form) {
		$this->form = $form;
	}

	/**
	 * Returns the senderName
	 *
	 * @return string $senderName
	 */
	public function getSenderName() {
		return $this->senderName;
	}

	/**
	 * Sets the senderName
	 *
	 * @param string $senderName
	 * @return void
	 */
	public function setSenderName($senderName) {
		$this->senderName = $senderName;
	}

	/**
	 * Returns the senderEmail
	 *
	 * @return string $senderEmail
	 */
	public function getSenderEmail() {
		return $this->senderEmail;
	}

	/**
	 * Sets the senderEmail
	 *
	 * @param string $senderEmail
	 * @return void
	 */
	public function setSenderEmail($senderEmail) {
		$this->senderEmail = $senderEmail;
	}

	/**
	 * Returns the content
	 *
	 * @return string $content
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * Sets the content
	 *
	 * @param string $content
	 * @return void
	 */
	public function setContent($content) {
		$this->content = $content;
	}

	/**
	 * Returns the editcode
	 *
	 * @return string $editcode
	 */
	public function getEditcode() {
		return $this->editcode;
	}

	/**
	 * Sets the editcode
	 *
	 * @param string $editcode
	 * @return void
	 */
	public function setEditcode($editcode) {
		$this->editcode = $editcode;
	}

}
