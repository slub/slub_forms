<?php
namespace Slub\SlubForms\ViewHelpers\Form;
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
class FileValidationFooterJsViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * Adds JS code for form validation to footer
	 *
	 * @param \Slub\SlubForms\Domain\Model\Form $form
	 * @param \Slub\SlubForms\Domain\Model\Fields $field
	 * @param \Slub\SlubForms\Domain\Model\Fieldsets $fieldset
	 * @return void
	 * @api
	 */
	public function render($form = NULL, $field = NULL, $fieldset = NULL) {

		if ($field !== NULL) {
			// used in File.html template

			// get field configuration
			$config = \Slub\SlubForms\Helper\ArrayHelper::configToArray($field->getConfiguration());
			if (!empty($config['file-accept-mimetypes'])) {
				// e.g. file-mimetypes = audio/*, image/*, application/
				$javascriptFooter = '$("#slub-forms-field-'.$form->getUid().'-'.$fieldset->getUid().'-'.$field->getUid().'").rules("add", {
						required: '.($field->getRequired() ? 'true' : 'false').',
						accept: "'.$config['file-accept-mimetypes'].'"';
						if (!empty($config['file-accept-size']))
							$javascriptFooter .= ',
								filesize: '.$config['file-accept-size'];
				$javascriptFooter .= '});
				';

			}
		}
		else {
			// used in New.html Template for fieldset required
			if ($fieldset->getRequired()) {

				foreach($fieldset->getFields() as $field) {

					if (in_array($field->getType(), array('Textfield', 'Radio', 'Checkbox', 'File', 'Textarea') )) {
						$javascriptFooter .= '
							$("#slub-forms-field-'.$form->getUid().'-'.$fieldset->getUid().'-'.$field->getUid().'").rules("add",
							 { require_from_group: [1, \'.requiregroup-'.$form->getUid().'-'.$fieldset->getUid().'\'],
							 });';
					}
				}

			}

		}

		$GLOBALS['TSFE']->getPageRenderer()->addJsFooterInlineCode('slub-forms-field-'.$form->getUid().'-'.$fieldset->getUid().'-'.$field->getUid(), $javascriptFooter);

	}

}
