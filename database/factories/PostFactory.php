<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('post.jpg');
        return [
            'user_id' => function(){ return User::factory()->create(); },
            'image' => $file,
            'body' => $this->faker->text(100),
            'title' => $this->faker->text(30),
            'departure' => $this->faker->text(20),
            'arrival' => $this->faker->text(20),
            'distance' => 'nullable|numeric|max:100000',
            'time' => 'nullable|string|max:10',
        ];
    }
}
