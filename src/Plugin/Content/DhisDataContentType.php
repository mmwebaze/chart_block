<?php

namespace Drupal\chart_block\Plugin\Content;

use Drupal\Core\Entity\EntityFieldManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * Define a concrete class for a Chart.
 *
 * @ContentType(
 *   id = "dhis_data",
 *   name = @Translation("DHIS2 Content Type")
 * )
 */
class DhisDataContentType extends AbstractContent {
    protected $entityFieldManager;
    public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityFieldManager $entityFieldManager)
    {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->entityFieldManager = $entityFieldManager;
    }

    public function getContentTypeFields(){

        $fieldDefinitions = $this->entityFieldManager->getFieldDefinitions('node', $this->getPluginId());
        foreach ($fieldDefinitions as $field_name => $field_definition) {
            if (!empty($field_definition->getTargetBundle())) {
                $listFields[$field_name]['type'] = $field_definition->getType();
                $listFields[$field_name]['label'] = $field_definition->getLabel();
            }
        }
        $fields = [];
        drupal_set_message(json_encode($listFields));
        foreach (array_keys($listFields) as $name) {
            $fields[$name] = $name;
        }

        return $fields;
    }
    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static($configuration, $plugin_id, $plugin_definition,
            $container->get('entity_field.manager')
        );
    }
}