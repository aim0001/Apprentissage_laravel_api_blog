<?php

use App\Http\Controllers\Api\Comments\CommentController;
use Illuminate\Support\Facades\Route;


// Ajouter un commentaire
Route::post('posts/{postId}/comments', [CommentController::class, 'store']);

// Le route pour faire l edition
Route::put('/comments/{id}', [CommentController::class, 'update']);

// Récupérer les commentaires d'un post
Route::get('posts/{postId}/comments', [CommentController::class, 'index']);

//Affiche tout les commentaire de l utisateur connecté

Route::get('user/comments', [CommentController::class, 'commentsUser']);

// Supprimer un commentaire
Route::delete('comments/{commentId}', [CommentController::class, 'destroy']);
