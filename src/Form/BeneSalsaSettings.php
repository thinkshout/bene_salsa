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
      '#markup' => t('<h3>Bene Salsa Embed Module</h3>'),
    ];

    $settings = $this->config('bene_salsa.settings')->get();
    $form['sign-up'] = [
        '#title' => 'Sign Up Form',
        '#type' => 'textfield',
        '#default_value' => isset($settings['dest']) ? $settings['dest'] : '',
        '#description' => t('The Form Widget Code fot the Sign Up Form'),
    ];

    $form['fundraising'] = [
        '#title' => 'Fundraising Form',
        '#type' => 'textfield',
        '#default_value' => isset($settings['dest']) ? $settings['dest'] : '',
        '#description' => t('The Form Widget Code fot the Fundraising Form'),
    ];

    $form['petitions'] = [
        '#title' => 'Petitions Form',
        '#type' => 'textfield',
        '#default_value' => isset($settings['dest']) ? $settings['dest'] : '',
        '#description' => t('The Form Widget Code fot the Petitions Form'),
    ];

    $form['targeted-actions'] = [
        '#title' => 'Targeted Actions Form',
        '#type' => 'textfield',
        '#default_value' => isset($settings['dest']) ? $settings['dest'] : '',
        '#description' => t('The Form Widget Code fot the Targeted Actions Form'),
    ];

    $form['Events'] = [
        '#title' => 'Events Form',
        '#type' => 'textfield',
        '#default_value' => isset($settings['dest']) ? $settings['dest'] : '',
        '#description' => t('The Form Widget Code fot the Events Form'),
    ];

    $form['peer-to-peer'] = [
        '#title' => 'Peer to Peer Form',
        '#type' => 'textfield',
        '#default_value' => isset($settings['dest']) ? $settings['dest'] : '',
        '#description' => t('The Form Widget Code fot the Peer to Peer Form'),
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
    $settings->set('sign-up', $values['sign-up']);
    $settings->save();
    parent::submitForm($form, $form_state);
  }

}
