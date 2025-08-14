<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        $materials = [
            'Paper',
            'Plastic',
            'Glass',
            'Metal',
            'Electronics',
            'Organic Waste',
        ];

        foreach ($materials as $name) {
            Material::create(['name' => $name]);
        }
    }
}
