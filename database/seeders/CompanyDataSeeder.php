<?php

namespace Database\Seeders;

use App\Models\CompanyData;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CompanyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CompanyData::create([
            'company_name' => 'Navya Jewels.',
            'address' => 'Daga Sethia Parakh Mohalla,Bikaner -334001',
            'gstin' => '27AACCD5599J1ZO',
            'pan_no' => 'AACCD5599J',
            'state_code' => '27',
            'district_code' => '483',
            'city_location' => 'Bikaner',
            'logo' => null,
            'admin_cost_percent' => 5.00,
            'margin_percent' => 67.00,
            'carats' => '9K,14K,18K,22K',
        ]);
    }
}
