<?php
namespace Slub\SlubForms\ViewHelpers\Form;
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

	use Slub\SlubForms\Domain\Model\Forms;
	use Slub\SlubForms\Domain\Model\Fields;
	use Slub\SlubForms\Domain\Model\Fieldsets;

	/**
	 * Validation results view helper
	 *
	 * = Examples =
	 *

	 *
	 * @api
	 * @scope prototype
	 */
	class RadioValidationFooterJsViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

		/**
		 * Initialize arguments.
		 */
		public function initializeArguments()
		{
			parent::initializeArguments();
			$this->registerArgument('form', Forms::class, '@param \Slub\SlubForms\Domain\Model\Forms $form', true, null);
			$this->registerArgument('field', Fields::class, '@param \Slub\SlubForms\Domain\Model\Fields $field', false, null);
			$this->registerArgument('fieldset', Fieldsets::class, '@param \Slub\SlubForms\Domain\Model\Fieldsets $fieldset', true, null);
		}

		/**
		 * Adds Javascript for jquery-validation to the footer
		 *
		 * @param \Slub\SlubForms\Domain\Model\Form $form
		 * @param \Slub\SlubForms\Domain\Model\Fields $field
		 * @param \Slub\SlubForms\Domain\Model\Fieldsets $fieldset
		 * @return void
		 * @api
		 */
		public function render() {

			$form = $this->arguments['form'];
			$field = $this->arguments['field'];
			$fieldset = $this->arguments['fieldset'];

			if ($field !== NULL) {

				$config = \Slub\SlubForms\Helper\ArrayHelper::configToArray($field->getConfiguration());

				// set all radio input fields to required
				if (!empty($config['radioOption'])) {

					if ($field->getRequired()) {
						$javascriptFooter = '$(".requiregroup-'.$form->getUid().'-'.$fieldset->getUid().'").rules("add", {
								required: '.($field->getRequired() ? 'true' : 'false').'
							 });';
					}
				}
			}

			$GLOBALS['TSFE']->getPageRenderer()->addJsFooterInlineCode('slub-forms-field-'.$form->getUid().'-'.$fieldset->getUid().'-'.$field->getUid(), $javascriptFooter);

		}

	}
