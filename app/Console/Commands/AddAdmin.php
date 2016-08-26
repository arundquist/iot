<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class AddAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds and admin user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user=new User;
        $name=$this->ask('name');
        $user->name=$name;
        $email=$this->ask('email');
        $user->email=$email;
        $password=$this->ask('password');
        $user->password=bcrypt($password);
        $user->admin=1;
        $user->approved=1;
        $user->save();
        $id=$user->id;
        $this->info("done, user $id added");
    }
}
