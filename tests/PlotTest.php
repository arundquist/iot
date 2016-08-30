<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Probe;
use App\Location;
use App\Machine;

class PlotTest extends TestCase
{
  use DatabaseTransactions;
    public function testLocationHomePage()
    {
      $location=factory(App\Location::class)->create();
      $otherlocation=factory(App\Location::class)->create();
      $probes=factory(App\Probe::class,2)->create();
      $machine=factory(App\Machine::class)->create();
      $firstprobeid=$probes->first()->id;
      $firstprobetype=$probes->first()->type;
      $measurements=factory(App\Measurement::class, 100)->create([
        'location_id'=>$location->id,
        'machine_id'=>$machine->id,
        'probe_id'=>$firstprobeid
        ]);
      $measurements2=factory(App\Measurement::class, 100)->create([
        'location_id'=>$location->id,
        'machine_id'=>$machine->id,
        'probe_id'=>$probes->random()->id
        ]);
      $this->visit('/')
          ->click('Locations')
          ->see($location->shortname);
      $this->visit("locations/$location->id")
          ->see("$firstprobetype");

      $this->visit("locations/measurements/$location->id/{$probes->first()->type}")
          ->see($measurements->random()->measurement);
      $this->visit("locations/measurements/$location->id/{$probes->first()->type}/raw")
          ->seeJson();

    }


}
