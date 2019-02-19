<?php

namespace Drupal\bene_salsa\Plugin\Field\FieldFormatter;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\StringFormatter;

/**
 * Plugin implementation of the 'salsa_embed_string' formatter.
 *
 * @FieldFormatter(
 *   id = "salsa_embed_string",
 *   label = @Translation("Salsa Embed"),
 *   field_types = {
 *     "string",
 *   },
 *   quickedit = {
 *     "editor" = "plain_text"
 *   }
 * )
 */
class SalsaEmbedStringFormatter extends StringFormatter {

    /**
     * Constructs a StringFormatter instance.
     *
     * @param string $plugin_id
     *   The plugin_id for the formatter.
     * @param mixed $plugin_definition
     *   The plugin implementation definition.
     * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
     *   The definition of the field to which the formatter is associated.
     * @param array $settings
     *   The formatter settings.
     * @param string $label
     *   The formatter label display setting.
     * @param string $view_mode
     *   The view mode.
     * @param array $third_party_settings
     *   Any third party settings settings.
     * @param \Drupal\Core\Entity\EntityManagerInterface $entity_manager
     *   The entity manager.
     */



    /**
     * {@inheritdoc}
     */
    public function viewElements(FieldItemListInterface $items, $langcode) {
        $salsa_code = '';
        $form_code = '';
        if(isset($items->getEntity()->field_form_id[0]) && isset($items->getEntity()->field_form_type[0])){
            $salsa_code = $items->getEntity()->field_form_id[0]->getValue()['value'];
            $form_code = $items->getEntity()->field_form_type[0]->getValue()['value'];
        }

        $elements = [
            '#type' => 'inline_template',
            '#template' => '{{ embed|raw }}',
            '#context' => [
                'embed' => "<div id='salsaContainer'><div id='salsaWrapper'><div id='salsaForm'><div id='$form_code'><script type='text/javascript' src='https://default.salsalabs.org/api/widget/template/$salsa_code/?tId=$form_code' ></script></div></div></div></div>",
            ],
        ];

        return $elements;
    }
}