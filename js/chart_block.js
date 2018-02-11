(function ($) {
    'use strict';

    Drupal.behaviors.dhis = {
        attach: function (context, settings) {
            $('.chart_block_charts').once().each(function(index, value) {
                if ($(this).attr('data-chart')) {
                    var highcharts = $(this).attr('data-chart');
                    var hc = JSON.parse(highcharts);
                    $(this).highcharts(hc);
                }
            });
        }
    };
}(jQuery));