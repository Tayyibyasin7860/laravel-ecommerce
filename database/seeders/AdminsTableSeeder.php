<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!Admin::where('email','admin@admin.com')->exists())
         Admin::create([
             'name' => 'Admin',
             'email' => 'admin@admin.com',
             'password' => bcrypt('admin123')
         ]);
    }
}
