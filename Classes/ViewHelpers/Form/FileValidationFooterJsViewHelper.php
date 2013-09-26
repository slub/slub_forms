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
class Tx_SlubForms_ViewHelpers_Form_FileValidationFooterJsViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * Looks for already checked form from last request
	 *
	 * @param Tx_SlubForms_Domain_Model_Fields $field
	 * @param Tx_SlubForms_Domain_Model_Fieldsets $fieldset
	 * @return string
	 * @api
	 */
	public function render($field = NULL, $fieldset = NULL) {

		// get field configuration
		$config = $this->configToArray($field->getConfiguration());
		if (!empty($config['file-accept-mimetypes'])) {
			// e.g. file-mimetypes = audio/*, image/*, application/
			$js1 = '<script>
					$("#tx_slubforms_sf-field-'.$fieldset->getUid().'-'.$field->getUid().'").rules("add", {
					required: '.($field->getRequired() ? 'true' : 'false').',
					accept: "'.$config['file-accept-mimetypes'].'"';
					if (!empty($config['file-accept-size']))
						$js1 .= ',
							filesize: '.$config['file-accept-size'];
			$js1 .= '});
			</script>
			';
		}


		// dirty but working. Has to be called after the <form> and the jqueryvalidation validate()
		$GLOBALS['TSFE']->additionalFooterData['tx_slub_forms'] = $js1;

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
