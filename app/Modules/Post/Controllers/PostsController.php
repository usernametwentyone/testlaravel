<?php

namespace App\Modules\Post\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Post\Models\Post;
use App\Modules\Post\Requests\StoreRequest;
use App\Modules\Post\Requests\UpdateRequest;
use App\Modules\Post\Services\PostService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PostsController extends Controller
{
    /**
     * @var PostService
     */
    protected PostService $postService;

    /**
     * @param PostService $postService
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->postService->getAll();
    }

    /**
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $data = array_merge($request->validated(), ['user_id' => auth()->id()]);
        $post = $this->postService->create(data: $data);

        return response()->json($post, Response::HTTP_CREATED);
    }

    /**
     * @param Post $post
     * @return Post
     */
    public function show(Post $post): Post
    {
        return $post;
    }

    /**
     * @param UpdateRequest $request
     * @param Post $post
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Post $post): JsonResponse
    {
        $post = $this->postService->update(id: $post->id, data: $request->validated());
        return response()->json($post);

    }

    /**
     * @param Post $post
     * @return JsonResponse
     */
    public function destroy(Post $post): JsonResponse
    {
        $this->postService->delete(id: $post->id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
