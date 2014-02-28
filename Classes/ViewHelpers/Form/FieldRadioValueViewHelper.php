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
 * Validation results view helper
 *
 * = Examples =
 *

 *
 * @api
 * @scope prototype
 */
class Tx_SlubForms_ViewHelpers_Form_FieldRadioValueViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * Check for Prefill/Post values and set it manually
	 *
	 * @param Tx_SlubForms_Domain_Model_Fields $field
	 *
	 * @return string Rendered string
	 * @api
	 */
	public function render($field) {

		// get field configuration
		$config = $this->configToArray($field->getConfiguration());
		if (!empty($config['radioOption'])) {
			// e.g. fe_users:username
			//  or  valueString:1
			// first value is database "value" or "fe_users"
			return $config['radioOption'];
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
			$optionPair = explode(":", trim($settingPair[1]));
			$configArray[trim($settingPair[0])][] = array(0 => trim($optionPair[0]), 1 => trim($optionPair[1]));
		}
		return $configArray;
	}
}

?>
