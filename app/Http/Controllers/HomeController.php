<?php

namespace App\Http\Controllers;
use Core\Response;

class HomeController {
    public function index() 
    {
        return Response::json('okok', 201);
    }

    public function home() 
    {
        return Response::json('home', 200);
    }
}