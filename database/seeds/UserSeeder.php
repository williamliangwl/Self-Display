<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'user',
                'username' => 'user',
                'password' => bcrypt('user'),
                'role' => 'BRANCH'
            ],
            [
                'name' => 'admin',
                'username' => 'admin',
                'password' => bcrypt('admin'),
                'role' => 'ADMIN'
            ],
        ]);
    }
}
