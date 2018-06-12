<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<1; $i++){
        DB::table('users')->insert([
            'name' => 'irfan',
            'username' => 'admin',
            'email' => str_random(10).'@gmail.com',
            'password' => bcrypt('secret'),
        ]);
      }
    }
}
