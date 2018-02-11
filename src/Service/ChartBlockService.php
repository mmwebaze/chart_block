<?php
namespace Drupal\chart_block\Service;

use Drupal\chart_block\Settings\Highcharts\Chart;
use Drupal\chart_block\Settings\Highcharts\Highcharts;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\chart_block\Settings\Highcharts\Series;
use Drupal\node\Entity\Node;

class ChartBlockService implements ChartBlockServiceInterface {
    protected $entityTypeManager;

    public function __construct(EntityTypeManager $entityTypeManager){
        $this->entityTypeManager = $entityTypeManager;
    }
    public function getData($content_type, $xAxis, $yAxis, $chart_type){
        $chart = new Chart();
        $chart->setType($chart_type);
        $storage = $this->entityTypeManager->getStorage('node');
        $ids = $storage->getQuery()->condition('type', $content_type, '=')->execute();
        $entities = $storage->loadMultiple($ids);

        $categories = [];
        $seriesData = [];
        $dataTemp = [];

        foreach ($entities as $entity){

            $name = $entity->get($xAxis)->getValue();


            $value = $entity->get($yAxis)->value;

            /*if (isset($dataTemp[$name[0]['target_id']])){
                array_push($dataTemp[$name[0]['target_id']], floatval($value));
            }
            else{
                $dataTemp[$name[0]['target_id']] = [floatval($value)];
            }*/
            $title = $this->cleanString($entity->getTitle());

            if (isset($dataTemp[$title])){
                array_push($dataTemp[$title], floatval($value));
            }
            else{
                $dataTemp[$title] = [floatval($value)];
            }
        }

        foreach ($dataTemp as $key => $item){
            $series = new Series();
            $series->setName($key);
            $series->setData($item);
            array_push($seriesData, $series);
        }

        $highcharts = new Highcharts();
        $highcharts->setChart($chart);
        $highcharts->setSeries($seriesData);
        return $highcharts;
    }
    private function cleanString($stringToClean){

        $string = str_replace(' ', '-', $stringToClean); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }
}