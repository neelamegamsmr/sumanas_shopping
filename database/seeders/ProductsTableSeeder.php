<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\File;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get(database_path('seeders/data/products.json'));
        $data = json_decode($json);

        foreach ($data as $item) {
            Product::create([
                'name' => $item->name,
                'image' => $item->image,
                'description' => $item->description,
                'price' => $item->price
            ]);
        }
    }
}
