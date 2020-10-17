<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

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
            'name' => "admin",
            'lastname' => "Administrator",
            'email' => 'admin@corpcab.co.ke',
            'phone' => '0712345678',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        DB::table('users')->insert([
            'name' => "corpcab",
            'lastname' => "limited",
            'email' => 'info@corpcab.co.ke',
            'phone' => '0701 294 042',
            'password' => bcrypt('corpcabadmin001'),
            'role' => 'owner',
        ]);
    }
}
