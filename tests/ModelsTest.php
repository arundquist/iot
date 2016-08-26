<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ModelsTest extends TestCase
{
     use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testUserCreation()
    {
      $user=factory(App\User::class)->create([
          'email' => 'hi@there'
      ]);
      $user->email='hi@ther';
      $user->save();
      $this->seeInDatabase('users', ['email' => 'hi@ther']);
    }

    public function testMakeUserAdmin()
    {
      $adminuser=factory(App\User::class,'admin')->create();
      $user=factory(App\User::class)->create(['name'=>'loser']);
      if ($adminuser->admin)
      {
        $user->admin=true;
        $user->save();
      };
      $this->seeInDatabase('users', ['name'=>'loser', 'admin'=>true]);
    }
}
