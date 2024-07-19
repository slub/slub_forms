<?php
namespace Slub\SlubForms\Domain\Validator;

use Slub\SlubForms\Domain\Repository\FieldsetsRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Error\Error;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Alexander Bigga <typo3@slub-dresden.de>, SLUB Dresden
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
 *
 *
 * @package slub_forms
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class FieldValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator {

    /**
     * emailRepository
     *
     * @var \Slub\SlubForms\Domain\Repository\FieldsetsRepository
     */
    protected $fieldsetsRepository;

    /**
     * @param \Slub\SlubForms\Domain\Repository\FieldsetsRepository $fieldsetsRepository
     */
    public function injectFieldsetsRepository(FieldsetsRepository $fieldsetsRepository)
    {
        $this->fieldsetsRepository = $fieldsetsRepository;
    }

    public function setOptions(array $options): void
    {
        // This method is upwards compatible with TYPO3 v12, it will be implemented
        // by AbstractValidator in v12 directly and is part of v12 ValidatorInterface.
        // @todo: Remove this method when v11 compatibility is dropped.
        $this->initializeDefaultOptions($options);
    }

    /**
     * Return variable
     *
     * @var bool
     */
    private $isValid = true;

    /**
     * Get session data
     *
     * @return
     */
    public function getSessionData($key) {

        return $GLOBALS["TSFE"]->fe_user->getKey("ses", $key);

    }

    /**
     * Validation of given Params
     *
     * @param array $field
     * @return bool
     */
    public function isValid($field) {

        $fieldGroupOk = 0;

        // should be usually only one fieldset
        foreach($field as $getfieldset => $getfields) {

            // get fieldset
            $fieldset = $this->fieldsetsRepository->findByUid($getfieldset);

            // get all (possible) fields of fieldset
            $allfields = $fieldset->getFields();

            // step through all possible fields and compare with submitted values
            foreach($allfields as $id => $singleField) {
                // check for senderEmail
                if ($singleField->getIsSenderEmail()) {
                    if (!empty($getfields[$singleField->getUid()]) && !GeneralUtility::validEmail($getfields[$singleField->getUid()])) {
                        // seems to be no valid email address
                        $error = GeneralUtility::makeInstance(Error::class, 'val_email', 1100);
                        $this->result->forProperty('senderEmail')->addError($error);
                        $this->isValid = false;
                    }
                }

                // check for senderName
                if ($singleField->getIsSenderName()) {
                    if (empty($getfields[$singleField->getUid()])) {
                        // seems to be empty
                        $error = GeneralUtility::makeInstance(Error::class, 'val_name', 1200);
                        $this->result->forProperty('senderName')->addError($error);
                        $this->isValid = false;
                    }
                }

                // check for file upload
                if ($singleField->getType() == 'File') {

                    if (isset($_FILES['tx_slubforms_sf']) && $_FILES['tx_slubforms_sf']['size']['field'][$getfieldset][$singleField->getUid()] > 0) {

                        // get field configuration
                        $config = \Slub\SlubForms\Helper\ArrayHelper::configToArray($singleField->getConfiguration());
                        if ($config['file-accept-size'] < $_FILES['tx_slubforms_sf']['size']['field'][$getfieldset][$singleField->getUid()]) {
                            // seems to be no valid file size
                            $error = GeneralUtility::makeInstance(Error::class, 'val_file_size', 1300);
                            $this->result->forProperty('content')->addError($error);
                            $this->isValid = false;
                        }

                        $found_mimetype = [];
                        // do it on the command line because there is no clean way to do it with PHP...
                        exec("file --mime-type " . $_FILES['tx_slubforms_sf']['tmp_name']['field'][$getfieldset][$singleField->getUid()] . " | cut -f 2 -d ':'", $found_mimetype);
                        $found_mimetype = explode("/", trim($found_mimetype[0]));
                        $configmimetypes =  explode(",", $config['file-accept-mimetypes'] );
                        foreach ($configmimetypes as $typeId => $type) {
                            $splittype = explode("/", trim($type));
                            $allowedtypes[$splittype[0]][] = $splittype[1];
                        }

                        // check, if the found mime-type is in the list of allowed mime-types.
                        // allowed mime-types may have a wildcard like image/* for all image formats
                        //
                        // eg
                        // $found_mimetype = array('application', 'pdf')
                        // $allowedtypes['application'] = array('pdf', 'msword', ...)

                        if (!is_array($allowedtypes[$found_mimetype[0]]) || (in_array($found_mimetype[1], $allowedtypes[$found_mimetype[0]], TRUE) === FALSE &&
                                in_array('*', $allowedtypes[$found_mimetype[0]], TRUE) === FALSE)) {
                            $error = GeneralUtility::makeInstance(Error::class, 'val_file_mimetype', 1400);
                            $this->result->forProperty('content')->addError($error);
                            $this->isValid = false;
                        } else	if ($fieldset->getRequired()) {
                                $fieldGroupOk++;
                        }

                    }

                }

                // in case the javascript validation didn't work, we have to check it again here:
                if ($singleField->getType() == 'Textfield' || $singleField->getType() == 'Textarea') {

                    switch($singleField->getValidation()) {

                        case 'text':
                            if ($singleField->getRequired()) {
                                if (empty($getfields[$singleField->getUid()])) {
                                    $error = GeneralUtility::makeInstance(Error::class, 'val_text', 1500);
                                    $this->result->forProperty('content')->addError($error);
                                    $this->isValid = false;
                                } else {
                                    $config = \Slub\SlubForms\Helper\ArrayHelper::configToArray($singleField->getConfiguration());
                                    if (!empty($config['minlength']) && $config['minlength'] > strlen($getfields[$singleField->getUid()])) {
                                        $error = GeneralUtility::makeInstance(Error::class, 'val_text_minlength', 1510);
                                        $this->result->forProperty('content')->addError($error);
                                        $this->isValid = false;
                                    } else if (!empty($config['maxlength']) && $config['maxlength'] < strlen($getfields[$singleField->getUid()])) {
                                        $error = GeneralUtility::makeInstance(Error::class, 'val_text_maxlength', 1520);
                                        $this->result->forProperty('content')->addError($error);
                                        $this->isValid = false;
                                    }
                                }
                            }
                            if ($fieldset->getRequired()) {
                                if (!empty($getfields[$singleField->getUid()])) {
                                    $fieldGroupOk++;
                                }
                            }
                            break;
                        case 'email':
                            if ($singleField->getRequired()) {
                                if ( !GeneralUtility::validEmail($getfields[$singleField->getUid()]) ) {
                                    // seems to be no valid email address
                                    $error = GeneralUtility::makeInstance(Error::class, 'val_email', 1600);
                                    $this->result->forProperty('senderEmail')->addError($error);
                                    $this->isValid = false;
                                }
                            }
                            if ($fieldset->getRequired()) {
                                if (!empty($getfields[$singleField->getUid()])) {
                                    $fieldGroupOk++;
                                }
                            }
                            break;
                        case 'number':
                            if ($singleField->getRequired()) {
                                if (!empty($getfields[$singleField->getUid()]) && !\TYPO3\CMS\Core\Utility\MathUtility::canBeInterpretedAsFloat($getfields[$singleField->getUid()])) {
                                    // seems to be no valid number
                                    $error = GeneralUtility::makeInstance(Error::class, 'val_number', 1700);
                                    $this->result->forProperty('content')->addError($error);
                                    $this->isValid = false;
                                }
                            }
                            if ($fieldset->getRequired()) {
                                if (!empty($getfields[$singleField->getUid()])) {
                                    $fieldGroupOk++;
                                }
                            }
                            break;
                        case 'tel':
                            if ($singleField->getRequired()) {
                                if (empty($getfields[$singleField->getUid()])) {
                                    $error = GeneralUtility::makeInstance(Error::class, 'val_tel', 1800);
                                    $this->result->forProperty('content')->addError($error);
                                    $this->isValid = false;
                                }
                            }
                            if ($fieldset->getRequired()) {
                                if (!empty($getfields[$singleField->getUid()])) {
                                    $fieldGroupOk++;
                                }
                            }
                            break;
                        case 'url':
                            if ($singleField->getRequired()) {
                                if (empty($getfields[$singleField->getUid()])) {
                                    $error = GeneralUtility::makeInstance(Error::class, 'val_url', 1900);
                                    $this->result->forProperty('content')->addError($error);
                                    $this->isValid = false;
                                }
                            }
                            if ($fieldset->getRequired()) {
                                if (!empty($getfields[$singleField->getUid()])) {
                                    $fieldGroupOk++;
                                }
                            }
                            break;
                                                 default:
                            if ($singleField->getRequired()) {
                                if (empty($getfields[$singleField->getUid()])) {
                                    $error = GeneralUtility::makeInstance(Error::class, 'val_default', 2000);
                                    $this->result->forProperty('content')->addError($error);
                                    $this->isValid = false;
                                }
                            }
                            if ($fieldset->getRequired()) {
                                if (!empty($getfields[$singleField->getUid()])) {
                                    $fieldGroupOk++;
                                }
                            }
                            break;
                    }

                }
                // fluid cannot add "required" on checkbox and radio buttons.
                // so check it here:
                if ($singleField->getType() == 'Radio' || $singleField->getType() == 'Checkbox') {
                    if ($singleField->getRequired()) {
                        if (empty($getfields[$singleField->getUid()])) {
                            $error = GeneralUtility::makeInstance(Error::class, 'val_radio', 2100);
                            $this->result->forProperty('content')->addError($error);
                            $this->isValid = false;
                        }
                    }
                    if ($fieldset->getRequired()) {
                        if (!empty($getfields[$singleField->getUid()])) {
                            $fieldGroupOk++;
                        }
                    }
                }

                if ($singleField->getType() == 'Captcha') {

                    $config = \Slub\SlubForms\Helper\ArrayHelper::configToArray($singleField->getConfiguration());
                    $captchaService = GeneralUtility::makeInstance(\Slub\SlubForms\Service\Captcha\FriendlyCaptcha::class);
                    $validCaptcha = $captchaService->verify($getfields[$singleField->getUid()], $config);

                    if ($singleField->getRequired()) {
                        if (!$validCaptcha) {
                            $error = $this->objectManager->get(\TYPO3\CMS\Extbase\Error\Error::class, 'val_captcha', 2100);
                            $this->result->forProperty('content')->addError($error);
                            $this->isValid = false;
                        }
                    }
                    if ($fieldset->getRequired()) {
                        if ($validCaptcha) {
                            $fieldGroupOk++;
                        }
                    }

                }

            }

            // if fieldset is required, check fields once more...
            if ($fieldset->getRequired() && $fieldGroupOk == 0) {

                $error = GeneralUtility::makeInstance(Error::class, 'val_group', 2200);
                $this->result->forProperty('content')->addError($error);
                $this->isValid = false;

            }

        }

        return $this->isValid;
      }

}
