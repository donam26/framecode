<?php

namespace App\Http\Controllers;

use App\Http\Models\User;
use Core\Response;

class UserController {
    public function index() 
    {
        $user = User::get();
        return Response::json([
            'data' => $user
        ], 201);
    }

    public function home() 
    {
        return Response::json('home', 200);
    }
}