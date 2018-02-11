<?php

namespace Drupal\chart_block\Plugin\Block;

use Drupal\chart_block\Service\ChartBlockServiceInterface;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Provides a 'visualization' block.
 *
 * @Block(
 *   id = "viz_block",
 *   admin_label = @Translation("Visualization block"),
 *   category = @Translation("Custom visualization block")
 * )
 */
class ChartBlock extends BlockBase implements BlockPluginInterface, ContainerFactoryPluginInterface {
    protected $chartBlockService;

    public function __construct(array $configuration, $plugin_id, $plugin_definition, ChartBlockServiceInterface $chartBlockService)
    {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->chartBlockService = $chartBlockService;
    }

    /**
     * {@inheritdoc}
     */
    public function blockForm($form, FormStateInterface $form_state) {
        $form = parent::blockForm($form, $form_state);
        $config = $this->getConfiguration();
        //To do..change and use DI
        $uuid_service = \Drupal::service('uuid');
        $uuid = $uuid_service->generate();

        $plugin_manager = \Drupal::service('plugin.manager.chart_block');
        $plugin_definitions = $plugin_manager->getDefinitions();

        if (isset($config['content_type'])){
            $instance = $plugin_manager->createInstance($config['content_type']);
        }
        else{
            $instance = $plugin_manager->createInstance(array_values($plugin_definitions)[0]['id']);

        }

        $content_type_options = [];
        $fields = [];
        foreach ($plugin_definitions as $plugin_definition){
            $content_type_options[$plugin_definition['id']] = $plugin_definition['name'];
            $fields = $instance->getContentTypeFields();
        }
        drupal_set_message(json_encode($fields));
        $form['uuid'] = array(
            '#type' => 'hidden',
            '#value' => isset($config['uuid'])? $config['uuid']: $uuid,

        );
        $form['content_type'] = array (
            '#title' => t('Content type'),
            '#type' => 'select',
            '#options' => $content_type_options,
            '#default_value' => isset($config['content_type']) ? $config['content_type'] : '',
            '#required' => TRUE,
        );
        $form['chart_type'] = array(
            '#type' => 'radios',
            '#title' => t('Chart type'),
            '#default_value' => $config['chart_type'],
            '#options' => ['bar' => 'bar','pie' => 'pie', 'line' => 'line'],
        );
        $form['X-axis'] = array(
            '#type' => 'radios',
            '#title' => t('X-AXIS'),
            '#default_value' => $config['X-axis'],
            '#options' => $fields,
        );
        $form['Y-axis'] = array(
            '#type' => 'radios',
            '#title' => t('Y-AXIS'),
            '#default_value' => $config['Y-axis'],
            '#options' => $fields,
        );
        return $form;
    }
    /**
     * {@inheritdoc}
     */
    public function build() {

        $config = $this->getConfiguration();
        $chart = $this->chartBlockService->getData($config['content_type'], $config['X-axis'], $config['Y-axis'], $config['chart_type']);

        return array(
            '#type' => 'markup',
            '#theme' => 'chart_block_charts',
            '#chartable_data' => ['uuid' => $config['uuid'], 'chart' => json_encode($chart)],
            '#attached' => array(
                'library' => array('chart_block/chart_block_highcharts'),
            )
        );
    }
    /**
     * {@inheritdoc}
     */
    public function blockSubmit($form, FormStateInterface $form_state) {
        $this->setConfigurationValue('uuid', $form_state->getValue('uuid'));
        $this->setConfigurationValue('content_type', $form_state->getValue('content_type'));
        $this->setConfigurationValue('X-axis', $form_state->getValue('X-axis'));
        $this->setConfigurationValue('Y-axis', $form_state->getValue('Y-axis'));
        $this->setConfigurationValue('chart_type', $form_state->getValue('chart_type'));
    }
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition){
        return new static($configuration, $plugin_id, $plugin_definition,
            $container->get('chart_block_service')
        );
    }
}