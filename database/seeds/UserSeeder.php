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
                'password' => 'user',
                'role' => 'BRANCH'
            ],
            [
                'name' => 'admin',
                'username' => 'admin',
                'password' => 'admin',
                'role' => 'ADMIN'
            ],
        ]);
    }
}
