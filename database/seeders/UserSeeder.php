<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserAddress;
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
        $roles = ['admin', 'member'];
        foreach($roles as $role)
        {
            $user = User::create([
                'name' => $role,
                'email' => $role.'@gmail.com',
                'password' => Hash::make('password123465'),
                'type' => $role
            ]);

            if($role == 'member')
            {
                UserAddress::create([
                    'user_id' => $user->id,
                    'province_id' => '35',
                    'regency_id' => '3573',
                    'district_id' => '3573020',
                    'village_id' => '3573020008',
                    'address' => 'blablablablabablablablabla'
                ]);
            }
        }
    }
}
