<?php

namespace App\Http\Controllers;
use App\Visitor;
use App\Computer;
use App\Computerassignment;
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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        //créer un utilisateur
        $visitor = new Visitor();
        // $visitor->create($input['firstname'],$input['lastname'],$input['number'],$input['email']);
        //récupère les utilisateurs
        $v = $visitor->all();
        //récupère les ordinateur
        $computer = new Computer();
        $c = $computer->all();

        return view('home')->with([
            'visitor'=>$v,
            'computer'=>$c,
            ]);
    }

}
