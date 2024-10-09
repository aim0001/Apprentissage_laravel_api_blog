<?php

namespace App\Http\Controllers\Api\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Ajouter un commentaire
    public function store(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string'
        ]);

        $post = Post::findOrFail($postId); // Vérifie si le post existe

        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->user_id = auth()->user()->id; // L'utilisateur connecté
        $comment->post_id = $post->id;
        $comment->save();

        return response()->json([
            'status_code' => 201,
            'message' => 'Commentaire ajouté avec succès',
            'data' => $comment
        ]);
    }

    //Modifier un commentaire 
    public function update(Comment $comment, EditCommentRequest $request, $id)
    {
        // Récupérer le commentaire par ID
        $comment = Comment::findOrFail($id);

        // Mettre à jour le commentaire avec les données validées
        $comment->update($request->validated());

        return  response()->json([
            'status_code' => 200, //ou 201 Permet de dire que la ressourece a été creer
            'status_message' => 'Le commentaire a bien été modifié',
            'data' => $comment
        ]);
    }

    // Récupérer les commentaires d'un post
    public function index($postId)
    {
        $post = Post::findOrFail($postId);

        $comments = $post->comments()->with('user')->get(); // Récupère les commentaires avec les infos de l'utilisateur

        return response()->json([
            'status_code' => 200,
            'message' => 'Commentaires récupérés avec succès',
            'data' => $comments
        ]);
    }

    // Supprimer un commentaire
    public function destroy($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        if ($comment->user_id === auth()->user()->id) {
            $comment->delete();

            return response()->json([
                'status_code' => 200,
                'message' => 'Commentaire supprimé avec succès',
            ]);
        }

        return response()->json([
            'status_code' => 403,
            'message' => 'Vous n\'êtes pas autorisé à supprimer ce commentaire'
        ], 403);
    }

    //Récupérer tout les commentaire effectuter par l utilisateur
    public function commentsUser()
    {
        $authUser = auth()->user();

        try {
            if ($authUser) {
                return $authUser->comments;
            }

            return $this->responceForbidden();
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
