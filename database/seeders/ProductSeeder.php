<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert(['name_product' => 'Producto 1','price' => 123.45,'impuesto' => 5,'created_at' => now(), 'updated_at' => now()]);
        DB::table('products')->insert(['name_product' => 'Producto 2','price' => 45.65,'impuesto' => 15,'created_at' => now(), 'updated_at' => now()]);
        DB::table('products')->insert(['name_product' => 'Producto 3','price' => 39.73,'impuesto' => 12,'created_at' => now(), 'updated_at' => now()]);
        DB::table('products')->insert(['name_product' => 'Producto 4','price' => 250.00,'impuesto' => 8,'created_at' => now(), 'updated_at' => now()]);
        DB::table('products')->insert(['name_product' => 'Producto 5','price' => 59.35,'impuesto' => 10,'created_at' => now(), 'updated_at' => now()]);

    }
}
