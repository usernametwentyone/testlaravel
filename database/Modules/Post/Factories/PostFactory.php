<?php

namespace Database\Modules\Post\Factories;

use App\Models\User;
use App\Modules\Post\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Post::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => function () {
                return factory(User::class)->create()->id;
            },
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
        ];
    }
}
