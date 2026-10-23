<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Driver;
use App\Models\ExtraExpense;
use App\Models\ExtraIncome;
use App\Models\LocationPing;
use App\Models\Trip;
use App\Models\Truck;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Sistem Yöneticisi',
            'email' => 'admin@dulgeroglu.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $company = Company::create([
            'name' => 'Hataylo Nakliyat',
            'tax_number' => '1234567890',
            'phone' => '0326 000 00 00',
            'city' => 'Hatay',
            'address' => 'Antakya Organize Sanayi',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Hataylo Operasyon',
            'email' => 'firma@hataylo.com',
            'password' => Hash::make('password'),
            'role' => 'firma',
            'company_id' => $company->id,
            'is_active' => true,
        ]);

        $ahmet = Driver::create([
            'company_id' => $company->id,
            'name' => 'Ahmet Kaya',
            'phone' => '0532 111 22 33',
            'license_no' => 'SRC2-8891',
            'default_wage' => 4500,
            'is_active' => true,
        ]);

        $mehmet = Driver::create([
            'company_id' => $company->id,
            'name' => 'Mehmet Demir',
            'phone' => '0533 444 55 66',
            'license_no' => 'SRC2-4410',
            'default_wage' => 4200,
            'is_active' => true,
        ]);

        $t1 = Truck::create([
            'company_id' => $company->id,
            'plate' => '31 DUL 001',
            'brand' => 'Mercedes',
            'model' => 'Actros',
            'year' => 2021,
            'capacity_kg' => 24000,
            'status' => 'aktif',
            'inspection_due_at' => now()->addDays(18),
            'last_lat' => 40.18,
            'last_lng' => 29.06,
            'last_city' => 'Bursa çevresi',
            'last_located_at' => now()->subHours(2),
        ]);

        $t2 = Truck::create([
            'company_id' => $company->id,
            'plate' => '31 DUL 002',
            'brand' => 'Scania',
            'model' => 'R450',
            'year' => 2019,
            'capacity_kg' => 22000,
            'status' => 'aktif',
            'inspection_due_at' => now()->addMonths(4),
            'last_lat' => 36.20,
            'last_lng' => 36.16,
            'last_city' => 'Hatay',
            'last_located_at' => now()->subMinutes(40),
        ]);

        LocationPing::create(['truck_id' => $t1->id, 'lat' => 40.18, 'lng' => 29.06, 'city' => 'Bursa çevresi']);
        LocationPing::create(['truck_id' => $t2->id, 'lat' => 36.20, 'lng' => 36.16, 'city' => 'Hatay']);

        $trip1 = Trip::create([
            'company_id' => $company->id,
            'truck_id' => $t1->id,
            'driver_id' => $ahmet->id,
            'origin' => 'Hatay',
            'destination' => 'İstanbul',
            'customer' => 'Marmara Lojistik',
            'cargo' => 'Pallet gıda',
            'freight_fee' => 40000,
            'distance_km' => 1100,
            'status' => 'yolda',
            'started_at' => now()->subDays(1),
        ]);
        $trip1->expenses()->createMany([
            ['category' => 'komisyon', 'title' => 'Hatay İstanbul komisyon', 'amount' => 2000, 'occurred_at' => now()->subDays(1)],
            ['category' => 'sofor', 'title' => 'Şoför ücreti', 'amount' => 4500, 'occurred_at' => now()->subDays(1)],
            ['category' => 'yakit', 'title' => 'Adana yakıt', 'amount' => 8200, 'occurred_at' => now()->subHours(18)],
        ]);

        $trip2 = Trip::create([
            'company_id' => $company->id,
            'truck_id' => $t2->id,
            'driver_id' => $mehmet->id,
            'origin' => 'Mersin',
            'destination' => 'Ankara',
            'customer' => 'İç Anadolu Gıda',
            'cargo' => 'Soğuk zincir',
            'freight_fee' => 28500,
            'distance_km' => 490,
            'status' => 'tamamlandi',
            'started_at' => now()->subDays(8),
            'completed_at' => now()->subDays(6),
        ]);
        $trip2->expenses()->createMany([
            ['category' => 'komisyon', 'title' => 'Mersin komisyon', 'amount' => 1500, 'occurred_at' => now()->subDays(8)],
            ['category' => 'sofor', 'title' => 'Şoför ücreti', 'amount' => 4200, 'occurred_at' => now()->subDays(8)],
            ['category' => 'otoyol', 'title' => 'Otoyol', 'amount' => 980, 'occurred_at' => now()->subDays(7)],
            ['category' => 'yakit', 'title' => 'Yakıt', 'amount' => 5400, 'occurred_at' => now()->subDays(7)],
        ]);

        $trip3 = Trip::create([
            'company_id' => $company->id,
            'truck_id' => $t2->id,
            'driver_id' => $mehmet->id,
            'origin' => 'Gaziantep',
            'destination' => 'İzmir',
            'customer' => 'Ege Tekstil',
            'cargo' => 'Kumaş rulo',
            'freight_fee' => 36000,
            'distance_km' => 920,
            'status' => 'tamamlandi',
            'started_at' => now()->subDays(20),
            'completed_at' => now()->subDays(18),
        ]);
        $trip3->expenses()->createMany([
            ['category' => 'komisyon', 'title' => 'Gaziantep İzmir komisyon', 'amount' => 1800, 'occurred_at' => now()->subDays(20)],
            ['category' => 'sofor', 'title' => 'Şoför ücreti', 'amount' => 4200, 'occurred_at' => now()->subDays(20)],
            ['category' => 'yakit', 'title' => 'Yakıt', 'amount' => 7100, 'occurred_at' => now()->subDays(19)],
        ]);

        ExtraIncome::create([
            'company_id' => $company->id,
            'title' => 'Dorse kiralama',
            'amount' => 7500,
            'occurred_on' => now()->subDays(4)->toDateString(),
        ]);

        ExtraExpense::create([
            'company_id' => $company->id,
            'title' => 'Filo kasko taksiti',
            'category' => 'sigorta',
            'amount' => 6200,
            'occurred_on' => now()->startOfMonth()->toDateString(),
        ]);
    }
}
