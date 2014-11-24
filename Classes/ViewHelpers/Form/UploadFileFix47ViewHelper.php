<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Alexander Bigga <alexander.bigga@slub-dresden.de>, SLUB Dresden
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
 * Add hidden field for file upload to fix bug in TYPO3 4.7
 *

 *
 * @api
 * @scope prototype
 */
class Tx_SlubForms_ViewHelpers_Form_UploadFileFix47ViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * Add hidden field only in TYPO3 4.7
	 *
	 * @param Tx_SlubForms_Domain_Model_Form $form
	 * @param Tx_SlubForms_Domain_Model_Fields $field
	 * @param Tx_SlubForms_Domain_Model_Fieldsets $fieldset
	 * @return string
	 * @api
	 */
	public function render($form = NULL, $field = NULL, $fieldset = NULL) {

		if (t3lib_utility_VersionNumber::convertVersionNumberToInteger(TYPO3_version) <  '6000000') {
			// TYPO3 4.7
			$hiddenField = '<input type="hidden" name="tx_slubforms_sf[field]['.$fieldset->getUid().']['.$field->getUid().']" value="dummy" />';
		} else {
			// TYPO3 6.x
			$hiddenField = '';
		}

		return $hiddenField;
	}

}

?>
