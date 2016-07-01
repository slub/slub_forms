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
class Tx_SlubForms_ViewHelpers_Form_FormIdViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * Return variable
	 *
	 * @var integer
	 */
	private $isChecked = 0;

	/**
	 * Looks for already checked form from last request
	 *
	 * @param Tx_SlubForms_Domain_Model_Form $form
	 * @return string Rendered string
	 * @api
	 */
	public function render($form = NULL) {

		if ($form == NULL)
			return 0;

		// check for GET parameter "form" which may be "shortname" OR an "uid"
		if ($this->controllerContext->getRequest()->hasArgument('form')) {
			$shortname = $this->controllerContext->getRequest()->getArgument('form');
			//~ t3lib_utility_Debug::debug($shortname, 'shortname: ... ');
			if (strlen($form->getShortname()) > 0) {
				// is it an integer - so maybe an uid?
				if (t3lib_utility_Math::canBeInterpretedAsInteger($shortname)) {
					if ($form->getUid() == $shortname)
						$this->isChecked = $form->getUid();
				} else
					if ($form->getShortname() == $shortname)
						$this->isChecked = $form->getUid();
			}
		}

		// check for POST parameter "__identity" which indicates that the
		// form has been posted already and some error occured
		if ($this->controllerContext->getRequest()->getOriginalRequest()) {
			$formargs = $this->controllerContext->getRequest()->getOriginalRequest()->getArgument('newEmail');
			//~ t3lib_utility_Debug::debug($formargs, 'formIdViewHelper: ... ' . $formargs['form']['__identity'] .' ' .$form->getUid() );
				if ($formargs['form']['__identity'] == $form->getUid())
					$this->isChecked = $form->getUid();
		}

		//~ t3lib_utility_Debug::debug($this->isChecked, 'isChecked: ... ');
		return $this->isChecked;

	}
}
