<?php
namespace Slub\SlubForms\ViewHelpers\Form;

use TYPO3\CMS\Core\Utility\GeneralUtility;

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

use Slub\SlubForms\Domain\Model\Fields;

/**
 * Validation results view helper
 *
 * = Examples =
 *

 *
 * @api
 * @scope prototype
 */
class FieldHasValueViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper {

	 /**
	 * Initialize arguments.
	 */
	public function initializeArguments()
	{
		parent::initializeArguments();
		$this->registerArgument('field', Fields::class, '@param \Slub\SlubForms\Domain\Model\Fields $field', false, null);
	}

	/**
	 * Check for Prefill/Post values and set it manually
	 *
	 * @return string Rendered string
	 */
	public function render() {

		$field = $this->arguments['field'];

		// return already posted values e.g. in case of validation errors
		if ($this->renderingContext->getControllerContext()->getRequest()->getOriginalRequest()) {

			$postedArguments = $this->renderingContext->getControllerContext()->getRequest()->getOriginalRequest()->getArguments();

			// should be usually only one fieldset
			foreach($postedArguments['field'] as $fieldsetid => $postedFields) {

				if (isset($postedFields[$field->getUid()])) {

					return $postedFields[$field->getUid()];

				}
			}

		}

		// get field configuration
		$config = \Slub\SlubForms\Helper\ArrayHelper::configToArray($field->getConfiguration());
		if (!empty($config['prefill'])) {
			// values may be comma separated:
			// e.g. prefill = fe_users:username, fe_users:email, news:news
			$serialArguments = explode(",", $config['prefill']);
			$returnValue = array();

			foreach($serialArguments as $id => $singleArgument) {
				// e.g. fe_users:username
				//  or  value:1
				// first value is database "value" or "fe_users"
				$settingPair = explode(":", $singleArgument);
				switch (trim($settingPair[0])) {
					case 'fe_users':
						if (!empty($GLOBALS['TSFE']->fe_user->user[ trim($settingPair[1]) ])) {
							$returnValue[] = $GLOBALS['TSFE']->fe_user->user[ trim($settingPair[1]) ];
						}
						break;
					case 'news':
						// e.g. news:news
						$newsArgs = GeneralUtility::_GET('tx_news_pi1');
						$returnValue[] = $newsArgs[$settingPair[1]];
						break;
					case 'value':
						if (!empty($settingPair[1]))
							$returnValue[] = trim($settingPair[1]);
						break;
				}
			}

			return implode(',', $returnValue);
		}

		// check for prefill by GET parameter
		if ($this->renderingContext->getControllerContext()->getRequest()->hasArgument('prefill')) {

			$prefilljson = $this->renderingContext->getControllerContext()->getRequest()->getArgument('prefill');

			$prefilljson = stripslashes($prefilljson);

			$prefill = json_decode($prefilljson, true);

			if (strlen($field->getShortname()) > 0) {

				if (!empty($prefill[$field->getShortname()])) {

					return $prefill[$field->getShortname()];

				}
			}
		}

		return;
	}

}
