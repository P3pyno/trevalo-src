<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Call all individual seeders
        $this->call([
            UserSeeder::class,
            SourcingRequestSeeder::class,
            QuoteSeeder::class,
            ShipmentSeeder::class,
            DocumentSeeder::class,
            MessageSeeder::class,
        ]);

        echo "Database seeded successfully!\n";
        echo "Admin Login: test@example.com / password123\n";
        echo "Demo Login: demo@trivalo.com / password\n";
    }
}
