<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Exception;

class UserControlller extends Controller
{
    private $authenticatedUser;

    public function __construct()
    {
        $this->authenticatedUser = auth()->user();
    }



    public function profil()
    {
        try {
            if ($this->authenticatedUser) {
                return new UserResource($this->authenticatedUser);
            }

            return $this->responceForbidden();
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function postsUser()
    {
        try {
            if ($this->authenticatedUser) {
                return $this->authenticatedUser->posts;
            }

            return $this->responceForbidden();
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
