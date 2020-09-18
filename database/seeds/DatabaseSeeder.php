<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(GenresTableSeeder::class);
        // $this->call(UsersTableSeeder::class);
        // $this->call(MovieTableSeeder::class);
        // $this->call(LikesTableSeeder::class);
        // $this->call(CommentsTableSeeder::class);
        $this->call(WatchListTableSeeder::class);
    }
}
