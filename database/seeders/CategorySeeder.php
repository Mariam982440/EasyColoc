<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Alimentation'],
            ['name' => 'Loyer & Charges'],
            ['name' => 'Électricité & Eau'],
            ['name' => 'Internet & TV'],
            ['name' => 'Transports'],
            ['name' => 'Loisirs & Sorties'],
            ['name' => 'Autre'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
