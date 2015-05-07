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
	 * Adds JS code for form validation to footer
	 *
	 * @param Tx_SlubForms_Domain_Model_Form $form
	 * @param Tx_SlubForms_Domain_Model_Fields $field
	 * @param Tx_SlubForms_Domain_Model_Fieldsets $fieldset
	 * @return void
	 * @api
	 */
	public function render($form = NULL, $field = NULL, $fieldset = NULL) {

		if ($field !== NULL) {
			// used in File.html template

			// get field configuration
			$config = $this->configToArray($field->getConfiguration());
			if (!empty($config['file-accept-mimetypes'])) {
				// e.g. file-mimetypes = audio/*, image/*, application/
				$javascriptFooter = '<script type="text/javascript">
						$("#slub-forms-field-'.$form->getUid().'-'.$fieldset->getUid().'-'.$field->getUid().'").rules("add", {
						required: '.($field->getRequired() ? 'true' : 'false').',
						accept: "'.$config['file-accept-mimetypes'].'"';
						if (!empty($config['file-accept-size']))
							$javascriptFooter .= ',
								filesize: '.$config['file-accept-size'];

				$javascriptFooter .= '});
				</script>
				';

			}
		}
		else {
			// used in New.html Template for fieldset required
			if ($fieldset->getRequired()) {

				$javascriptFooter .= '<script type="text/javascript">';

				foreach($fieldset->getFields() as $field) {

					if (in_array($field->getType(), array('Textfield', 'Radio', 'Checkbox', 'File', 'Textarea') )) {
						$javascriptFooter .= '
							$("#slub-forms-field-'.$form->getUid().'-'.$fieldset->getUid().'-'.$field->getUid().'").rules("add",
							 { require_from_group: [1, \'.requiregroup-'.$form->getUid().'-'.$fieldset->getUid().'\'],
							 });';
					}
				}

				$javascriptFooter .= "\n</script>\n";
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
			$configArray[trim($settingPair[0])] = trim($settingPair[1]);
		}
		return $configArray;
	}

}

?>
