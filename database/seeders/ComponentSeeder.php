<?php

namespace Database\Seeders;

use App\Models\Component;
use Illuminate\Database\Seeder;

class ComponentSeeder extends Seeder
{
    public function run()
    {
        Component::create([
            'name' => 'Navbar',
            'html' => '<nav>Navbar</nav>',
            'css' => 'nav { background: #eee; padding: 10px; }'
        ]);

        Component::create([
            'name' => 'Footer',
            'html' => '<footer>Footer</footer>',
            'css' => 'footer { background: #ccc; padding: 10px; }'
        ]);
    }
}
