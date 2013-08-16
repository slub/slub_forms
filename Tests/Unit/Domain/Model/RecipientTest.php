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
 * Test case for class Tx_SlubForms_Domain_Model_Recipient.
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
class Tx_SlubForms_Domain_Model_RecipientTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_SlubForms_Domain_Model_Recipient
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_SlubForms_Domain_Model_Recipient();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getTitleReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTitleForStringSetsTitle() { 
		$this->fixture->setTitle('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getTitle()
		);
	}
	
	/**
	 * @test
	 */
	public function getEmailReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setEmailForStringSetsEmail() { 
		$this->fixture->setEmail('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getEmail()
		);
	}
	
	/**
	 * @test
	 */
	public function getDescriptionReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setDescriptionForStringSetsDescription() { 
		$this->fixture->setDescription('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getDescription()
		);
	}
	
	/**
	 * @test
	 */
	public function getParentReturnsInitialValueForObjectStorageContainingTx_SlubForms_Domain_Model_Recipient() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getParent()
		);
	}

	/**
	 * @test
	 */
	public function setParentForObjectStorageContainingTx_SlubForms_Domain_Model_RecipientSetsParent() { 
		$parent = new Tx_SlubForms_Domain_Model_Recipient();
		$objectStorageHoldingExactlyOneParent = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneParent->attach($parent);
		$this->fixture->setParent($objectStorageHoldingExactlyOneParent);

		$this->assertSame(
			$objectStorageHoldingExactlyOneParent,
			$this->fixture->getParent()
		);
	}
	
	/**
	 * @test
	 */
	public function addParentToObjectStorageHoldingParent() {
		$parent = new Tx_SlubForms_Domain_Model_Recipient();
		$objectStorageHoldingExactlyOneParent = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneParent->attach($parent);
		$this->fixture->addParent($parent);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneParent,
			$this->fixture->getParent()
		);
	}

	/**
	 * @test
	 */
	public function removeParentFromObjectStorageHoldingParent() {
		$parent = new Tx_SlubForms_Domain_Model_Recipient();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($parent);
		$localObjectStorage->detach($parent);
		$this->fixture->addParent($parent);
		$this->fixture->removeParent($parent);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getParent()
		);
	}
	
}
?>