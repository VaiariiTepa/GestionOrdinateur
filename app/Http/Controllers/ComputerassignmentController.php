<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Computerassignment;
use DB;
use App\Visitor;
use App\Computer;
class ComputerassignmentController extends Controller
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
     * Récupère tous les attribution
     */
    // public function all_(){
    //     $computerassignment = Computerassignment::select('visitors.firstname as visiteur','computers.ref as ref','visitors.number as number','visitors.number as number')
    //         ->join('computers','computers.id','=','computerassignment.computer_id')
    //         ->join('visitors','visitors.id','=','computerassignment.visitor_id')
    //         ->get();
    //     // $all_visitor = Visitor::all();
    //     // $all_computer = Computer::all();
    //     // return view('home')->with([
    //     //     'computerassignment'=>$computerassignment,
    //     //     'visitor'=>$all_visitor,
    //     //     'computer'=>$all_computer,
    //     // ]);
    //     return $computerassignment;
    // }

    
    

    /**
     * Assigne un Ordinateur a un Utilisteur
     * @Request
     */
    public function create(Request $request){

        $input = $request->all();

        $assignment = new Computerassignment();
        $assignment ->visitor_id = $input['id_visitor'];
        $assignment ->computer_id = $input['id_computer'];

        //retire le "H" de l'heure
        $hours_trimmed = str_replace("h", "", $input['hours']);

        //formatage heure de début+temps d'attribution
        $range_hours = $input['range_hours'];
        if($range_hours >= 240){
            $range_hours = $range_hours - 240;
            $range_hours = $range_hours+400;
        }elseif($range_hours >= 180){
            $range_hours = $range_hours - 180;
            $range_hours = $range_hours+300;
        }elseif($range_hours >= 120){
            $range_hours = $range_hours - 120;
            $range_hours = $range_hours+200;
        }elseif($range_hours >= 60){
            $range_hours = $range_hours - 60;
            $range_hours = $range_hours+100; 
        }

        //additionne l'heure de début+temps d'attribution
        $finish_hours = $hours_trimmed + $range_hours;

        $assignment ->open = $hours_trimmed;
        $assignment ->close = $finish_hours;

        


        $assignment ->save();
        
        return redirect()->route('home');
        // $all_visitor = Visitor::all();
        // $all_computer = Computer::all();
        // $Computerassignment = Computerassignment::all();
        
        // return view('home')->with([
        //     'visitor'=>$all_visitor,
        //     'computer'=>$all_computer,
        //     'computerassignment'=>$Computerassignment,
        //     ]);
    }

    //Ajax -- récupère les heures d'attribution succèptible d'être disponible
    public function get_hours(Request $request){
        $id_computer = request('id_computer');

        $close_hour_by_computer = Computerassignment::select('close')
        ->where('computer_id','=',$id_computer)
        ->orderby('computer_id','asc')
        ->first();

        $open_hour_by_computer = Computerassignment::select('open')
        ->where('computer_id','=',$id_computer)
        ->get();

        foreach($open_hour_by_computer as $open){
            if($open !== $close_hour_by_computer){
                $propose_hours = $close_hour_by_computer;
                
                return json_encode($propose_hours);
            }
            
        }


    }

    /**
     * Récupère les attribution d'ordinateur
     */
    public function allget(){

        
        $computerassignment = Computerassignment::select('visitors.id as visitor_id','visitors.firstname',
                                'visitors.lastname','visitors.number','visitors.email',
                                'computers.ref','computers.id as computer_id','computerassignment.open','computerassignment.close')
                                ->join('visitors', 'visitors.id', '=', 'computerassignment.visitor_id')

                                ->join('computers', 'computers.id', '=', 'computerassignment.computer_id')

                                ->get();

        return view('home')->with(
            'computerassignment',$computerassignment
        );
    }



}
