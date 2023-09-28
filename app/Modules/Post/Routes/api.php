<?php

use App\Modules\Post\Controllers\PostsController;
use Illuminate\Support\Facades\Route;

Route::resource('posts', PostsController::class);

