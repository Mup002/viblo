<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Serie;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Article::class;
    public function definition(): array
    {


        $title = $this->faker->sentence();
        $slug = Str::slug($title);
        $randomNumber = rand(1000, 99999);

        $addressUrl = $slug . '/' . $randomNumber;
        return [
            //
           'user_id' => User::factory(),
           'serie_id'=>Serie::factory(),
           'title' => $title,
           'content' => $this -> faker -> paragraph(),
           'is_publish' => true,
           'privacy_id' => 1,
           'views' => $this -> faker -> numberBetween(50,100),
           'is_accept' => true,
           'slug' => $slug,
           'address_url' => $addressUrl,

        ];
    }
}
