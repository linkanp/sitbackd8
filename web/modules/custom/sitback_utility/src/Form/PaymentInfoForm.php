<?php

/**
 * @file
 * Contains Drupal\ad_manager\AdManagerSettingsForm
 */

namespace Drupal\sitback_utility\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use WebDriver\Exception;


class PaymentInfoForm extends FormBase
{

    public function getFormId()
    {
        return 'payment_info_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['information'] = array(
            '#type' => 'vertical_tabs',
            '#default_tab' => 'edit-credit_card',
        );
        $form['credit_card'] = array(
            '#type' => 'details',
            '#title' => $this->t('Credit Card'),
            '#group' => 'information',
        );
        $form['credit_card']['credit_name'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Name'),
            '#description' => $this->t('Name of the card holder.'),
            '#required' => true
        );
        $form['credit_card']['credit_number'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Number'),
            '#description' => $this->t('Card number must be 16 digits.'),
        );
        $form['credit_card']['credit_cvv'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('CVV'),
            '#description' => $this->t('Card number must be 3 digits.'),
        );
        $form['voucher'] = array(
            '#type' => 'details',
            '#title' => $this->t('Voucher'),
            '#group' => 'information',
        );
        $form['voucher']['voucher_name'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Voucher Name'),
            '#required' => true
        );
        $form['voucher']['voucher_number'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Voucher Number'),
        );

        $form['submit'] = array('#type' => 'submit', '#value' => $this->t('Submit'));

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {
        if (strlen($form_state->getValue('credit_number')) != 16) {
            $form_state->setErrorByName('credit_number', $this->t('Card number must be 16 digits'));
        }
        if (strlen($form_state->getValue('credit_cvv')) != 3) {
            $form_state->setErrorByName('credit_cvv', $this->t('CVV must be 3 digits'));
        }
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        try{
            $config = \Drupal::config('core.utility_config');
            $email = $config->get('email_address');
            $form_values = [
                'credit_name' => $form_state->getValue('credit_name'),
                'credit_number' => $form_state->getValue('credit_number'),
                'credit_cvv' => $form_state->getValue('credit_cvv'),
                'voucher_name' => $form_state->getValue('voucher_name'),
                'voucher_number' => $form_state->getValue('voucher_number'),
            ];

            \Drupal::service('plugin.manager.mail')->mail('sitback_utility', 'payment_info', $email, \Drupal::languageManager()->getDefaultLanguage()->getId(), $form_values);
            $messenger = \Drupal::messenger();
            $messenger->addMessage($this->t('Payment information submitted successfully.'));

        } catch ( Exception $exception){
            print_r($exception->getMessage());

            \Drupal::messenger()->addMessage($this->t('There is something wrong submitting your information.'), 'error');
        }



    }
}
