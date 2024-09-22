<?php

namespace Database\Factories;

use App\Models\Note;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoteFactory extends Factory
{
    protected $model = Note::class;

    public function definition()
    {
        // Get a random user ID between 1 and 5
        $userId = \App\Models\User::where('id', '<=', 5)->inRandomOrder()->value('id');

        return [
            'user_id' => $userId ?? \App\Models\User::factory(), // Fallback to new user creation if no users are found
            'title' => $this->faker->sentence,  // Dynamic title using Faker
            'content' => '<p>' . $this->faker->paragraph(5) . '</p>',  // Dynamic HTML content using Faker
        ];
    }
}
