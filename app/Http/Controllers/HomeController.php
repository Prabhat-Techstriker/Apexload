<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Vehicle;
use App\Job;
use App\User;
use Illuminate\Support\Facades\Auth;

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
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $users     = Auth::user();
        $postloads = Job::where('status', '1')->orderBy('id', 'desc')->take(5)->get();
        
        $truckspost  = Vehicle::where('status', 1)->orderBy('id', 'desc')->take(5)->get();
        $newTruckspost= [];
        foreach ($truckspost as $key => $truck) {
            $created_by = getCreatedBy($truck['posted_by']);
            $newTruckspost[$key] = $truck;
            $newTruckspost[$key] ['poste_by'] = $created_by;
        }
        $newPostloads = [];
        foreach ($postloads as $key => $postload) {
            $created_by = getCreatedBy($truck['posted_by']);
            $newPostloads[$key] = $truck;
            $newPostloads[$key] ['poste_by'] = $created_by;
        }
        
        return view('dashborad', compact('users','newPostloads','newTruckspost'));
    }
}
