<?php

namespace App\Http\Controllers;

use App\Rating;
use App\Booking;
use App\Job;
use App\User;
use App\Equipment;
use App\VehicleBrand;
use App\Vehicle;
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

class RatingsController extends Controller
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
     * @param  \App\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function show(Rating $rating)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function edit(Rating $rating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rating $rating)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rating $rating)
    {
        //
    }

    // API's

    public function writeRating(Request $request){
        $accessToken = Auth::user()->token();
        $user        = User::where('id', $accessToken->user_id)->first();
        $user_id     = $user->id;
        $validator = Validator::make($request->all(), [
            'booking_id'  => 'required',
            'rating'      => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors(), 'message' => 'Validation failed'], 422);
        }
        try {
            $bookingId   = $request->booking_id;
            $bookings = Booking::query();
            $bookings->where('id', $bookingId)->where('approved', "=", "3")->where('status', "=", "2");
            $data = $bookings->first();
            if (!empty($data)) {
                $request->request->add(['rating_by' => $user_id]);
                if ($data['posted_by'] == $user_id ) {
                    $request->request->add(['rating_to' => $data['requested_by']]); 
                } else {
                    $request->request->add(['rating_to' => $data['posted_by']]);
                }
                $requests = Rating::create($request->all());  
                return response()->json(['success' => true, 'rating'=> $requests, 'message' => 'Rating save successfully'], 201);
            }else {
                return response()->json(['success' => false, 'message' => 'Data not found.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unable to save, please try again.'], 404);
        }
    }

}
