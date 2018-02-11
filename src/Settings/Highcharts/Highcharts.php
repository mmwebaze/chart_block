<?php

namespace Drupal\chart_block\Settings\Highcharts;


class Highcharts implements  \JsonSerializable {
    /**
     * @var \Drupal\chart_block\Settings\Highcharts\Chart
     */
    private $chart;
    /**
     * @var \Drupal\chart_block\Settings\Highcharts\Xaxis
     */
    //private $xAxis;
    private $series;
    /**
     * @return mixed
     */
    public function getChart() {
        return $this->chart;
    }

    /**
     * @param mixed $chart
     */
    public function setChart($chart) {
        $this->chart = $chart;
    }
    /**
     * @return mixed
     */
    /*public function getXAxis() {
        return $this->xAxis;
    }*/

    /**
     * @param mixed $xAxis
     */
   /* public function setXAxis($xAxis) {
        $this->xAxis = $xAxis;
    }*/
    /**
     * @return mixed
     */
    public function getSeries() {
        return $this->series;
    }

    /**
     * @param mixed $series
     */
    public function setSeries($series) {
        $this->series = $series;
    }
    /**
     * @return array
     */
    public function jsonSerialize() {
        $vars = get_object_vars($this);

        return $vars;
    }
}