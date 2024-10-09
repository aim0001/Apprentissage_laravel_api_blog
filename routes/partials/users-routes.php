<?php

use App\Http\Controllers\Api\Users\UserControlller;
use Illuminate\Support\Facades\Route;


Route::get('user/profil', [UserControlller::class, 'profil']);
Route::get('user/posts', [UserControlller::class, 'postsUser']);
