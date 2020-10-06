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
class FileValidationAcceptInfoViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * Initialize arguments.
	 */
	public function initializeArguments()
	{
		parent::initializeArguments();
		$this->registerArgument('field', Fields::class, '@param \Slub\SlubForms\Domain\Model\Fields $field', false, null);
	}

	/**
	 * Looks for already checked form from last request
	 *
	 * @return string
	 * @api
	 */
	public function render() 
	{
		$field = $this->arguments['field'];
		// get field configuration
		$config = \Slub\SlubForms\Helper\ArrayHelper::configToArray($field->getConfiguration());
		if (!empty($config['file-accept-info'])) {
			$info = $config['file-accept-info'];
			if (!empty($config['file-accept-size']))
				$info .= ' (max. ' . round(($config['file-accept-size'] / (1024*1024)), 1) . ' MB)';
		}
		return $info;
	}

}
