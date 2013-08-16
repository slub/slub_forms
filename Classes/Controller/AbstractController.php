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
class Tx_SlubForms_Controller_AbstractController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * emailRepository
	 *
	 * @var Tx_SlubForms_Domain_Repository_EmailRepository
	 * @inject
	 */
	protected $emailRepository;

	/**
	 * formsRepository
	 *
	 * @var Tx_SlubForms_Domain_Repository_FormsRepository
	 * @inject
	 */
	protected $formsRepository;

	/**
	 * fieldsetsRepository
	 *
	 * @var Tx_SlubForms_Domain_Repository_FieldsetsRepository
	 * @inject
	 */
	protected $fieldsetsRepository;

	/**
	 * Safely gets Parameters from request
	 * if they exist
	 *
	 * @param string $parameterName
	 * @return *
	 */
	protected function getParametersSafely($parameterName) {
		if($this->request->hasArgument( $parameterName )){
			return $this->request->getArgument( $parameterName );
		}
		return NULL;
	}


}
?>
