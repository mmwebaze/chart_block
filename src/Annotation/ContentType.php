<?php
namespace Drupal\chart_block\Annotation;

use Drupal\Component\Annotation\Plugin;
/**
 * Defines an ContentType annotation object.
 *
 * @Annotation
 */
class ContentType extends Plugin{
    /**
     * The plugin ID.
     *
     * @var string
     */
    public $id;
    /**
     * The plugin name.
     *
     * @var string
     */
    public $name;
}