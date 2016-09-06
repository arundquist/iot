<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MachineTest extends TestCase
{
  use DatabaseTransactions;
  public function testMakeSureNonApprovedCannotAddMachine()
  {
    $approveduser=factory(App\User::class,'approved')->create();
    $user=factory(App\User::class)->create();

    $this->actingAs($approveduser)
          ->visit('/machine/add');

    $this->setExpectedException('Illuminate\Foundation\Testing\HttpException');

    $this->actingAs($user)
          ->visit('/machine/add')
          ->assertResponseStatus(403);
  }

  public function testMachineAddGoesToMachineEdit()
  {
    $user=factory(App\User::class, 'approved')->create();
    $machine=factory(App\Machine::class)->make();
    $probes=factory(App\Probe::class,5)->create();
    $probe=$probes->first();
    $location=factory(App\Location::class)->make();
    $code=factory(App\Code::class)->make();
    $this->actingAs($user)
        ->visit('/machine/add')
        ->type($machine->macaddress, 'macaddress')
        ->type($location->shortname, 'locationshort')
        ->type($location->description, 'locationdescription')
        ->type($location->gps, 'locationgps')
        ->check("probes[$probe->id]")
        ->type($code->code, 'code')
        ->press('add machine')
        ->see($code->code);
  }

  public function testMachineEditGoesToMachineEdit()
  {
    $user=factory(App\User::class, 'approved')->create();
    $machine=factory(App\Machine::class)->create();
    $probes=factory(App\Probe::class,5)->create();
    $probeids=$probes->pluck('id')->all();
    $machine->probes()->sync($probeids);
    //dd("i'm here");
    $location=factory(App\Location::class)->create();
    $code=factory(App\Code::class)->create();
    $location->machines()->save($machine);
    $machine->codes()->save($code);
    $user->codes()->save($code);
    $this->actingAs($user)
        ->visit("/machine/edit/$machine->id")
        ->check("probes[$probeids[3]]") // it seems pre-checked check boxes don't work here
        ->check("probes[$probeids[2]]")
        ->press('edit machine')
        ->see($probeids[0])
        ->see($code->code);
    $this->actingAs($user)
        ->visit("/machine")
        ->see($user->machines->first()->macaddress);

  }
}
