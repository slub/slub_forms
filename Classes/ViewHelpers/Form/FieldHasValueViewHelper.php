<?php

/*                                                                        *
 * This script is backported from the FLOW3 package "TYPO3.Fluid".        *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 *  of the License, or (at your option) any later version.                *
 *                                                                        *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * Validation results view helper
 *
 * = Examples =
 *

 *
 * @api
 * @scope prototype
 */
class Tx_SlubForms_ViewHelpers_Form_FieldHasValueViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * Check for Prefill/Post values and set it manually
	 *
	 * @param Tx_SlubForms_Domain_Model_Fields $field
	 *
	 * @return string Rendered string
	 * @api
	 */
	public function render($field) {


		// return already posted values e.g. in case of validation errors
		if ($this->controllerContext->getRequest()->getOriginalRequest()) {
			$postedArguments = $this->controllerContext->getRequest()->getOriginalRequest()->getArguments();

			// should be usually only one fieldset
			foreach($postedArguments['field'] as $fieldsetid => $postedFields) {

				return $postedFields[$field->getUid()];

			}

		}

		// get field configuration

		$config = $this->configToArray($field->getConfiguration());
		if (!empty($config['prefill'])) {
			// e.g. fe_users:username
			// first value is database table... forget it ;-)
			$settingPair = explode(":", $config['prefill']);
			if (!empty($GLOBALS['TSFE']->fe_user->user[ trim($settingPair[1]) ])) {

				return $GLOBALS['TSFE']->fe_user->user[ trim($settingPair[1]) ];

			}
		}

		// check for prefill by GET parameter
		if ($this->controllerContext->getRequest()->hasArgument('prefill')) {
			$prefilljson = $this->controllerContext->getRequest()->getArgument('prefill');
			$prefill = json_decode($prefilljson);
			if (strlen($field->getShortname())>0) {
				//~ $shortname =  trim($config['shortname']);
				if (!empty($prefill->{$field->getShortname()}))
					return $prefill->{$field->getShortname()};
			}
		}

		return;
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
			$configArray[trim($settingPair[0])] = trim($settingPair[1]);
		}
		return $configArray;
	}
}

?>
