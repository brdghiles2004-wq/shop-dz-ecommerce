<?php
namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Soins visage',  'description' => 'Crèmes, sérums, masques visage'],
            ['name' => 'Soins corps',   'description' => 'Lotions, huiles, gommages corps'],
            ['name' => 'Maquillage',    'description' => 'Rouge à lèvres, fond de teint, mascara'],
            ['name' => 'Parfums',       'description' => 'Eau de parfum, body mist'],
            ['name' => 'Cheveux',       'description' => 'Shampoings, masques, huiles capillaires'],
        ];

        foreach ($categories as $cat) {
            Category::create(array_merge($cat, [
                'slug' => Str::slug($cat['name'])
            ]));
        }
    }
}