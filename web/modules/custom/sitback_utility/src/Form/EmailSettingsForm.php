<?php

/**
 * @file
 * Contains Drupal\ad_manager\AdManagerSettingsForm
 */

namespace Drupal\sitback_utility\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use WebDriver\Exception;


class EmailSettingsForm extends FormBase
{

    public function getFormId()
    {
        return 'email_settings_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $config = \Drupal::config('core.utility_config');
        $form['email_address'] = array(
            '#type' => 'email',
            '#title' => $this->t('Email Address'),
            '#description' => $this->t('Email address to submit payment information'),
            '#default_value' => $config->get('email_address'),
            '#required' => TRUE,
        );

        $form['submit'] = array('#type' => 'submit', '#value' => $this->t('Save'));

        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        try{
            $config =\Drupal::service('config.factory')->getEditable('core.utility_config');
            $config->set('email_address', $form_state->getValue('email_address'));
            $config->save();
            \Drupal::messenger()->addMessage($this->t('Configuration saved successfully.'));

        } catch ( Exception $exception){

            \Drupal::messenger()->addMessage($this->t('Something wrong saving configuration.'), 'error');
        }



    }
}
