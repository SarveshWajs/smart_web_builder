<?php

namespace Database\Seeders;
use App\Models\Theme;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    public function run()
    {
        Theme::create([
            'name' => 'Light Theme',
            'css' => 'body { background-color: #fff; color: #000; }'
        ]);

        Theme::create([
            'name' => 'Dark Theme',
            'css' => 'body { background-color: #000; color: #fff; }'
        ]);
    }
}
