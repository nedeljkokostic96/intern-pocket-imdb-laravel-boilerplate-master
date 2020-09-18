<?php

use Illuminate\Database\Seeder;

class WatchListTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\WatchList::class, 100)->create();
    }
}
