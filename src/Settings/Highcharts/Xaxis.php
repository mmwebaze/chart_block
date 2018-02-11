<?php
namespace Drupal\chart_block\Settings\Highcharts;

class Xaxis implements  \JsonSerializable {
    private $categories = [];
    /**
     * @return array
     */
    public function getCategories() {
        return $this->categories;
    }

    /**
     * @param array $categories
     */
    public function setCategories($categories) {
        $this->categories = $categories;
    }
    /**
     * @return array
     */
    public function jsonSerialize() {
        $vars = get_object_vars($this);

        return $vars;
    }
}