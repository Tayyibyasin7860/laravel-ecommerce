<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            AdminsTableSeeder::class,
            UsersTableSeeder::class,
            ProductsTableSeeder::class,
            OrdersTableSeeder::class,
            OrderProductsTableSeeder::class,
            TransactionsTableSeeder::class,
        ]);
    }
}
