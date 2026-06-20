<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::firstOrCreate(['email' => 'admin@swiftcart.com'], [
            'name'     => 'Admin User',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'phone'    => '+92 300 0000000',
            'address'  => 'SwiftCart HQ, Peshawar, KPK',
            'city'     => 'Peshawar',
        ]);

        $buyers = [
            ['name'=>'Ahmed Khan',      'email'=>'ahmed@example.com',   'phone'=>'+92 312 1234567', 'city'=>'Lahore',     'address'=>'House 45, Street 7, Gulberg III, Lahore'],
            ['name'=>'Sara Malik',      'email'=>'sara@example.com',    'phone'=>'+92 333 9876543', 'city'=>'Karachi',    'address'=>'Flat 12B, Block 5, Clifton, Karachi'],
            ['name'=>'Usman Tariq',     'email'=>'usman@example.com',   'phone'=>'+92 321 5556677', 'city'=>'Islamabad',  'address'=>'House 9, F-7/2, Islamabad'],
            ['name'=>'Ayesha Noor',     'email'=>'ayesha@example.com',  'phone'=>'+92 345 1122334', 'city'=>'Peshawar',   'address'=>'University Town, Peshawar'],
            ['name'=>'Bilal Hassan',    'email'=>'bilal@example.com',   'phone'=>'+92 301 9988776', 'city'=>'Faisalabad', 'address'=>'Block D, Eden Gardens, Faisalabad'],
            ['name'=>'Zara Ahmed',      'email'=>'zara@example.com',    'phone'=>'+92 315 4433221', 'city'=>'Multan',     'address'=>'Shah Rukn-e-Alam Colony, Multan'],
            ['name'=>'Omar Farooq',     'email'=>'omar@example.com',    'phone'=>'+92 300 7788990', 'city'=>'Rawalpindi', 'address'=>'Bahria Town Phase 7, Rawalpindi'],
            ['name'=>'Hina Siddiqui',   'email'=>'hina@example.com',    'phone'=>'+92 322 6655443', 'city'=>'Quetta',     'address'=>'Jinnah Town, Quetta'],
            ['name'=>'Fahad Qureshi',   'email'=>'fahad@example.com',   'phone'=>'+92 336 2211009', 'city'=>'Sialkot',    'address'=>'Cantt Area, Sialkot'],
            ['name'=>'Nadia Awan',      'email'=>'nadia@example.com',   'phone'=>'+92 344 8877665', 'city'=>'Hyderabad',  'address'=>'Latifabad Unit 10, Hyderabad'],
        ];

        foreach ($buyers as $b) {
            User::firstOrCreate(['email' => $b['email']], [
                'name'     => $b['name'],
                'password' => Hash::make('password'),
                'role'     => 'buyer',
                'phone'    => $b['phone'],
                'city'     => $b['city'],
                'address'  => $b['address'],
            ]);
        }
    }
}
