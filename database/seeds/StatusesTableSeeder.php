<?php

use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_ids = ['1','2','3'];
        $faker = app(Faker\Generator::class);
        factory('App\Models\Status',100)->create([
            'user_id'    =>  $faker->randomElement($user_ids),
        ]);
    }
}
