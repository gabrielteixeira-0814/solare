<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'token' => '1055733332',
            'type' => "boards",
        ]);

        Setting::create([
            'token' => '1a6322d9-6881-4cac-ad39-811e7c6c1511',
            'type' => "company",
        ]);

        Setting::create([
            'token' => '1055733332',
            'type' => "monday",
        ]);
    }
}
