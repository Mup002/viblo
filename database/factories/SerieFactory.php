<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Serie;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Serie>
 */
class SerieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $serie = Serie::class;
    public function definition(): array
    {
        $title = $this->faker->sentence();
        $slug = Str::slug($title);
        $randomNumber = rand(1000, 99999);

        $addressUrl = $slug . '/' . $randomNumber;
        return [
            'user_id'=>User::factory(),
            'title' => $title,
            'description' => $this->faker->paragraph(),
            'privacy' => 'Public',
            'slug' => $slug,
            'address_url' => $addressUrl,

        ];
    }

    public function configure(){
        return $this->afterCreating((function(Serie $serie){
            $articleCount = random_int(1, 5);
            Article::factory($articleCount)->create(['serie_id' => $serie->serie_id]);
            $serie->update(['articles' => $articleCount]);
        }));
    }
}
