<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $user = User::class;
    public function definition(): array
    {
        return [
            'username' =>$this->faker->username(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'real_name' => $this -> faker -> username(),
            'display_name' => $this -> faker -> name(),
            'role_id'=> 1
        ];
    }

    // public function configure(){
    //     return $this-> afterCreating(function (User $user){
    //         $user->role() -> attach(1);
    //     });
    // }


}
