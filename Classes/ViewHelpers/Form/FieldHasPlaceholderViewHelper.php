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
 * Give Placeholder Value of Field if set
 *
 * = Examples =
 *

 *
 * @api
 * @scope prototype
 */
class Tx_SlubForms_ViewHelpers_Form_FieldHasPlaceholderViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * Check for Prefill/Post values and set it manually
	 *
	 * @param \Slub\SlubForms\Domain\Model\Fields $field
	 * @param string $show
	 *
	 * @return string Rendered string
	 */
	public function render($field) {

		// get field configuration
		$config = \Slub\SlubForms\Helper\ArrayHelper::configToArray($field->getConfiguration());

		if (!empty($config['placeholder'])) {

			return $config['placeholder'];

		} else {

			return '';
		}

	}

}
