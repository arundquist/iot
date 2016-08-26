<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Machine;
use App\Probe;
use App\Location;
use App\Code;
use App\User;
use Auth;

class MachineController extends Controller
{
    public function getAdd()
    {
      $this->authorize('approved');
      $probes=\App\Probe::all();
      $locations=\App\Location::all();
      return view('machine/add', ['probes'=>$probes,
                                  'locations'=>$locations]);
    }

    public function postAdd(Request $request)
    {
      $macaddress=$request->input('macaddress');
      $probeids=array_keys($request->input('probes'));
      $locationshort=$request->input('locationshort');
      $locationdescription=$request->input('locationdescription');
      $locationgps=$request->input('locationgps');
      $codetext=$request->input('code');
      $machine=new Machine;

      $code=new Code;
      $locationid=$request->input('locationid');
      if ($locationid==-1)
      {
        $location=new Location;
        $location->shortname=$locationshort;
        $location->description=$locationdescription;
        $location->gps=$locationgps;
        $location->save();
      } else {
        $location=Location::findOrFail($locationid);
      };

      $code->code=$codetext;
    //  $code->save();
    // note that it gets saved below through $machine->codes()->save($code)
      $user=Auth::user();
      $user->codes()->save($code);
      $machine->macaddress=$macaddress;
      $location->machines()->save($machine);
    //  $machine->save();
      $machine->probes()->attach($probeids); // many to many
      //$machine->locations()->attach($location->id); //many to many

      $machine->codes()->save($code); //one to many

      return redirect()->route('machine edit',[$machine]);


    }

    public function getEdit($id)
    {
      $this->authorize('approved');
      $machine=Machine::findOrFail($id);
      $macprobes=$machine->probes()->pluck('id')->all();
      //dd($macprobes);
      $probes=\App\Probe::whereNotIn('id',$macprobes)->get();
      //dd($probes->count());
      $maclocation=$machine->location;
      $locations=\App\Location::where("id",'<>',$maclocation->id)->get();
      return view('machine/add', ['probes'=>$probes,
                                  'maclocation'=>$maclocation,
                                  'locations'=>$locations,
                                'machine'=>$machine]);
      //return "hi there";
    }

    public function postEdit(Request $request, $id)
    {
      $this->authorize('approved');
      $machine=Machine::findOrFail($id);

      // right here you need to deal with the request
      // and update the machine.
      // Then the stuff below (starting with $macprobes)
      // should be done after a save() command on the machine

      $machine->macaddress=$request->input('macaddress');
      $submittedprobes=$request->input('probes');
      //dd($submittedprobes);
      $machine->probes()->sync(array_keys($request->input('probes')));
      $locationid=$request->input('locationid');
      if ($locationid==-1)
      {
        $location=new Location;
        $location->shortname=$request->input('locationshort');
        $location->description=$request->input('locationdescription');
        $location->gps=$request->input('locationgps');
        $location->save();
      } else {
        $location=Location::findOrFail($locationid);
      };
      $location->machines()->save($machine);

      if ($request->input('code') != 'arduino code')
      {
        $code=new Code;
        $code->code=$request->input('code');
        $code->save();
        $user=Auth::user();
        $user->codes()->save($code);
        $machine->codes()->save($code);
      };


      $macprobes=$machine->probes->pluck('id')->all();
      $probes=\App\Probe::whereNotIn('id',$macprobes)->get();
      $maclocation=$machine->location;
      $locations=\App\Location::where("id",'<>',$maclocation->id)->get();
      return view('machine/add', ['probes'=>$probes,
                                  'maclocation'=>$maclocation,
                                  'locations'=>$locations,
                                'machine'=>$machine]);

    }
}
