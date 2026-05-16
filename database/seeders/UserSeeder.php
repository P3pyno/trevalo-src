<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::firstOrCreate(['email' => 'test@example.com'], [
            'name' => 'Admin User',
            'company' => 'Trivalo',
            'phone' => '+44 7700 123456',
            'country' => 'United Kingdom',
            'is_admin' => true,
            'password' => Hash::make('password123'),
        ]);

        // Demo user
        User::firstOrCreate(['email' => 'demo@trivalo.com'], [
            'name' => 'James Thornton',
            'company' => 'Thornton Brands Ltd.',
            'phone' => '+44 7700 900123',
            'country' => 'United Kingdom',
            'is_admin' => false,
            'password' => Hash::make('password'),
        ]);

        // Additional test users
        User::firstOrCreate(['email' => 'buyer@example.com'], [
            'name' => 'Sarah Mitchell',
            'company' => 'Mitchell Electronics',
            'phone' => '+1 415 555 0147',
            'country' => 'United States',
            'is_admin' => false,
            'password' => Hash::make('password123'),
        ]);

        User::firstOrCreate(['email' => 'sourcing@example.com'], [
            'name' => 'Chen Liu',
            'company' => 'Global Imports Co.',
            'phone' => '+86 10 5555 0123',
            'country' => 'China',
            'is_admin' => false,
            'password' => Hash::make('password123'),
        ]);
    }
}
