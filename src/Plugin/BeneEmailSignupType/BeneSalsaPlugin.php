<?php

namespace Drupal\bene_salsa\Plugin\BeneEmailSignupType;

use Drupal\bene_core\Plugin\BeneEmailSignupTypeBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides Salsa for email signup.
 *
 * @BeneEmailSignupType(
 *   id = "salsa_for_bene_newsletter",
 *   title = "Salsa Form",
 *   description = @Translation("Connect to Salsa for email signups."),
 * )
 */
class BeneSalsaPlugin extends BeneEmailSignupTypeBase {

  /**
   * Provides a form that collects settings for the newsletter signup.
   *
   * @param array $configuration
   *   The plugin configuration, i.e. an array with configuration values keyed
   *   by configuration option name. The special key 'context' may be used to
   *   initialize the defined contexts by setting it to an array of context
   *   values keyed by context names.
   *
   * @return array
   *   Render array (form) for the settings.
   */
  public function settingsForm(array $configuration) {
    $salsaSettingsForm = [];

    // Help the user turn on Salsa.
    $moduleHandler = \Drupal::service('module_handler');
    if ($moduleHandler->moduleExists('bene_salsa')) {
      // Help the User set the keys.
      $salsa_config = \Drupal::config('bene_salsa.settings');
      $template_code = $salsa_config->get('sign-up');

      if (!$template_code) {
        $salsaSettingsForm['help_text'] = [
          '#type' => 'markup',
          '#markup' => 'Please add a <a href="/admin/config/bene_features/bene_salsa?destination=/admin/config/bene_features">Salsa Sign Up Form</a> key to begin.',
          '#prefix' => '<p>',
          '#suffix' => '</p>',
        ];
      }
      else {
        $default_form_code = "";
        if ($configuration && array_key_exists('salsa_form_widget_id', $configuration)) {
          $default_form_code = $configuration['salsa_form_widget_id'];
        }
        $salsaSettingsForm['salsa_form_widget_id'] = [
          '#type' => 'textfield',
          '#title' => 'Salsa Form Widget ID',
          '#default_value' => $default_form_code,
          '#size' => 60,
          '#maxlength' => 128,
          '#required' => TRUE,
        ];
        $salsaSettingsForm['salsa_form_widget_id_prompt'] = [
          '#type' => 'markup',
          '#markup' => 'Get this ID from Salsalabs in your account (you must be signed in) on the signup forms, published details area. There is a section called "Form Widget Code" and an id on the first line of code.',
          '#prefix' => '<p>',
          '#suffix' => '</p>',
        ];
      }
    }
    return $salsaSettingsForm;
  }

  /**
   * Opportunity to validate your settings form.
   *
   * @param array $configuration
   *   The plugin configuration, i.e. an array with configuration values keyed
   *   by configuration option name. The special key 'context' may be used to
   *   initialize the defined contexts by setting it to an array of context
   *   values keyed by context names.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The state of the form with current entries and selections.
   */
  public function validateSettingsForm(array $configuration, FormStateInterface $form_state) {
  }

  /**
   * Called when submitting the settings form.
   *
   * @param array $configuration
   *   The plugin configuration, i.e. an array with configuration values keyed
   *   by configuration option name. The special key 'context' may be used to
   *   initialize the defined contexts by setting it to an array of context
   *   values keyed by context names.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitSettingsForm(array &$configuration, FormStateInterface $form_state) {
    $salsa_settings = $form_state->getValue('salsa_for_bene_newsletter');
    $configuration['salsa_form_widget_id'] = $salsa_settings['settings']['salsa_form_widget_id'];
  }

  /**
   * Builds and returns the renderable array for this block plugin.
   *
   * @param array $configuration
   *   The plugin configuration, i.e. an array with configuration values keyed
   *   by configuration option name. The special key 'context' may be used to
   *   initialize the defined contexts by setting it to an array of context
   *   values keyed by context names.
   *
   * @return array
   *   A renderable array representing the content of the block.
   */
  public function buildEndUserEmailSignup(array $configuration) {
    $moduleHandler = \Drupal::service('module_handler');
    $elements = [];
    if ($moduleHandler->moduleExists('bene_salsa')) {
      $salsa_config = \Drupal::config('bene_salsa.settings');
      $template_code = $salsa_config->get('sign-up');
      if (!$template_code) {
        return [];
      }
      $form_code = $configuration['salsa_form_widget_id'];
      $elements = [
        '#type' => 'inline_template',
        '#template' => '{{ embed|raw }}',
        '#context' => [
          'embed' => "<div id='$form_code'><script type='text/javascript' src='https://default.salsalabs.org/api/widget/template/$template_code/?tId=$form_code'></script></div>",
        ],
      ];
    }
    return $elements;
  }

}
