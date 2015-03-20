<?php
	/***************************************************************
	 *  Copyright notice
	 *
	 *  (c) 2015 Alexander Bigga <alexander.bigga@slub-dresden.de>, SLUB Dresden
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
	 * Validation results view helper
	 *
	 * = Examples =
	 *

	 *
	 * @api
	 * @scope prototype
	 */
	class Tx_SlubForms_ViewHelpers_Form_RadioValidationFooterJsViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

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

				$config = $this->configToArray($field->getConfiguration());

				// set all radio input fields to required
				if (!empty($config['radioOption'])) {

					if ($field->getRequired()) {
						$javascriptFooter = '<script type="text/javascript">';
						foreach ($config['radioOption'] as $id => $val) {
							$javascriptFooter .= '
								$("#slub-forms-field-'.$form->getUid().'-'.$fieldset->getUid().'-'.$field->getUid().'-'.$id.'").rules("add", {
									required: '.($field->getRequired() ? 'true' : 'false').'
								 });';
						}
						$javascriptFooter .= '</script>';
					}
				}
			}

			// dirty but working. Has to be called after the <form> and the jqueryvalidation validate()
			// getPagerender() doesn't work in 4.7.x....
			// see: http://forge.typo3.org/issues/22273
			$GLOBALS['TSFE']->additionalFooterData['tx_slub_forms'] .= $javascriptFooter;

		}

		/**
		 *
		 * @param string $config
		 *
		 * @return array configuration
		 *
		 */
		private function configToArray($config) {

			$configSplit = explode("\n", $config);
			foreach ($configSplit as $id => $configLine) {
				$settingPair = explode("=", $configLine);
				$optionPair = explode(":", trim($settingPair[1]));
				$configArray[trim($settingPair[0])][] = array(0 => trim($optionPair[0]), 1 => trim($optionPair[1]));
			}
			return $configArray;
		}

	}

?>
