<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['inicio']);
    }

    /*
    |--------------------------------------------------------------------------
    | Inicio de la pagina
    |--------------------------------------------------------------------------
    |
    */
   
    public function inicio()
    {
        return view('welcome');
    }

    /*
    |--------------------------------------------------------------------------
    | Inicio de la administracion
    |--------------------------------------------------------------------------
    |
    */
   
    public function index()
    {
        return view('home');
    }
}
