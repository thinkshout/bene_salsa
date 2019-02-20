<?php

namespace Drupal\bene_salsa\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Your Settings.
 */
class BeneSalsaSettings extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'bene_salsa_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['bene_salsa.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);

    // Add form header describing purpose and use of form.
    $form['header'] = [
      '#type' => 'markup',
      '#markup' => t('<h3>Salsa Embed Configuration</h3><p>Include form widget code configuration for Salsa Forms.</p>'),
    ];

    $settings = $this->config('bene_salsa.settings')->get();
    $form['sign-up'] = [
      '#title' => 'Sign Up Form',
      '#type' => 'textfield',
      '#default_value' => isset($settings['sign-up']) ? $settings['sign-up'] : '',
      '#description' => t('The Form Widget Code for the Sign Up Form'),
    ];

    $form['fundraising'] = [
      '#title' => 'Fundraising Form',
      '#type' => 'textfield',
      '#default_value' => isset($settings['fundraising']) ? $settings['fundraising'] : '',
      '#description' => t('The Form Widget Code for the Fundraising Form'),
    ];

    $form['petitions'] = [
      '#title' => 'Petitions Form',
      '#type' => 'textfield',
      '#default_value' => isset($settings['petitions']) ? $settings['petitions'] : '',
      '#description' => t('The Form Widget Code for the Petitions Form'),
    ];

    $form['targeted-actions'] = [
      '#title' => 'Targeted Actions Form',
      '#type' => 'textfield',
      '#default_value' => isset($settings['targeted-actions']) ? $settings['targeted-actions'] : '',
      '#description' => t('The Form Widget Code for the Targeted Actions Form'),
    ];

    $form['events'] = [
      '#title' => 'Events Form',
      '#type' => 'textfield',
      '#default_value' => isset($settings['events']) ? $settings['events'] : '',
      '#description' => t('The Form Widget Code for the Events Form'),
    ];

    $form['peer-to-peer'] = [
      '#title' => 'Peer to Peer Form',
      '#type' => 'textfield',
      '#default_value' => isset($settings['peer-to-peer']) ? $settings['peer-to-peer'] : '',
      '#description' => t('The Form Widget Code for the Peer to Peer Form'),
    ];

    $form['actions']['submit']['#value'] = t('Save');

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $settings = $this->configFactory()->getEditable('bene_salsa.settings');
    $values = $form_state->cleanValues()->getValues();
    foreach ($values as $field_key => $field_value) {
      $settings->set($field_key, $field_value);
    }

  }
}
