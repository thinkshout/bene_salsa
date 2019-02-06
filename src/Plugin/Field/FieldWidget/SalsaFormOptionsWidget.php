<?php
namespace Drupal\bene_salsa\Plugin\Field\FieldWidget;
use Drupal\Core\Entity\FieldableEntityInterface;
use Drupal\Core\Field\Plugin\Field\FieldWidget\OptionsButtonsWidget;
/**
 * Plugin implementation of the 'salsa_form_options' widget.
 *
 * @FieldWidget(
 *   id = "salsa_form_options",
 *   module = "bene_salsa",
 *   label = @Translation("Salsa Form Options"),
 *   field_types = {
 *     "string",
 *   },
 *   multiple_values = TRUE
 * )
 */
class SalsaFormOptionsWidget extends OptionsButtonsWidget {
    /**
     * Returns the array of form options for the widget.
     *
     * @param \Drupal\Core\Entity\FieldableEntityInterface $entity
     *   The entity for which to return options.
     *
     * @return array
     *   The array of options for the widget.
     */
    protected function getOptions(FieldableEntityInterface $entity) {
        if (!isset($this->options)) {
            $options = \Drupal::service('config.factory')->get('bene_salsa.settings');
            $this->options = array_flip($options->getRawData());
        }
        return $this->options;
    }
}