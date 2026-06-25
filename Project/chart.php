<?php
include_once'./risk/riskClass.php';

$riskClass=new riskClass();
$showriskass=$riskClass->showassessment();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawSeriesChart);

    function drawSeriesChart() {

      var data = google.visualization.arrayToDataTable([
        ['ID', 'Life Expectancy', 'Fertility Rate', 'Region',     'Population'],
        ['CAN',    3,              3,      'risk1',  33739900],
        ['DEU',    5,              5,      'risk2',         81902307],
        ['DNK',    3,              3,      'risk3',         5523095],
        ['EGY',    3,              3,      'risk4',    79716203],
        ['GBR',    5,              2,         'risk5',         61801570],
        ['IRN',    2,              5,       'risk6',    73137148],
        ['IRQ',    1,              4,      'risk7',    31090763],
        
      ]);

      var options = {
        title: 'Fertility rate vs life expectancy in selected countries (2010).' +
          ' X=Life Expectancy, Y=Fertility, Bubble size=Population, Bubble color=Region',
        hAxis: {title: 'Life Expectancy'},
        vAxis: {title: 'Fertility Rate'},
        bubble: {textStyle: {fontSize: 11}}
      };

      var chart = new google.visualization.BubbleChart(document.getElementById('series_chart_div'));
      chart.draw(data, options);
    }
    </script>
</head>
<body>
    <div id="series_chart_div" style="width: 900px; height: 500px;"></div>
</body>
</html>