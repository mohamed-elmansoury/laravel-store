<?php
namespace Database\Factories;

use App\Models\Category;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Bezhanov\Faker\Provider\Commerce;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition()
    {
        $this->faker->addProvider(new Commerce($this->faker));

        $name = $this->faker->productName; // Generate name once

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence(15),
            'image' => $this->faker->imageUrl(200, 200, 'technics'),
            'price' => $this->faker->randomFloat(1, 1, 499),
            'compare_price' => $this->faker->randomFloat(1, 500, 999),
            'category_id' => Category::inRandomOrder()->first()->id,

            'featured' => $this->faker->boolean(30),
            'store_id' => Store::inRandomOrder()->first()->id,

        ];
    }
}
