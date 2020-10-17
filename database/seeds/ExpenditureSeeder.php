<?php

use App\Models\Expenditure;
use Illuminate\Database\Seeder;

class ExpenditureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Expenditure::class, 30)->create();
    }
}
