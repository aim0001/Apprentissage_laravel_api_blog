<?php

use App\Http\Controllers\Api\Posts\PostController;
use Illuminate\Support\Facades\Route;


//Récupérer la liste des posts
Route::get('posts', [PostController::class, 'index']);

Route::group(["middleware" => ['auth:sanctum']], function () {
    //Creer un post
    Route::post('posts/create', [PostController::class, 'store']);

    // Le route pour faire l edition
    Route::put('posts/edit/{post}', [PostController::class, 'update']); // passer le poste en parametre au lieu de l id (on pouvait le faire) parce que ça generalise (l'id peut etre une video a modifier) du coup le poste ici index quelque soit l element

    // Supprimer les données 
    Route::delete('posts/{post}', [PostController::class, 'delete']);
});
