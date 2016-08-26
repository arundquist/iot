<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use App\Probe;
use App\Machine;

class AdminController extends Controller
{
    public function users()
    {
      $this->authorize('admin');
      $approvedusers=\App\User::where('approved',1)->get();
      $unapprovedusers=\App\User::where('approved',0)->get();
      return view('admin/users', ['approvedusers'=>$approvedusers,
                                  'unapprovedusers'=>$unapprovedusers]);
    }

    public function approve(Request $request)
    {
      $this->authorize('admin');
      $toapprove=$request->input("approveuser");
      $tounapprove=$request->input("unapproveuser");
      if ($toapprove !=null)
        DB::table('users')->whereIn('id', array_keys($toapprove))->update(['approved'=>1]);
      if ($tounapprove != null)
        DB::table('users')->whereIn('id', array_keys($tounapprove))->update(['approved'=>0]);
      return redirect()->route('show users');
    }

    public function getProbe($id=null)
    {
      $this->authorize('admin');
      if ($id==null)
      {
        //$probe=factory(App\Probe::class,'empty')->make();
        $probe=new Probe;
      } else {
        $probe=\App\Probe::findOrFail($id);
      };
      return view('admin/probe',
          ['probe'=>$probe]);
    }

    public function postProbe(Request $request, $id=null)
    {
      $this->authorize('admin');
      if ($id == null)
      {
        $probe=new Probe;

      } else {
        $probe=Probe::findOrFail($id);
      };
      $probe->name=$request->input('name');
      $probe->type=$request->input('type');
      $probe->units=$request->input('units');
      $probe->description=$request->input('description');
      $probe->save();
      return redirect()->route('add or edit probe',['id'=>$probe->id]);
    }

    public function getAllprobes()
    {
      $probes=Probe::all();
      return view('admin/allprobes',
            ['probes'=>$probes]);
    }

    public function getAllmachines()
    {
      $machines=Machine::with('location')->get();
      return view('admin/allmachines',
            ['machines'=>$machines]);
    }
}
