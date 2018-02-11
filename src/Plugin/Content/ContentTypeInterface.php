<?php
namespace Drupal\chart_block\Plugin\Content;

use Drupal\Component\Plugin\PluginInspectionInterface;

/**
 * Defines an interface for Chart_block plugins.
 */
interface ContentTypeInterface extends PluginInspectionInterface
{
    /**
     *
     *
     * @return an array of available content type fields
     */
    public function getContentTypeFields();
    /**
     * Return the machine name of the content type associated with this plugin.
     *
     * @return string
     *   returns the name as a string.
     */
    public function getContentTypeName();
}