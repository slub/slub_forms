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
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class Tx_SlubForms_Domain_Model_Email.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage SLUB Forms
 *
 * @author Alexander Bigga <alexander.bigga@slub-dresden.de>
 */
class Tx_SlubForms_Domain_Model_EmailTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_SlubForms_Domain_Model_Email
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_SlubForms_Domain_Model_Email();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getSenderNameReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setSenderNameForStringSetsSenderName() { 
		$this->fixture->setSenderName('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getSenderName()
		);
	}
	
	/**
	 * @test
	 */
	public function getSenderEmailReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setSenderEmailForStringSetsSenderEmail() { 
		$this->fixture->setSenderEmail('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getSenderEmail()
		);
	}
	
	/**
	 * @test
	 */
	public function getContentReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setContentForStringSetsContent() { 
		$this->fixture->setContent('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getContent()
		);
	}
	
	/**
	 * @test
	 */
	public function getFormReturnsInitialValueForTx_SlubForms_Domain_Model_Forms() { }

	/**
	 * @test
	 */
	public function setFormForTx_SlubForms_Domain_Model_FormsSetsForm() { }
	
}
?>