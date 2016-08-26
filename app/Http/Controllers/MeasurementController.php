<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Machine;
use App\Measurement;

class MeasurementController extends Controller
{
    public function getMeasurement(Request $request)
    {
      $macaddress=$request->input('macaddress');
      if ($macaddress==null)
      {
        return "sorry no mac address";
      } else {
        $machine=Machine::where('macaddress', $macaddress)->first();
        if ($machine == null)
          return "sorry, that mac address doesn't exist in the database";
        $location=$machine->location;
      };
      $machineprobeids=$machine->probes()->pluck('id')->all();
      $plist=$request->input('p');

      if ($plist==null)
        return "sorry, no probes submitted";
      foreach ($plist AS $key=>$value)
      {
        if (!in_array($key, $machineprobeids))
          return "sorry, probe $key is not connected with this machine";
        $measurement=new Measurement;
        $measurement->measurement=$value;
        $measurement->probe_id=$key;
        $location->measurements()->save($measurement);
        $machine->measurements()->save($measurement);

      };
      return "you made it!";
    }
}
