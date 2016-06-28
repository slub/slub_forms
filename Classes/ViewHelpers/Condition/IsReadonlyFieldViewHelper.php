<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Alexander Bigga <alexander.bigga@slub-dresden.de>, SLUB Dresden
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
 * Check if given link is local or not
 *
 * = Examples =
 *
 * <code title="Defaults">
 * <f:if condition="<sf:condition.IsSenderEmail field='{field}' />">
 * </code>
 * <output>
 * 1
 * </output>
 *
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @api
 */

class Tx_SlubForms_ViewHelpers_Condition_IsReadonlyFieldViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractConditionViewHelper {


	/**
	 * renders <f:then> child if $condition is true, otherwise renders <f:else> child.
	 *
	 * @param Tx_SlubForms_Domain_Model_Fields $field
	 * @return string the rendered string
	 * @api
	 */
	public function render($field) {

		// get field configuration
		$config = Tx_SlubForms_Helper_ArrayHelper::configToArray($field->getConfiguration());

		if (!empty($config['prefill'])) {
			// values may be comma separated:
			// e.g. prefill = fe_users:username, fe_users:email, news:news
			$serialArguments = explode(",", $config['prefill']);
			$condition = FALSE;

			foreach($serialArguments as $id => $singleArgument) {
				// e.g. fe_users:username
				//  or  value:1
				// first value is database "value" or "fe_users"
				$settingPair = explode(":", $singleArgument);
				switch (trim($settingPair[0])) {

					case 'fe_users':
						if (!empty($GLOBALS['TSFE']->fe_user->user[ trim($settingPair[1]) ])) {
							$condition = TRUE;
						}
						break;

				}

			}

		}

		if ($condition) {

			return $this->renderThenChild();

		} else {

			return $this->renderElseChild();

		}
	}

}
?>

