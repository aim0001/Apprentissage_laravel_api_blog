<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LogUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SessionController extends Controller
{

    public function register(RegisterUserRequest $request)
    {

        try {

            // $newUser = User::create([
            //     "name" => $request["name"],
            //     "email" => $request["email"],
            //     "password" => bcrypt($request["password"]),
            // ]);

            $user = new User();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password, [
                'rounds' => 12
            ]); // Hash permet de hasher les mots de passe

            $user->save();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'L\'Utilisateur a été inscrit',
                'user' => new UserResource($user)
            ]);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function login()
    {
        return $this->responceForbidden();
    }

    public function doLogin(LogUserRequest $request)
    {

        if (auth()->attempt($request->only(['email', 'password']))) // auth permet de récupérer l utilisareur connecté, ici le if compare les donner de l utilisateur enregistrer a celui de ce qu on entre dans les champs
        {
            $user = auth()->user(); // Recuperer les info de l utilisateur qui essai de se connecter

            $token = $user->createToken('MA_CLE_SECRETE_VISIBLE_UNIQUEMENT_AU_BACKEND')->plainTextToken;

            // return response()->json([
            //     'status_code' => 200,
            //     'status_message' => 'Utilisateur connecté',
            //     'user' => $user,
            //     'token'=>$token
            // ]);

            return $this->responceOk(
                "User successifull connected !",
                [
                    'user' => new UserResource($user),
                    'token' => $token
                ]
            );
        } else {
            // return response()->json([
            //     'status_code' => 403,
            //     'status_message' => 'Information non valide',
            // ]);

            return $this->responceForbidden(
                "Protected route, you need to authenticate before !"
            );
        }
    }
}
