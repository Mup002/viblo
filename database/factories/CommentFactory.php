<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   
    public function definition(): array
    {
        $commentables = [
            Article::class,
            Question::class
        ];

        $randomModels = $this->faker->randomElement($commentables);
        $type = $randomModels::inRandomOrder()->first();
    
        if($randomModels === Article::class){
            $id = $type->article_id;
        }else{
            $id = $type->question_id;
        }
        // $id 
        return [
            "content" => $this->faker->paragraph(1),
            "commentable_type"=> $type,
            "commentable_id" => $id,
            "user_id" => User::all()->random(1)->first()->user_id,

        ];
    }
}
