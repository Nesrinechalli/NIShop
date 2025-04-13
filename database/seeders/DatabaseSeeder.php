<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'nishop@gmail.com',
            'password' => Hash::make('nishop999'),
            'is_admin' => true,
        ]);

        // Create regular user
        User::create([
            'name' => 'User',
            'email' => 'nis@gmail.com',
            'password' => Hash::make('nishop999'),
            'is_admin' => false,
        ]);

        // Create categories
        $categories = [
            'Sports & Fitness',
            'Beauty & Personal Care',
            'Toys & Games',
            'Automotive',
        ];

        foreach ($categories as $categoryName) {
            Category::create(['name' => $categoryName]);
        }

        // Create sample products
        $products = [
            [
                'name' => 'Yoga Mat',
                'description' => 'Premium non-slip yoga mat for all fitness levels',
                'price' => 29.99,
                'category_id' => 1,
                'image' => null,
            ],
            [
                'name' => 'Moisturizing Cream',
                'description' => 'Hydrating facial cream with natural ingredients',
                'price' => 24.99,
                'category_id' => 2,
                'image' => null,
            ],
            [
                'name' => 'Board Game Collection',
                'description' => 'Family-friendly board game set with 5 popular games',
                'price' => 39.99,
                'category_id' => 3,
                'image' => null,
            ],
            [
                'name' => 'Car Phone Mount',
                'description' => 'Adjustable smartphone holder for vehicle dashboards',
                'price' => 15.99,
                'category_id' => 4,
                'image' => null,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}