<?php
namespace Slub\SlubForms\Helper;

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

class ArrayHelper {

	/**
	 * Configformat to Array conversion
	 *
	 * e.g.
	 *
	 * prefill = value :
	 *
	 *
	 *
	 * @param string $config
	 *
	 * @return array configuration
	 *
	 */
	public static function configToArray($config) {

		$configSplit = explode("\n", $config);

		foreach ($configSplit as $id => $configLine) {

			$settingPair = explode("=", $configLine);

			switch (trim($settingPair[0])) {
				case 'radioOption':

					$optionPair = explode(":", trim($settingPair[1]));

					$configArray[trim($settingPair[0])][] = array(0 => trim($optionPair[0]), 1 => trim($optionPair[1]));

					break;
				case 'selectOption':
					if (stripos(':', $settingPair[1])) {
						// selectOption = valueString:value
						$optionPair = explode(":", trim($settingPair[1]));
						$configArray[trim($settingPair[0])][trim($optionPair[1])] = trim($optionPair[0]);
					} else {
						// selectOption = valueString
						$configArray[trim($settingPair[0])][trim($settingPair[1])] = trim($settingPair[1]);
					}

					break;
				case 'value':
				default: $configArray[trim($settingPair[0])] = trim($settingPair[1]);
					break;
			}


		}

		return $configArray;
	}

}
