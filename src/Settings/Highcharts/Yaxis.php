<?php
namespace Drupal\chart_block\Settings\Highcharts;

class Yaxis implements  \JsonSerializable{
    /**
     * @return array
     */
    public function jsonSerialize() {
        $vars = get_object_vars($this);

        return $vars;
    }
}