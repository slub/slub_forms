<?php
namespace Slub\SlubForms\Controller;

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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Annotation as Extbase;

/**
 *
 *
 * @package slub_forms
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class EmailController extends AbstractController
{

    /**
     * @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher
     */
    protected $signalSlotDispatcher;

    /**
     * Inject SignalSlotDispatcher
     *
     * @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher
     */
    public function injectSignalSlotDispatcher(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher)
    {
        $this->signalSlotDispatcher = $signalSlotDispatcher;
    }

    /**
     * action list
     *
     * @return void
     */
    public function listAction() {
        $emails = $this->emailRepository->findAll();
        $this->view->assign('emails', $emails);
    }

    /**
     * action show
     *
     * @param \Slub\SlubForms\Domain\Model\Email $email
     * @return void
     */
    public function showAction(\Slub\SlubForms\Domain\Model\Email $email) {
        $this->view->assign('email', $email);
    }

    /**
     * action new
     *
     * @param \Slub\SlubForms\Domain\Model\Email $newEmail
     * @Extbase\IgnoreValidation("newEmail")
     * @return void
     */
    public function newAction(\Slub\SlubForms\Domain\Model\Email $newEmail = null) {

        $singleFormShortname = $this->getParametersSafely('form');

        // form is shown by default
        $formDisabled = false;
        $params = [];
        // check if form should be disabled
        $this->signalSlotDispatcher->dispatch(
            __CLASS__,
            'checkFormAvailability',
            [&$params]
        );

        if (isset($params['formDisabled'])) {
            $formDisabled = $params['formDisabled'];
        }

        if (!empty($singleFormShortname)) {

            /**
             * $singleFormShortname may be string or integer (via realurl)
             *
             * realurl e.g. "slubforms/userform" --> uid of form
             *
             * "tx_slubforms_sf[form]=userform" --> userform
             *
             */
            if (\TYPO3\CMS\Core\Utility\MathUtility::canBeInterpretedAsInteger($singleFormShortname)) {
                $singleForm = $this->formsRepository->findAllById($singleFormShortname);
            } else {
                $singleForm = $this->formsRepository->findAllByShortname($singleFormShortname);
            }

            // if no form is found getFirst() will return false and that's what we want
            $this->view->assign('singleForm', $singleForm->getFirst());

        }

        if (!empty($this->settings['formsSelection'])) {
            // show only forms selected in flexform
            $forms = $this->formsRepository->findAllByUidsTree(GeneralUtility::intExplode(',', $this->settings['formsSelection'], TRUE));

            if (count($forms) == 1) {
                $this->view->assign('singleForm', $this->formsRepository->findAllByUids(GeneralUtility::intExplode(',', $this->settings['formsSelection'], TRUE))->getFirst());
            }

        } else {
            // take all
            $forms = $this->formsRepository->findAll();
        }

        $this->view->assign('newEmail', $newEmail);
        $this->view->assign('forms', $forms);
        $this->view->assign('formDisabled', $formDisabled);
    }

    /**
     * action create
     *
     * @param \Slub\SlubForms\Domain\Model\Email $newEmail
     * @param array $field Field Values
     * @Extbase\Validate("\Slub\SlubForms\Domain\Validator\FieldValidator", param="field")
     * @return void
     */
    public function createAction(\Slub\SlubForms\Domain\Model\Email $newEmail, array $field = array()) {

        $fieldParameter = $this->getParametersSafely('field');

        $form = $this->formsRepository->findAllById($newEmail->getForm())->getFirst();

        $fileNames = [];

        // walk through all fieldsets
        foreach($fieldParameter as $getfieldset => $getfields) {

            $fieldset = $this->fieldsetsRepository->findByUid($getfieldset);
            $allfields = $fieldset->getFields();

            foreach($allfields as $id => $field) {

                if (isset($getfields[$field->getUid()])) {
                    // checkbox-value is only transmitted if checked but should be always in email content
                    // the value (1/0) may be converted in a configured string (value = TRUE : FALSE)
                    if ($field->getType() == 'Checkbox') {

                        $config = \Slub\SlubForms\Helper\ArrayHelper::configToArray($field->getConfiguration());
                        if (!empty($config['value'])) {
                            $settingPair = explode(":", $config['value']);
                            // take true value
                            $content[$field->getTitle()] = ($getfields[$field->getUid()] == 1) ? $settingPair[0] : $settingPair[1];
                        } else {

                            $content[$field->getTitle()] = $getfields[$field->getUid()];

                        }
                    } else if ($field->getType() == 'Radio') {

                        $config = \Slub\SlubForms\Helper\ArrayHelper::configToArray($field->getConfiguration());
                        // radioOption = text of the value to choose : integer value
                        if (!empty($config['radioOption'])) {

                            foreach ($config['radioOption'] as $radioOption) {
                                // take true value
                                if ((int)$radioOption[1] == (int)$getfields[$field->getUid()]) {
                                    $content[$field->getTitle()] = $radioOption[0];
                                }
                            }

                        } else {

                            $content[$field->getTitle()] = $getfields[$field->getUid()];

                        }
                    } else if ($field->getType() == 'File') {

                        if (isset($_FILES['tx_slubforms_sf']) && ($_FILES['tx_slubforms_sf']['error']['field'][$getfieldset][$field->getUid()] == UPLOAD_ERR_OK)) {

                            $content[$field->getTitle()] = $_FILES['tx_slubforms_sf']['name']['field'][$getfieldset][$field->getUid()];

                            $fileResource = $this->objectManager->get(\TYPO3\CMS\Core\Utility\File\BasicFileUtility::class);
                            // get filename
                            $fileName = $fileResource->getUniqueName(
                                $_FILES['tx_slubforms_sf']['name']['field'][$getfieldset][$field->getUid()],
                                GeneralUtility::getFileAbsFileName('uploads/tx_slubforms/')
                            );

                            // copy temp file to uploads
                            GeneralUtility::upload_copy_move (
                                $_FILES['tx_slubforms_sf']['tmp_name']['field'][$getfieldset][$field->getUid()],
                                $fileName
                            );
                            $fileNames[] = $fileName;
                        } else {

                            $content[$field->getTitle()] = '-';

                        }

                    } else if ($field->getType() == 'Captcha') {

                        $content[$field->getTitle()] = '-';

                    } else {

                        $content[$field->getTitle()] = empty($getfields[$field->getUid()]) ? '-' : $getfields[$field->getUid()];

                    }

                    if ($field->getIsSenderEmail()) {

                        $senderEmail['address'] = $getfields[$field->getUid()];
                        $senderEmail['required'] = $field->getRequired();

                    } else if ($field->getIsSenderName()) {

                        $senderName = $getfields[$field->getUid()];

                    }

                } else if ($field->getType() == 'Checkbox') {

                        $config = \Slub\SlubForms\Helper\ArrayHelper::configToArray($field->getConfiguration());

                        if (!empty($config['value'])) {
                            $settingPair = explode(":", $config['value']);
                            // take false value
                            $content[$field->getTitle()] = $settingPair[1];
                        }
                        else {
                            $content[$field->getTitle()] = $getfields[$field->getUid()];
                        }

                } else if ($field->getType() == 'Description') {

                        continue;

                } else {

                    $content[$field->getTitle()] = '-';

                }
            }

        }

        $contentText = '<ul>';
        foreach ($content as $fieldName => $value) {
            $contentText .= '<li><b>'.$fieldName . '</b>: '. nl2br($value).'</li>';
        }
        $contentText .= '</ul>';

        $newEmail->setContent(trim($contentText));

        // check for senderEmail
        // It may be empty if no senderEmail-Field has been sent. This happens in case of the anonymous function which
        // disables the input fields
        if (!empty($senderEmail['address'])) {

            $newEmail->setSenderEmail($senderEmail['address']);

        } else {

            // check if extra anonymous field is set like session key editcode
            $anonymous = $this->getParametersSafely('anonymous');
            // if required is set, we ignore the anonymous session key anyhow. little stupid, but...
            if ($this->settings['anonymEmails']['allow'] && $this->settings['anonymEmails']['defaultEmailAddress']
                && (($anonymous === $this->getSessionData('editcode')) || !$senderEmail['required'])) {

                $newEmail->setSenderEmail($this->settings['anonymEmails']['defaultEmailAddress']);

            } else {
                // we can't send an email without the senderEmail -->forward back to newAction
                $this->forward('new', NULL, NULL, array('form' => $form->getUid()));
            }
        }

        // check for senderName (once more)
        if (!empty($senderName)) {
            $newEmail->setSenderName($senderName);
        } else {
            // if nothing helps, we can send without the senderName but we have to set something.
            $newEmail->setSenderName('-');
        }

        // set sender IP when config is set
        if ($this->settings['storeSenderIP']) {
            $newEmail->setSenderIp(GeneralUtility::getIndpEnv('REMOTE_ADDR'));
        }

        $settings = array();
        // add signal before sending Email
        $this->signalSlotDispatcher->dispatch(
            __CLASS__,
            'beforeEmailStorage',
            array($newEmail, $fieldParameter, &$settings)
        );

        // if there is any error detected, we won't send and store this mail.
        if (! isset($settings['error'])) {

            // persist the email first, to access the uid later on in the email
            $this->emailRepository->add($newEmail);

            $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
            $persistenceManager->persistAll();

            // email to customer
            // send only if "sendConfirmationEmailToCustomer" TS setting is true
            if ($this->settings['sendConfirmationEmailToCustomer'] && $newEmail->getSenderEmail() != $this->settings['anonymEmails']['defaultEmailAddress']) {
                $this->sendTemplateEmail(
                    array($newEmail->getSenderEmail() => $newEmail->getSenderName()),
                    array($this->settings['senderEmailAddress'] => LocalizationUtility::translate('slub-forms.senderEmailName', 'slub_forms') . ' - noreply'),
                    array(),
                    LocalizationUtility::translate('slub-forms.senderSubject', 'slub_forms') . ' ' . $form->getTitle(),
                    'ConfirmEmail',
                    array(	'email' => $newEmail,
                        'form' => $form,
                        'content' => $content,
                        'settings' => $this->settings,
                    )
                );
            }

            // email to form owner

            $senderEmail = $newEmail->getSenderEmail();
            if($this->settings['overwriteFromEmailAdressToOwner'] && strlen($this->settings['overwriteFromEmailAdressToOwner']) > 0) {
                $senderEmail = $this->settings['overwriteFromEmailAdressToOwner'];
            }
            $replyto = array();
            if($this->settings['setReplyTo'] && intval($this->settings['setReplyTo']) === 1) {
                $replyto = array($newEmail->getSenderEmail() => '');
            }

            $this->sendTemplateEmail(
                array($form->getRecipient() => ''),
                array($senderEmail => $newEmail->getSenderName()),
                $replyto,
                LocalizationUtility::translate('tx_slubforms_domain_model_email.form', 'slub_forms') . ': ' . $form->getTitle() . ': '. $newEmail->getSenderName(). ', '. $newEmail->getSenderEmail() ,
                'FormEmail',
                array(	'email' => $newEmail,
                    'form' => $form,
                    'content' => $content,
                    'filenames' => $fileNames,
                    'settings' => $this->settings,
                )
            );

            // remove $fileNames from uploads-directory
            if (!empty($fileNames)) {
                foreach ($fileNames as $fileName) {
                    unlink($fileName);
                }
            }

        }

        // reset session data
        $this->setSessionData('editcode', '');

        if (! empty($this->settings['pageShowForm'])) {

            $this->uriBuilder->setTargetPageUid($this->settings['pageShowForm']);

            $newsUri = $this->uriBuilder->uriFor(
                'detail',
                array('news' => $settings['newsid'][0],
                    'day' => $settings['newsid'][1],
                    'month' => $settings['newsid'][2],
                    'year' => $settings['newsid'][3]
                    ),
                'News',
                'news',
                'pi1');

            $this->redirectToURI($newsUri);
        }

        $this->view->assign('content', $content);
        $this->view->assign('form', $form);
        $this->view->assign('email', $newEmail);
    }

    /**
     * action delete
     *
     * @param \Slub\SlubForms\Domain\Model\Email $email
     * @return void
     */
    public function deleteAction(\Slub\SlubForms\Domain\Model\Email $email) {
        $this->emailRepository->remove($email);
        $this->redirect('list');
    }

    /**
     * Set session data
     *
     * @param $key
     * @param $data
     * @return
     */
    public function setSessionData($key, $data) {

        $GLOBALS["TSFE"]->fe_user->setKey("ses", $key, $data);

        return;
    }

    /**
     * Get session data
     *
     * @param $key
     * @return
     */
    public function getSessionData($key) {

        return $GLOBALS["TSFE"]->fe_user->getKey("ses", $key);
    }

    /**
     * sendTemplateEmail
     *
     * @param array $recipient recipient of the email in the format array('recipient@domain.tld' => 'Recipient Name')
     * @param array $sender sender of the email in the format array('sender@domain.tld' => 'Sender Name')
     * @param array $replyto replyto of the email in the format array('sender@domain.tld' => 'Sender Name')
     * @param string $subject subject of the email
     * @param string $templateName template name (UpperCamelCase)
     * @param array $variables variables to be passed to the Fluid view
     * @return boolean TRUE on success, otherwise false
     */
    protected function sendTemplateEmail(array $recipient, array $sender, array $replyto, $subject, $templateName, array $variables = array()) {

        /** @var \TYPO3\CMS\Fluid\View\StandaloneView $emailViewHTML */
        $emailViewHTML = $this->objectManager->get(\TYPO3\CMS\Fluid\View\StandaloneView::class);

        $emailViewHTML->getRequest()->setControllerExtensionName('SlubForms');
        $emailViewHTML->setFormat('html');
        $emailViewHTML->assignMultiple($variables);

        $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        $templateRootPath = GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPath']);
        $partialRootPath = GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['partialRootPath']);

        $emailViewHTML->setTemplatePathAndFilename($templateRootPath . 'Email/' . $templateName . '.html');

        /** @var $message \TYPO3\CMS\Core\Mail\MailMessage */
        $message = $this->objectManager->get(\TYPO3\CMS\Core\Mail\MailMessage::class);

        $message->setTo($recipient)
                ->setFrom($sender)
                ->setReplyTo($replyto)
                ->setSubject($subject);

        $emailTextHTML = $emailViewHTML->render();

        $message->setBody()->text($this->html2rest($emailTextHTML));
        $message->setBody()->html($emailTextHTML);

        if (!empty($variables['filenames'])){
            foreach ($variables['filenames'] as $fileName) {
                $message->attachFromPath($fileName);
            }
        }

        $message->send();

        return $message->isSent();
    }

    /**
     * html2rest
     *
     * this converts the HTML email to something Rest-Style like text form
     *
     * @param $htmlString
     * @return
     */
    public function html2rest($text) {

        $text = strip_tags( html_entity_decode($text, ENT_COMPAT, 'UTF-8'), '<br>,<p>,<b>,<h1>,<h2>,<h3>,<h4>,<h5>,<a>,<li>');
        // header is getting **
        $text = preg_replace('/<h[1-5]>|<\/h[1-5]>/', "**", $text);
        // bold is getting * ([[\w\ \d:\/~\.\?\=&%\"]+])
        $text = preg_replace('/<b>|<\/b>/', "*", $text);
        // get away links but preserve href with class slub-event-link
        $text = preg_replace('/(<a[\ \w\=\"]{0,})(class=\"slub-event-link\" href\=\")([\w\d:\-\/~\.\?\=&%]+)([\"])([\"]{0,1}>)([\ \w\d\p{P}]+)(<\/a>)/', "$6\n$3", $text);
        // Remove separator characters (like non-breaking spaces...)
        $text = preg_replace( '/\p{Z}/u', ' ', $text );
        $text = str_replace('<br />', "\n", $text);
        // get away paragraphs including class, title etc.
        $text = preg_replace('/<p[\s\w\=\"]*>(?s)(.*?)<\/p>/u', "$1\n", $text);
        $text = str_replace('<li>', "- ", $text);
        $text = str_replace('</li>', "\n", $text);
        // remove multiple spaces
        $text = preg_replace('/[\ ]{2,}/', ' ', $text);
        // remove multiple tabs
        $text = preg_replace('/[\t]{1,}/', "\t", $text);
        // remove more than one empty line
        $text = preg_replace('/[\n]{3,}/', "\n\n", $text);
        // yes, really do CRLF to let quoted printable work as expected!
        $text = preg_replace('/[\n]/', "\r\n", $text);
        // remove all remaining html tags
        $text = strip_tags($text);

        return $text;
    }

}
