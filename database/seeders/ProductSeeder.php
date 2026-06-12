<?php
namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['category_id'=>1,'name'=>'Crème hydratante rose','price'=>1500,'stock'=>50,'is_featured'=>true],
            ['category_id'=>1,'name'=>'Sérum vitamine C','price'=>2800,'sale_price'=>2200,'stock'=>30,'is_featured'=>true],
            ['category_id'=>2,'name'=>'Huile corps argan','price'=>1200,'stock'=>40,'is_featured'=>false],
            ['category_id'=>3,'name'=>'Rouge à lèvres mat','price'=>800,'stock'=>100,'is_featured'=>true],
            ['category_id'=>4,'name'=>'Eau de parfum florale','price'=>3500,'stock'=>25,'is_featured'=>true],
            ['category_id'=>5,'name'=>'Masque capillaire kératine','price'=>950,'stock'=>60,'is_featured'=>false],
        ];

        foreach ($products as $p) {
            Product::create([
                'category_id' => $p['category_id'],
                'name'        => $p['name'],
                'slug'        => Str::slug($p['name']),
                'description' => 'Produit cosmétique de qualité supérieure.',
                'price'       => $p['price'],
                'sale_price'  => $p['sale_price'] ?? null,
                'stock'       => $p['stock'],
                'is_active'   => true,
                'is_featured' => $p['is_featured'],
            ]);
        }
    }
}