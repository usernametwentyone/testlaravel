<?php

namespace Tests\Modules\Post\Feature;

use App\Models\User;
use App\Modules\Post\Models\Post;
use Faker\Factory as Faker;
use Faker\Generator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    protected Generator $faker;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create();
    }

    /**
     * @return void
     */
    public function test_can_create_post(): void
    {
        $user = User::factory()->create();

        $postData = [
            'user_id' => $user->id,
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph
        ];

        $this->actingAs($user)
            ->post('/api/posts', $postData)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonFragment(['title' => $postData['title'], 'body' => $postData['body']]);
    }

    /**
     * @return void
     */
    public function test_can_retrieve_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->get("/api/posts/{$post->id}")
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment(['title' => $post->title, 'body' => $post->body]);
    }

    /**
     * @return void
     */
    public function test_can_update_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $updatedData = [
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph
        ];

        $this->put("/api/posts/{$post->id}", $updatedData)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment($updatedData);
    }

    /**
     * @return void
     */
    public function test_can_delete_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->delete("/api/posts/{$post->id}")
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing($post->getTable(), ['id' => $post->id]);
    }

    /**
     * @return void
     */
    public function test_cannot_retrieve_nonexistent_post(): void
    {
        $nonexistentPostId = 9999999999;

        $this->get("/api/posts/{$nonexistentPostId}")
            ->assertStatus(Response::HTTP_NOT_FOUND);
    }

}
