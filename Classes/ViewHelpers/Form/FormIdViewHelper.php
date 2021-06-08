<?php
namespace Slub\SlubForms\ViewHelpers\Form;

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

use Slub\SlubForms\Domain\Model\Forms;
use TYPO3\CMS\Core\Utility\MathUtility;

/**
 * Validation results view helper
 *
 * = Examples =
 *

 *
 * @api
 * @scope prototype
 */
class FormIdViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * Return variable
	 *
	 * @var integer
	 */
	private $isChecked = 0;

	/**
	 * Initialize arguments.
	 */
	public function initializeArguments()
	{
		parent::initializeArguments();
		$this->registerArgument('form', Forms::class, '@param \Slub\SlubForms\Domain\Model\Forms $form', true, null);
	}

	/**
	 * Looks for already checked form from last request
	 *
	 *
	 * @return string Rendered string
	 * @api
	 */
	public function render() {

		$form = $this->arguments['form'];

		if ($form == null)
			return $this->isChecked;

		$this->controllerContext = $this->renderingContext->getControllerContext();

		// check for GET parameter "form" which may be "shortname" OR an "uid"
		if ($this->controllerContext->getRequest()->hasArgument('form')) {
			$shortname = $this->controllerContext->getRequest()->getArgument('form');
			if (strlen($form->getShortname()) > 0) {
				// is it an integer - so maybe an uid?
				if (MathUtility::canBeInterpretedAsInteger($shortname)) {
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
				if ($formargs['form']['__identity'] == $form->getUid())
					$this->isChecked = $form->getUid();
		}

		return $this->isChecked;

	}
}
