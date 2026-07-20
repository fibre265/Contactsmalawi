<?php

namespace Database\Seeders;

use App\Models\AboutSetting;
use Illuminate\Database\Seeder;

class AboutSettingsSeeder extends Seeder
{
    public function run(): void
    {
        AboutSetting::updateOrCreate(
            ['key' => 'hero_description'],
            ['value' => 'The unified directory platform bridging communities, professional networks, and local services across all townships and districts of Malawi.']
        );

        AboutSetting::updateOrCreate(
            ['key' => 'mission_statement'],
            ['value' => 'We believe in community visibility. By structuring databases with regional specificity, our goal is to empower small township businesses, promote public transparency, and ensure finding critical support contacts is effortless.']
        );
    }
}