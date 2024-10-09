<?php

namespace App\Http\Controllers\Api\Posts;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\EditPostRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {

        try {
            $query = Post::query();
            $perPage = 2;
            $page = $request->input('page', 1); // Pour la pagination
            $search = $request->input('search'); // Pour la recherche

            if ($search) {
                $query->whereRaw("titre LIKE '%" . $search . "%'");
            }

            $total = $query->count();

            $result = $query->offset(($page - 1) * $perPage)->limit($perPage)->get();

            return response()->json([
                'status_code' => 200, //ou 201 Permet de dire que la ressourece a été creer
                'status_message' => 'Les posts ont été récupérés.',
                'current_page' => $page,
                'last_page' => ceil($total / $perPage),
                'items' => $result // Post::all()  Récupérer la listes des postes enregistrer dans la base de donnée
            ]);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function store(CreatePostRequest $request)
    { /* CreatePostRequest est une requete Http que j ai creer dans
                                                            Http/Requests pour definir les condition de requete lors de la soumission du formulaire */
        try {
            $post = new Post();
            $post->titre = $request->titre; // Le titre que l utilsateur aura saisis
            $post->description = $request->description; // La description que l utilsateur aura saisis
            $post->user_id = auth()->user()->id; // Recupere les information de l utilisateur connecté via son id
            $post->save();

            return response()->json([
                'status_code' => 200, //ou 201 Permet de dire que la ressourece a été creer
                'status_message' => 'Le post a été ajouté',
                'data' => $post
            ]);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    // Mise a jour
    public function update(Post $post, EditPostRequest $request)
    {

        try {

            $post->titre = $request->titre;
            $post->description = $request->description;

            if ($post->user_id === auth()->user()->id) {
                $post->save();
            } else {
                return response()->json([
                    'status_code' => 422, //ou 201 Permet de dire que la ressourece a été creer
                    'status_message' => 'Vous n\'etes pas l\'auteur de ce post'
                ]);
            }

            return response()->json([
                'status_code' => 200, //ou 201 Permet de dire que la ressourece a été creer
                'status_message' => 'Le post a bien été modifié',
                'data' => $post
            ]);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function delete(Post $post)
    {
        try {
            if ($post->user_id === auth()->user()->id) {
                $post->delete();
            } else {
                return response()->json([
                    'status_code' => 422, //ou 201 Permet de dire que la ressourece a été creer
                    'status_message' => 'Vous n\'etes pas l\'auteur de ce post.Suppression non autorisé'
                ]);
            }

            return response()->json([
                'status_code' => 200, //ou 201 Permet de dire que la ressourece a été creer
                'status_message' => 'Le post a été supprimer',
                'data' => $post
            ]);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }
}
