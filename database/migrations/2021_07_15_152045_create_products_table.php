<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        $this->seedProducts();
    }

    private function seedProducts()
    {
        $products = [
            'Automotive',
            'Baby',
            'Beauty & Personal Care',
            'Books',
            'Clothing & Accessories',
            'Electronics',
            'Gift Cards',
            'Grocery & Gourmet Food',
            'Handmade Products',
            'Health & Personal Care',
            'Home',
            'Industrial & Scientific',
            'Jewelry',
            'Luggage & Bags',
            'Movies & TV Shows',
            'Music',
            'Office Products',
            'Patio, Lawn & Garden',
            'Pet Supplies',
            'Shoes & Handbags',
            'Software',
            'Sports & Outdoors',
            'Tools & Home Improvement',
            'Toys & Games',
            'Video Games',
            'Watches',
        ];

        foreach ($products as $product) {
            \App\Models\Product::create(['name' => $product]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
