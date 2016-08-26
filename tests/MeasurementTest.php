<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MeasurementTest extends TestCase
{
    use DatabaseTransactions;

    public function testWithoutMacAddressItFails()
    {
      $probeids=factory(App\Probe::class,5)->create()->pluck("id")->all();
      $machine=factory(App\Machine::class)->create();
      $machine->probes()->attach($probeids);
      $location=factory(App\Location::class)->create();
      $location->machines()->save($machine);
      $this->visit('measurement?p=1')
            ->see("sorry no mac address");
      $this->visit('measurement?macaddress=1')
            ->see("sorry, that mac address doesn't exist in the database");
    }

    public function testGoodAndBadProbes()
    {
      $probeids=factory(App\Probe::class,5)->create()->pluck("id")->all();
      $otherprobeids=factory(App\Probe::class,3)->create()->pluck("id")->all();
      $machine=factory(App\Machine::class)->create();
      $machine->probes()->attach($probeids);
      $location=factory(App\Location::class)->create();
      $location->machines()->save($machine);
      $getstring=["macaddress=$machine->macaddress"];
      foreach ($otherprobeids AS $id)
      {
        $getstring[]="p[$id]=5";
      };
      $getstring=implode("&",$getstring);
      $this->visit("measurement?$getstring")
            ->see("not connected with this machine");

      $getstring=["macaddress=$machine->macaddress"];
      foreach ($probeids AS $id)
      {
        $getstring[]="p[$id]=5";
      };
      $getstring=implode("&",$getstring);
      $this->visit("measurement?$getstring")
            ->see("made it");
      $measurements=$machine->measurements()->count();
      $this->assertTrue($measurements==5);
      $measurements=$location->measurements()->count();
      $this->assertTrue($measurements==5);
    }
}
