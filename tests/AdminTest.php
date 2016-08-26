<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminTest extends TestCase
{
    use DatabaseTransactions;

    public function testAdminUsersCanSeeUserList()
    {
      $adminuser=factory(App\User::class,'admin')->create();
      $user=factory(App\User::class)->create();
      $this->actingAs($adminuser)
            ->visit('/admin/users')
             ->see($user->name);
    }

    public function testMakeSureNonAdminCannotSeeAdminUserList()
    {
      $adminuser=factory(App\User::class,'admin')->create();
      $user=factory(App\User::class)->create();

      $this->setExpectedException('Illuminate\Foundation\Testing\HttpException');

      $this->actingAs($user)
            ->visit('/admin/users')
            ->assertResponseStatus(403);
    }

    public function testApproveAndUnApproveUsers()
    {
      $adminuser=factory(App\User::class, 'admin')->create();
      $unauthusers=factory(App\User::class,5)->create();
      $authusers=factory(App\User::class, 'approved',5)->create();


      $firstunapproved=$unauthusers->first();
      $firstapproved=$authusers->first();

      $this->actingAs($adminuser)
            ->visit('/admin/users')
            ->check("approveuser[$firstunapproved->id]")
            ->check("unapproveuser[$firstapproved->id]")
            ->press("approve users");

      $newapprovedusers=\App\User::where('approved',1)->get();
      $newunapprovedusers=\App\User::where('approved',0)->get();

      $verifycheck=$newapprovedusers->contains("id", $firstunapproved->id);
      $unverifycheck=$newunapprovedusers->contains("id", $firstapproved->id);

      $this->assertTrue($verifycheck);
      $this->assertTrue($unverifycheck);


    }

    public function testAddProbe()
    {
      $user=factory(App\User::class,'admin')->create();
      $probe=factory(App\Probe::class)->make();
      $this->actingAs($user)
          ->visit('admin/probe')
          ->type($probe->name,'name')
          ->type($probe->description, 'description')
          ->type($probe->type, 'type')
          ->type($probe->units, 'units')
          ->press('submit probe');
    }

    public function testShowAllMachinesAndProbes()
    {
      $user=factory(App\User::class, 'admin')->create();
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
            ->visit('admin/allprobes')
            ->see($probes->first()->description);
      $this->actingAs($user)
            ->visit('admin/allmachines')
            ->see($machine->macaddress);
    }
}
