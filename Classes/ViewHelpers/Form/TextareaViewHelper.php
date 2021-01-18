<?php
namespace Slub\SlubForms\ViewHelpers\Form;

/*                                                                        *
 * This script is backported from the FLOW3 package "TYPO3.Fluid".        *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 *  of the License, or (at your option) any later version.                *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use Slub\SlubForms\Domain\Model\Fields;

/**
 * Textarea view helper.
 * The value of the text area needs to be set via the "value" attribute, as with all other form ViewHelpers.
 *
 * = Examples =
 *
 * <code title="Example">
 * <f:form.textarea name="myTextArea" value="This is shown inside the textarea" />
 * </code>
 * <output>
 * <textarea name="myTextArea">This is shown inside the textarea</textarea>
 * </output>
 *
 * @api
 */
class TextareaViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Form\AbstractFormFieldViewHelper {

	/**
	 * @var string
	 */
	protected $tagName = 'textarea';

	/**
	 * Initialize the arguments.
	 *
	 * @return void
	 * @api
	 */
	public function initializeArguments() {
		parent::initializeArguments();
		$this->registerTagAttribute('rows', 'int', 'The number of rows of a text area', true);
		$this->registerTagAttribute('maxlength', 'int', 'The maximum number of characters', false);
		$this->registerTagAttribute('minlength', 'int', 'The maximum number of characters', false);
		$this->registerTagAttribute('cols', 'int', 'The number of columns of a text area', true);
		$this->registerTagAttribute('disabled', 'string', 'Specifies that the input element should be disabled when the page loads');
		$this->registerArgument('errorClass', 'string', 'CSS class to set if there are errors for this view helper', false, 'f3-form-error');
		$this->registerArgument('field', Fields::class, '@param \Slub\SlubForms\Domain\Model\Fields $field', false, null);
		$this->registerTagAttribute('required', 'bool', 'If the field is required or not', false, null);
		$this->registerUniversalTagAttributes();
	}

	/**
	 * Renders the textarea.
	 *
	 * @return string
	 * @api
	 */
	public function render() {

		$field = $this->arguments['field'];
		$required = $this->arguments['required'];

		$name = $this->getName();
		$this->registerFieldNameForFormTokenGeneration($name);

		$this->tag->forceClosingTag(true);
		$this->tag->addAttribute('name', $name);
		$this->tag->setContent($this->getValueAttribute());

		// e.g.
		// maxlength = 30000
    // minlength = 30
		// rows = 5
		// cols = 60
		$config = \Slub\SlubForms\Helper\ArrayHelper::configToArray($field->getConfiguration());
		if (!empty($config)) {

			foreach($config as $key => $value) {
				switch ($key) {
					case 'maxlength':
						$this->tag->addAttribute('maxlength', (int)$value);
						break;
          case 'minlength':
					  $this->tag->addAttribute('minlength', (int)$value);
						break;
					case 'rows':
						$this->tag->addAttribute('rows', (int)$value);
						break;
					case 'cols':
						$this->tag->addAttribute('cols', (int)$value);
						break;
				}

			}

		}

		if ($required !== null) {
				$this->tag->addAttribute('required', 'required');
		}

		$this->setErrorClassAttribute();

		return $this->tag->render();
	}

}
