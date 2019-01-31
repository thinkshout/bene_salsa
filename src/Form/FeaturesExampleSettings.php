<?php

namespace Drupal\bene_salsa\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Your Settings.
 */
class FeaturesExampleSettings extends ConfigFormBase {

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
    $form['example_radio'] = [
      '#title' => t('What type of form would you like to embed?'),
      '#type' => 'radios',
      '#default_value' => isset($settings['example_radio']) ? $settings['example_radio'] : 'off',
      '#options' => [
        'on' => 'Sign-up Form',
        'off' => 'Something Else',
      ],
      '#required' => TRUE,
      '#description' => t(''),
    ];

    $form['example_text'] = [
      '#title' => t('Paste in the embed code here'),
      '#type' => 'textfield',
      '#default_value' => isset($settings['example_text']) ? $settings['example_text'] : '',
      '#states' => [
        'visible' => [
          ':input[name="example_radio"]' => ['value' => 'on'],
        ],
      ],
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
    $settings->set('example_radio', $values['example_radio']);
    $settings->set('example_text', $values['example_text']);
    $settings->save();
    parent::submitForm($form, $form_state);
  }

}
