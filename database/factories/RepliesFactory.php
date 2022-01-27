<?php

namespace Database\Factories;

use App\Models\Messages;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RepliesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'text' => $this->faker->paragraph(),
            'user_id' => User::where('is_author','!=',1)->get()->random()->id,
            'message_id' => Messages::all()->random()->id,
        ];
    }
}
