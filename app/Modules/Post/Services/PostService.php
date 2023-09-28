<?php

namespace App\Modules\Post\Services;

use App\Modules\Post\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PostService
{
    /**
     * Fetch all posts.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Post::all();
    }

    /**
     * Fetch a single post by its ID.
     *
     * @param int $id
     * @return Builder|Model|Collection|Builder[]
     * @throws ModelNotFoundException
     */
    public function getById(int $id): Builder|array|Collection|Model
    {
        return Post::query()->findOrFail($id);
    }

    /**
     * Create a new post.
     *
     * @param array $data
     * @return Post
     */
    public function create(array $data): Post
    {
        return Post::query()->create($data);
    }

    /**
     * Update an existing post.
     *
     * @param int $id
     * @param array $data
     * @return Model
     */
    public function update(int $id, array $data): Model
    {
        $post = $this->getById($id);
        $post->update($data);
        return $post;
    }

    /**
     * Delete a post by its ID.
     *
     * @param int $id
     * @return bool
     * @throws ModelNotFoundException
     */
    public function delete(int $id): bool
    {
        return $this->getById($id)->delete();
    }
}
