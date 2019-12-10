<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert((
        [
            'nik' => '3304110701000001',
            'name' => 'heraya',
            'email' => 'heraya71@gmail.com',
            'password' => Hash::make('12345'),
            'ttl' => 'Banjarnegara, 07/01/2000',
            'address' => 'Slatri Rt 04 RW01',
            'role' => 'admin',
            'no_hp' => '0895378036526'
        ])
        );
    }
}
