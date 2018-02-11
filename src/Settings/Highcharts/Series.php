<?php

namespace Drupal\chart_block\Settings\Highcharts;


class Series implements  \JsonSerializable{
    private $name;
    private $data;

    public function getName(){
        return $this->name;
    }
    public function setName($name){
        $this->name = $name;
    }
    public function getData(){
        return $this->data;
    }
    public function setData(array $data){
        $this->data = $data;
    }
    /**
     * @return array
     */
    public function jsonSerialize() {
        $vars = get_object_vars($this);

        return $vars;
    }
}