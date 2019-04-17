<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ComputerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Récupère les Ordinateur
     */
    public function all(){

        $computer = Computer::all();

        return $computer;
    
    }

}
