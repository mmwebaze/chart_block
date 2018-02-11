<?php

namespace Drupal\chart_block\Plugin\Content;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

class ContentTypeManager extends DefaultPluginManager {
    /**
     * Constructor for ContentTypeManager objects.
     *
     * @param \Traversable $namespaces
     *   An object that implements \Traversable which contains the root paths
     *   keyed by the corresponding namespace to look for plugin implementations.
     * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
     *   Cache backend instance to use.
     * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
     *   The module handler to invoke the alter hook with.
     */
    public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler){
        parent::__construct('Plugin/Content',$namespaces,$module_handler,'Drupal\chart_block\Plugin\Content\ContentTypeInterface',
            'Drupal\chart_block\Annotation\ContentType');
    }
}