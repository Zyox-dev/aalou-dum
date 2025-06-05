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
            'company_name' => 'Navya Jewellers',
            'address' => '123 Street, City',
            'gstin' => 'GST1234567890',
            'pan_no' => 'PAN1234567',
            'logo' => null,
            'admin_cost_percent' => 5.00,
            'margin_percent' => 67.00,
            'carats' => '9K,14K,18K,22K',
        ]);
    }
}
