<?php

namespace App\Http\Controllers;

use App\Vehicle;
use App\Job;
use App\User;
use App\VehicleBrand;
use App\Equipment;
use App\Search;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Responsibility;
use App\AccountType;
use DB;

class SearchesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //Apis

    
    public function recentSearchByuser(Request $request){
        $accessToken = Auth::user()->token();
        $user = User::where('id', $accessToken->user_id)->first();

        try {
            $recentsearch = Search::where('user_id',$user->id)
            //->where('orign_name','!=', 'AnyWhere')
            //->where('destination_name','!=', 'AnyWhere')
            ->groupBy('orign_name', 'destination_name')
            ->latest()->limit(5)->get();

            if (sizeof($recentsearch) > 0) {
                return response()->json(['success' => true, 'recent-search'=> $recentsearch, 'message' => 'Recent Search fetched Successfully'], 201);
            }else{
                return response()->json(['success' => false,  'message' => 'Recent Search not found.'], 404);
            }
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unable to fetched, please try again.'], 404);
        }
    
    }

    public function favoriteSearchByuser(Request $request){
        $accessToken = Auth::user()->token();
        $user = User::where('id', $accessToken->user_id)->first();

        try {
            $favoritesearch =  Search::select('*', DB::raw('COUNT(*) as count'))
                                ->where('user_id', $user->id)
                                //->where('orign_name','!=', 'AnyWhere')
                                //->where('destination_name','!=', 'AnyWhere')
                                ->groupBy(['orign_name', 'destination_name'])
                                ->having('COUNT', '>' , 1)
                                ->orderBy('count', 'DESC')
                                ->orderBy('id', 'DESC')
                                ->limit(5)
                                ->get();

                                
            if (sizeof($favoritesearch) > 0) {
                return response()->json(['success' => true, 'favorite-search'=> $favoritesearch, 'message' => 'Favorite Search fetched Successfully'], 201);
            }else{
                return response()->json(['success' => false,  'message' => 'Favorite Search not found.'], 404);
            }
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unable to fetched, please try again.'], 404);
        }
    }

    function distance($lat1, $lon1, $lat2, $lon2, $unit = "K") {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

}
