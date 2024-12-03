<?php
namespace Slub\SlubForms\ViewHelpers\Form;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;

class ParseConfigurationViewHelper extends AbstractViewHelper {


    /**
     * Register arguments.
     * @return void
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('configurationString', 'string', 'Config string', true);

    }

    /**
     * @return string
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        
        $templateVariableContainer = $renderingContext->getVariableProvider();

        if ($templateVariableContainer->exists('configuration')) {
            $templateVariableContainer->remove('configuration');
        }
        $templateVariableContainer->add('configuration', \Slub\SlubForms\Helper\ArrayHelper::configToArray($arguments['configurationString']));

        return $renderChildrenClosure();
        
    }


}