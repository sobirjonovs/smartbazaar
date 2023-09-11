<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\MerchantStatus;
use App\Models\Admin\Admin;
use App\Models\Merchant\Merchant;
use App\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = Admin::create([
            'username' => 'admin',
            'password' => Hash::make('password')
        ]);

        $user = User::create([
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'name' => 'John Doe'
        ]);

        $merchant = Merchant::create([
            'email' => 'merchant@example.com',
            'password' => Hash::make('password'),
            'name' => 'Merchant',
            'description' => 'Description',
            'status' => MerchantStatus::ACTIVE
        ]);
    }
}
