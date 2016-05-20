<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'Item 1',
                'stock' => 10,
                'price' => 50000
            ],
            [
                'name' => 'Item 2',
                'stock' => 120,
                'price' => 30000
            ],
            [
                'name' => 'Item 3',
                'stock' => 17,
                'price' => 83000
            ],
            [
                'name' => 'Item 4',
                'stock' => 5,
                'price' => 150000
            ],
        ]);
    }
}
