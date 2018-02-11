<?php
namespace Drupal\chart_block\Service;

interface ChartBlockServiceInterface {
    public function getData($content_type, $xAxis, $yAxis, $chart_type);
}