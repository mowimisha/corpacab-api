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
        $this->call(UserSeeder::class);
        // $this->call(VehicleSeeder::class);
        // $this->call(ServiceSeeder::class);
        // $this->call(DocumentSeeder::class);
        // $this->call(ExpenseSeeder::class);
        // $this->call(ExpenditureSeeder::class);
    }
}
