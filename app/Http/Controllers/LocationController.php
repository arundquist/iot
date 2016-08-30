<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Location;
use App\Probe;
use App\Machine;
use App\Measurement;

class LocationController extends Controller
{
    public function getAll()
    {
      $locations=Location::all();
      return view('location/all',
          ['locations'=>$locations]);

    }

    public function getSingle($id)
    {
      $location=Location::with('measurements', 'machines', 'measurements.probe')->findOrFail($id);
      $distinctmeasurements=$location->measurements()->groupBy('probe_id')->get();
      $probeids=$distinctmeasurements->pluck('probe_id')->all();
      $types=Probe::whereIn('id',$probeids)->get()->pluck('type','id')->all();
      $uniquetypes=array_unique($types);

      return view('location/single',
          ['location'=>$location,
          'types'=>$uniquetypes]);
    }

    public function getMeasurement($location_id, $type,$format='plot')
    {
      $location=Location::with('measurements', 'machines', 'measurements.probe')->findOrFail($location_id);
      $distinctmeasurements=$location->measurements()->groupBy('probe_id')->get();
      $probeids=$distinctmeasurements->pluck('probe_id')->all();
      $probes=Probe::whereIn('id', $probeids)
                      ->where('type',$type)
                      ->get();
      $probeidswithtype=$probes->pluck('id')->all();
      $units=$probes->first()->units;

      $measurements=Measurement::where('location_id',$location_id)
              ->whereIn('probe_id', $probeidswithtype)
              ->get();
      switch ($format)
      {
        case 'raw':
          return $measurements;
          break;
        case 'plot':
          return view('measurements/locationtype',
                  ['measurements'=>$measurements,
                  'location'=>$location,
                  'type'=>$type,
                  'units'=>$units]);
          break;
        default:
          return "not sure what you wanted";
      };
    }
}
