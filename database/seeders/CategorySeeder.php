<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Electronics',
            'Smartphones',
            'Laptops & Computers',
            'Audio & Headphones',
            'Clothing & Fashion',
            'Books & Education',
            'Home & Kitchen',
            'Sports & Fitness',
            'Beauty & Personal Care',
            'Toys & Games',
            'Watches & Accessories',
            'Food & Groceries',
        ];

        foreach ($categories as $name) {
            Category::firstOrCreate(['name' => $name]);
        }
    }
}
