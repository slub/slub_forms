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
class Tx_SlubForms_Domain_Repository_FormsRepository extends Tx_Extbase_Persistence_Repository {

	/**
	 * Finds all datasets by MM relation categories
	 *
	 * @param string formIds separated by comma
	 * @return array The found Category Objects
	 */
	public function findAllByUids($formIds) {

								$query = $this->createQuery();

								$constraints = array();
								$constraints[] = $query->in('uid', $formIds);

								if (count($constraints)) {
									$query->matching($query->logicalAnd($constraints));
								}

								return $query->execute();
	}

	/**
	 * Finds all datasets by MM relation categories
	 *
	 * @param string formIds separated by comma
	 * @return array The found Category Objects
	 */
	public function findAllById($formId) {

		$query = $this->createQuery();

		$constraints = array();
		$constraints[] = $query->equals('uid', $formId);

		if (count($constraints)) {
			$query->matching($query->logicalAnd($constraints));
		}

		return $query->execute();
	}


	/**
	 * Finds all datasets and return in tree order
	 *
	 * @param string formIds separated by comma
	 * @return array The found Event Objects
	 */
	public function findAllByUidsTree($formIds) {

								$categories = $this->findAllByUids($formIds);

								$flatCategories = array();
								foreach ($categories as $category) {
									$flatCategories[$category->getUid()] = Array(
										'item' =>  $category,
										'parent' => ($category->getParent()->current()) ? $category->getParent()->current()->getUid() : NULL
									);
								}

								$tree = array();
								foreach ($flatCategories as $id => &$node) {
									if ($node['parent'] === NULL) {
										$tree[$id] = &$node;
									} else {
										$flatCategories[$node['parent']]['children'][$id] = &$node;
									}
								}
				//~ t3lib_utility_Debug::debug($tree, 'findAllByUidsTree: ... ');
								return $tree;
	}

}

?>
