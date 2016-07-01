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
 * Add DatePicker in Footer Js
 *
 * = Examples =
 *

 *
 * @api
 * @scope prototype
 */
class Tx_SlubForms_ViewHelpers_Form_AddDatePickerViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * Adds Javascript for jquery-validation to the footer
	 *
	 * @param Tx_SlubForms_Domain_Model_Form $form
	 * @param Tx_SlubForms_Domain_Model_Fields $field
	 * @param Tx_SlubForms_Domain_Model_Fieldsets $fieldset
	 * @return void
	 * @api
	 */
	public function render($form = NULL, $field = NULL, $fieldset = NULL) {

		if ($field !== NULL) {

			$config = Tx_SlubForms_Helper_ArrayHelper::configToArray($field->getConfiguration());

			if (!empty($config['calendar'])) {

				$javascriptFooter = '
					$("#slub-forms-field-' . $form->getUid() . '-' . $fieldset->getUid() . '-' . $field->getUid() . '").datepicker({
					});
					';

				$GLOBALS['TSFE']->getPageRenderer()->addJsFooterInlineCode('slub-forms-field-' . $form->getUid() . '-' . $fieldset->getUid() . '-' . $field->getUid(), $javascriptFooter);

			}

		}

	}

}
