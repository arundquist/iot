<?php

namespace App\Helpers;

class Plotly
{
  static function quicktest()
  {
    return "plotly is awesome";
  }

  static function dateplot($measurements,$type,$units)
  {
    $dates=$measurements->pluck('created_at')->all();
    //$probe=$measurements->first()->probe;
    //$type=$probe->type;
    //$units=$probe->units;
    
    $correcteddates=[];
    foreach ($dates AS $date)
    {
      $correcteddates[]=$date->toDateTimeString();
    };
    $datestring=implode("', '", $correcteddates);

    $values=implode(', ', $measurements->pluck('measurement')->all());
    $str=<<<EOD
    <div id="myDiv" style="width: 600px; height: 400px;"><!-- Plotly chart will be drawn inside this DIV --></div>
      <script>
      var data = [
        {
          x: ['$datestring'],
          y: [$values],
          type: 'scatter',
          symbol: 'circle'
        }
        ];

        var layout = {
          title: 'Date Plot',
          xaxis: {
            title: 'date',
            titlefont: {
              family: 'Courier New, monospace',
              size: 18,
              color: '#7f7f7f'
            }
          },
          yaxis: {
            title: '$type ($units)',
            titlefont: {
              family: 'Courier New, monospace',
              size: 18,
              color: '#7f7f7f'
            }
          }
        };

Plotly.newPlot('myDiv', data, layout);
      </script>
EOD;
    return $str;
  }
}
