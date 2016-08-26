<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Code;
use App\Location;
use App\Machine;
use App\Measurement;
use App\Probe;

use Faker\Factory as Faker;

class MeasurementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user=factory(App\User::class)->create();
        $machine=factory(App\Machine::class)->create();
        $location=factory(App\Location::class)->create();
        $location->machines()->save($machine);
        $code=factory(App\Code::class)->create();
        $machine->codes()->save($code);
        $user->codes()->save($code);
        $probes=factory(App\Probe::class, 3)->create();
        $machine->probes()->sync($probes->pluck('id')->all());
        // make a start date
        // do a loop and make a measurement with the appropriate start database
        $faker = Faker::create();
        $measurements = [];
        $starttime=Carbon\Carbon::now();
        foreach (range(1, 1000) as $index)
        {
            $timestamp = $starttime->addMinutes(5);
            $measurements[] = [
                'machine_id'         => $machine->id,
                'location_id'      => $location->id,
                'probe_id'          => $probes->random()->id,
                'measurement'     => $faker->randomFloat(3, 0, 100),
                'created_at'    => $timestamp->toDateTimeString(),
                'updated_at'    => $timestamp->toDateTimeString()
            ];
        }


        Measurement::insert($measurements);


    }
}
