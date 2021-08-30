<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Job;
use App\User;
use App\Equipment;
use App\VehicleBrand;
use App\Vehicle;
use App\Notification;
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
use Edujugon\PushNotification\PushNotification;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Core\Timestamp;
use DateTime;


class BookingsController extends Controller
{
    public function __construct()
    {
        $db = new FirestoreClient([
            "projectId" => "appexload"
        ]);
        $this->db = $db;
    }
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
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        //
    }

   // API's
    public function makeRequest(Request $request){
        $accessToken = Auth::user()->token();
        $user = User::where('id', $accessToken->user_id)->first();
        $user_id = $user->id;
        $push = new PushNotification('fcm');
        $validator = Validator::make($request->all(), [
            'posted_by'        => 'required',
            'requested_by'     => 'required',
            'pickup_lat'       => 'required',
            'pickup_long'      => 'required',
            'destination_lat'  => 'required',
            'destination_long' => 'required',
            'distance'         => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors(), 'message' => 'Validation failed'], 422);
        }
        try {
                if ($request->booking_type == "1") { //Driver post loads request
                    $validator = Validator::make($request->all(), [
                       'job_id'        => 'required'
                    ]);
                    if ($validator->fails()) {
                        return response()->json(['success' => false, 'error' => $validator->errors(), 'message' => 'Validation failed'], 422);
                    }
                   $requests = Booking::where('job_id', $request->job_id)->where('requested_by', $request->requested_by)->exists();
                }
                if ($request->booking_type == "2") { //Shipper truck post request
                    $validator = Validator::make($request->all(), [
                       'vehicle_id'        => 'required'
                    ]);
                    if ($validator->fails()) {
                        return response()->json(['success' => false, 'error' => $validator->errors(), 'message' => 'Validation failed'], 422);
                    }
                    $requests = Booking::where('vehicle_id', $request->vehicle_id)->where('requested_by', $request->requested_by)->exists();
                }
                
                if (!empty($requests)) {
                    return response()->json(['success' => false, 'message' => 'Already Requested'], 404);
                } else {

                    $request->request->add(['approved' => 1]);
                   
                    $booking = Booking::create($request->all());

                    // Sent notification
                    if ($request->posted_by != $user_id) {
                        $reciver_id =  $request->posted_by;
                    }
                    if ($request->requested_by != $user_id) {
                        $reciver_id = $request->requested_by;
                    }
                    $reciverInfo  = User::where('id', $reciver_id)->first();

                    if (!empty($reciverInfo)) {
                        $title = 'You have new request!!';
                        $datas = 'You have new request.';
                        $response = $push->setMessage(['body'=>$datas,'title'=>$title, 'click_action' => "FLUTTER_NOTIFICATION_CLICK"])
                                         ->setApiKey('AAAA8IlH1LM:APA91bEwEqR-qe_Oxk2_WF-QXZSi_0oGofBUgnUpaMm0V40k0t1_E1L5TP96SB-NnuG9zkt_WrBVDV_Fi-86NdsVftD9q8zDXT-o_r0hG9gt-OvMR2z1IbV2E5FBtBv77QbyG775Pty9')
                                         ->setDevicesToken([$reciverInfo['device_token']])
                                         ->send()
                                         ->getFeedback();
                        $request->request->add(['sender_id' => $request->requested_by]);
                        $request->request->add(['receiver_id' => $reciverInfo['id']]);
                        $request->request->add(['title' => $title]);
                        $request->request->add(['data' => $datas]);
                        $array = json_decode(json_encode($response), true);
                        if ($array['success'] == 1) {
                            Notification::create($request->only('sender_id', 'receiver_id', 'title', 'data'));
                        }
                    }
                }
                // end notification
            return response()->json(['success' => true, 'request'=> $request, 'message' => 'Request sent Successfully'], 201);   
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unable to send, please try again.'], 404);
        }
    }

    public function myrequestEquipment($datas) {
        $names = [];
        foreach ($datas as $key => $equipment) {
            $equipment = json_decode(json_encode($equipment), true);
            $ids = explode(",", $equipment['jobs']['equipment']);
            $equipment['eqp_types'] = Equipment::select('type')->whereIn('id', $ids)->get();
            $names[$key] = $equipment;
        }
        return $names;
    }

    public function myoffersEquipment($datas) {
        $names = [];
        foreach ($datas as $key => $equipment) {
            $equipment = json_decode(json_encode($equipment), true);
            $ids = explode(",", $equipment['trucks']['equipment']);
            $equipment['eqp_types'] = Equipment::select('type')->whereIn('id', $ids)->get();
            $names[$key] = $equipment;
        }
        return $names;
    }

    public function getAllrequestpostloadByuser(Request $request){ // driver side
        $accessToken = Auth::user()->token();
        $user = User::where('id', $accessToken->user_id)->first();
        $user_id = $user->id;
        
        try {
        
            $jobsIds = Booking::where('requested_by',$user_id)->where('job_id', '!=', null)->pluck('job_id');
            $offers = Booking::where('posted_by',$user_id)->where('vehicle_id', '!=', null)->pluck('vehicle_id');

            $myrequestes   = []; 
            $allmyrequeste = [];
            $myoffer = [];
            if ($jobsIds->isNotEmpty()) {
                $myrequestes = Booking::with('jobs','user_data:id,first_name,last_name,email,phone_number,profile_image')->where('requested_by',$user_id)->where('job_id', '!=', null)->where('status', '!=', 2)->get();
                $myrequestes = $this->myrequestEquipment($myrequestes);

                foreach ($myrequestes as $key => $myoffer) {
                    
                    //$truckspost = VehicleBrand::select('brand_name')->where('id', '=', $myoffer['trucks']['vehicle_brand'])->get();
                    //$myoffer['trucks']['brand_name'] = $truckspost[0]['brand_name'];
                    $myoffer['jobs']['distance'] = $myoffer['distance'];
                    unset($myoffer['distance']);
                    $allmyrequeste[]  = $myoffer;
                }
            }

            $names = [];
            if ($offers->isNotEmpty()) {
                $myoffer = Booking::with('trucks','userByrequested:id,first_name,last_name,email,phone_number,profile_image')->where('posted_by',$user_id)->where('vehicle_id', '!=', null)->where('status', '!=', 2)->get();
               
                $myoffers = $this->myoffersEquipment($myoffer);
                foreach ($myoffers as $key => $myoffer) {
                    //$truckspost = VehicleBrand::select('brand_name')->where('id', '=', $myoffer['trucks']['vehicle_brand'])->get();
                    $myoffer['trucks']['distance'] = $myoffer['distance'];
                    unset($myoffer['distance']);
                    $names[]  = $myoffer;
                }
            }

            if ((!empty($myrequestes)) || (!empty($names))) {
                return response()->json(['success' => true, 'myrequestes' => $allmyrequeste, 'offers' => $names, 'message' => 'Data fetche Successfully'], 201);
            } else {
                return response()->json(['success' => false, 'message' => 'Data not found.'], 404);
            }
           
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unable to fetche, please try again.'], 404);
        }
    }

    public function getAllrequesttrucksByuser(Request $request){ //shhiper side
        $accessToken = Auth::user()->token();
        $user = User::where('id', $accessToken->user_id)->first();
        $user_id = $user->id;

        try {
            $vehilesIds = Booking::where('requested_by',$user_id)->where('vehicle_id', '!=', null)->pluck('vehicle_id');
            $offers = Booking::where('posted_by',$user_id)->where('job_id', '!=', null)->pluck('job_id');

            $myrequestes = [];
            $myoffers  = [];
            $myoffersData  = [];
            $myrequest = [];
            if ($vehilesIds->isNotEmpty()) {
                $myrequestes = Booking::with('trucks','user_data:id,first_name,last_name,email,phone_number,profile_image')->where('requested_by',$user_id)->where('vehicle_id', '!=', null)->where('status', '!=', 2)->get();
                $myrequestes = $this->myoffersEquipment($myrequestes);
                
                foreach ($myrequestes as $key => $myoffer) {
                    //$truckspost = VehicleBrand::select('brand_name')->where('id', '=', $myoffer['trucks']['vehicle_brand'])->get();
                    //$myoffer['trucks']['brand_name'] = $truckspost[0]['brand_name'];
                    $myoffer['trucks']['brand_name'] = $myoffer['trucks']['vehicle_brand'];
                    $myoffer['trucks']['distance'] = $myoffer['distance'];
                    unset($myoffer['distance']);
                    $myrequest[]  = $myoffer;
                }
            }
            if ($offers->isNotEmpty()) {
               $myoffers = Booking::with('jobs','userByrequested:id,first_name,last_name,email,phone_number,profile_image')->where('posted_by',$user_id)->where('job_id', '!=', null)->where('status', '!=', 2)->get();
                $myoffers = $this->myrequestEquipment($myoffers);
                foreach ($myoffers as $key => $myoffer) {
                    $myoffer['jobs']['distance'] = $myoffer['distance'];
                    unset($myoffer['distance']);
                    $myoffersData[]  = $myoffer;
                }
            }
            if ((!empty($myrequest)) || (!empty($myoffers))) {
                return response()->json(['success' => true, 'myrequestes'=> $myrequest, 'offers'=> $myoffersData, 'message' => 'Data fetche Successfully'], 201);
            } else {
                return response()->json(['success' => false, 'message' => 'Data not found.'], 404);
            }

        } catch (\Exception $e) {
            print_r($e);
            return response()->json(['success' => false, 'message' => 'Unable to fetche, please try again.'], 404);
        }
    }


    public function approveRequest(Request $request){
        $accessToken = Auth::user()->token();
        $user        = User::where('id', $accessToken->user_id)->first();
        $user_id     = $user->id;
        $bookingId   = $request->booking_id;
        $push = new PushNotification('fcm'); 

        try {
            $bookings = Booking::query();
            $bookings->where('id', $bookingId);
            $data = $bookings->get();
            if ($data->contains('requested_by', $user_id) || $data->contains('posted_by', $user_id) ){
              $bookings = Booking::findOrFail($bookingId);
              $bookings->update(['approved' => 2]);
                // Sent notification
                if ($data[0]['posted_by'] != $user_id) {
                    $reciver_id =  $data[0]['posted_by'];
                }
                if ($data[0]['requested_by'] != $user_id) {
                    $reciver_id = $data[0]['requested_by'];
                }
                $reciverInfo  = User::where('id', $reciver_id)->first();

                if (!empty($reciverInfo)) {
                    $title = 'Accepted request!!';
                    $datas = 'Accepted request Successfully';
                    $response = $push->setMessage(['body'=>$datas,'title'=>$title, 'click_action' => "FLUTTER_NOTIFICATION_CLICK"])
                                     ->setApiKey('AAAA8IlH1LM:APA91bEwEqR-qe_Oxk2_WF-QXZSi_0oGofBUgnUpaMm0V40k0t1_E1L5TP96SB-NnuG9zkt_WrBVDV_Fi-86NdsVftD9q8zDXT-o_r0hG9gt-OvMR2z1IbV2E5FBtBv77QbyG775Pty9')
                                     ->setDevicesToken([$reciverInfo['device_token']])
                                     ->send()
                                     ->getFeedback();
                    $request->request->add(['sender_id' => $user_id]);
                    $request->request->add(['receiver_id' => $reciverInfo['id']]);
                    $request->request->add(['title' => $title]);
                    $request->request->add(['data' => $datas]);
                    $array = json_decode(json_encode($response), true);
                    if ($array['success'] == 1) {
                        Notification::create($request->only('sender_id', 'receiver_id', 'title', 'data'));
                    }
                }
                // end notification

              return response()->json(['success' => true, 'myrequests'=> $bookings, 'message' => 'Request accepted Successfully'], 201);
            }else{
                return response()->json(['success' => false, 'message' => 'Request not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unable to accpeted, please try again.'], 404);
        } 
    }

    public function hiredRequest(Request $request){
        $accessToken = Auth::user()->token();
        $user        = User::where('id', $accessToken->user_id)->first();
        $user_id     = $user->id;
        $bookingId   = $request->booking_id;
        $push = new PushNotification('fcm'); 

        try { 
            $bookings = Booking::query();
            $bookings->where('id', $bookingId);
            $data = $bookings->get();
            if ($data->contains('requested_by', $user_id) || $data->contains('posted_by', $user_id) ){
                $bookings = Booking::findOrFail($bookingId);
                $bookings->update(['approved' => 3]);
                // Sent notification
                if ($data[0]['posted_by'] != $user_id) {
                    $reciver_id =  $data[0]['posted_by'];
                }
                if ($data[0]['requested_by'] != $user_id) {
                    $reciver_id = $data[0]['requested_by'];
                }
                $reciverInfo  = User::where('id', $reciver_id)->first();

                if (!empty($reciverInfo)) {
                    $title = 'Hired';
                    $datas = 'Hire Successfully';
                    $response = $push->setMessage(['body'=>$datas,'title'=>$title, 'click_action' => "FLUTTER_NOTIFICATION_CLICK" ])
                                     ->setApiKey('AAAA8IlH1LM:APA91bEwEqR-qe_Oxk2_WF-QXZSi_0oGofBUgnUpaMm0V40k0t1_E1L5TP96SB-NnuG9zkt_WrBVDV_Fi-86NdsVftD9q8zDXT-o_r0hG9gt-OvMR2z1IbV2E5FBtBv77QbyG775Pty9')
                                     ->setDevicesToken([$reciverInfo['device_token']])
                                     ->send()
                                     ->getFeedback();
                    $request->request->add(['sender_id' => $user_id]);
                    $request->request->add(['receiver_id' => $reciverInfo['id']]);
                    $request->request->add(['title' => $title]);
                    $request->request->add(['data' => $datas]);
                    $array = json_decode(json_encode($response), true);
                    if ($array['success'] == 1) {
                        Notification::create($request->only('sender_id', 'receiver_id', 'title', 'data'));
                    }
                }
                // end notification
                if ($bookings['job_id'] != NULL ) {
                    $job = Job::findOrFail($bookings['job_id']);
                    $job->update(['status' => 0]);
                }else{
                    $vehicle = Vehicle::findOrFail($bookings['vehicle_id']);
                    $vehicle->update(['status' => 0]);
                }
                return response()->json(['success' => true, 'myrequests'=> $bookings, 'message' => 'Hire Successfully'], 201);
            }else{
                return response()->json(['success' => false, 'message' => 'Request not found'], 404);
            }
               
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unable to accpeted, please try again.'], 404);
        } 
    }

    
    public function startRide(Request $request){
        $accessToken = Auth::user()->token();
        $user        = User::where('id', $accessToken->user_id)->first();
        $user_id     = $user->id;
        $bookingId   = $request->booking_id;
        $push = new PushNotification('fcm');

        try {   
            $bookings = Booking::query();
            $bookings->where('id', $bookingId)->where('approved', "=", "3");
            $data = $bookings->get();
            
            if ($data[0]['posted_by'] != $user_id) {
                $reciver_id =  $data[0]['posted_by'];
            }
            if ($data[0]['requested_by'] != $user_id) {
                $reciver_id = $data[0]['requested_by'];
            }
            $reciverInfo  = User::where('id', $reciver_id)->first();

            if (!empty($reciverInfo)) {
                $title = 'Start Ride';
                $datas = 'Start ride Successfully';
                $response = $push->setMessage(['body'=>$datas,'title'=>$title,'click_action' => "FLUTTER_NOTIFICATION_CLICK"])
                                 ->setApiKey('AAAA8IlH1LM:APA91bEwEqR-qe_Oxk2_WF-QXZSi_0oGofBUgnUpaMm0V40k0t1_E1L5TP96SB-NnuG9zkt_WrBVDV_Fi-86NdsVftD9q8zDXT-o_r0hG9gt-OvMR2z1IbV2E5FBtBv77QbyG775Pty9')
                                 ->setDevicesToken([$reciverInfo['device_token']])
                                 ->send()
                                 ->getFeedback();
                $request->request->add(['sender_id' => $user_id]);
                $request->request->add(['receiver_id' => $reciverInfo['id']]);
                $request->request->add(['title' => $title]);
                $request->request->add(['data' => $datas]);
                $array = json_decode(json_encode($response), true);
                if ($array['success'] == 1) {
                    
                    Notification::create($request->only('sender_id', 'receiver_id', 'title', 'data'));
                }
            }
            
            if ($data->contains('requested_by', $user_id) || $data->contains('posted_by', $user_id) ){
                $bookings = Booking::findOrFail($bookingId);
                $bookings->update(['status' => 1]);
                if ($bookings['vehicle_id'] != NULL ) {
                    $vehicle = Vehicle::findOrFail($bookings['vehicle_id']);
                    $vehicle->update(['status' => 1]);
                }
                return response()->json(['success' => true, 'myrequests'=> $bookings, 'message' => 'Start ride Successfully'], 201);
            }else{
                return response()->json(['success' => false, 'message' => 'Data not found'], 404);
            }
             
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unable to accpeted, please try again.'], 404);
        } 
    }

    public function completedJob(Request $request){
        $accessToken = Auth::user()->token();
        $user        = User::where('id', $accessToken->user_id)->first();
        $user_id     = $user->id;
        $bookingId   = $request->booking_id;
        $push        = new PushNotification('fcm'); 

        try {
            $bookings = Booking::query();
            $bookings->where('id', $bookingId)->where('approved', "=", "3")->where('status', '=', '1');
            $data = $bookings->get();

            if ($data->contains('requested_by', $user_id) || $data->contains('posted_by', $user_id) ){
                $bookings = Booking::findOrFail($bookingId);
                $bookings->update(['status' => 2]);
                if ($bookings['vehicle_id'] != NULL ) {
                    $vehicle = Vehicle::findOrFail($bookings['vehicle_id']);
                    $vehicle->update(['status' => 1]);
                }

                // Sent notification
                if ($data[0]['posted_by'] != $user_id) {
                    $reciver_id =  $data[0]['posted_by'];
                }
                if ($data[0]['requested_by'] != $user_id) {
                    $reciver_id = $data[0]['requested_by'];
                }
                $reciverInfo  = User::where('id', $reciver_id)->first();

                if (!empty($reciverInfo)) {
                    $title = 'Completed Ride';
                    $datas = 'Completed ride Successfully';
                    $response = $push->setMessage(['body'=>$datas,'title'=>$title , 'click_action' => "FLUTTER_NOTIFICATION_CLICK"])
                                     ->setApiKey('AAAA8IlH1LM:APA91bEwEqR-qe_Oxk2_WF-QXZSi_0oGofBUgnUpaMm0V40k0t1_E1L5TP96SB-NnuG9zkt_WrBVDV_Fi-86NdsVftD9q8zDXT-o_r0hG9gt-OvMR2z1IbV2E5FBtBv77QbyG775Pty9')
                                     ->setDevicesToken([$reciverInfo['device_token']])
                                     ->send()
                                     ->getFeedback();
                    $request->request->add(['sender_id' => $user_id]);
                    $request->request->add(['receiver_id' => $reciverInfo['id']]);
                    $request->request->add(['title' => $title]);
                    $request->request->add(['data' => $datas]);
                    $array = json_decode(json_encode($response), true);
                    if ($array['success'] == 1) {
                        Notification::create($request->only('sender_id', 'receiver_id', 'title', 'data'));
                    }
                }
                // end notification
                return response()->json(['success' => true, 'myrequests'=> $bookings, 'message' => 'Job completed Successfully'], 201);
            }else{
                return response()->json(['success' => false, 'message' => 'Data not found'], 404);
            }
                
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unable to accpeted, please try again.'], 404);
        } 
    }

    public function equipmentdata($datas) {
        $names = [];
        foreach ($datas as $key => $equipment) {
            $equipment = json_decode(json_encode($equipment), true);
            $ids = explode(",", $equipment['equipment']);
            $equipment['eqp_types'] = Equipment::select('type')->whereIn('id', $ids)->get();
            $names[$key] = $equipment;
        }
        return $names;
    }
    
    public function getCompletedJob(Request $request){  //get all completed job by driver side
        $accessToken = Auth::user()->token();
        $user        = User::where('id', $accessToken->user_id)->first();
        $user_id     = $user->id;

        try {
            $bookings = Booking::query();
            $bookings->where('approved', 3)
                      ->where('status', 2)
                      ->where(function($query) use($user_id) {
                            $query->orWhere('requested_by', $user_id);
                            $query->orWhere('posted_by', $user_id);
                      });
            $datas = $bookings->get();
            $newResult = [];
            $newFinalResult = [];
            $i=0;
            $j=0;
            foreach ($datas as $data) {
                if ($data['requested_by'] == $user_id) { // shipper side
                    $newResult['my_request'][$i] = $data;
                    $newResult['my_request'][$i]['job_detail'] = $this->getJobDetail($data['job_id']);
                    $newResult['my_request'][$i]['job_detail']['distance'] = $data['distance'];
                    unset($data['distance']);
                    ++$i;
                }else{
                   // $newResult['my_request'][$i] = [];
                }

                if($data['posted_by'] == $user_id) { // driver side request_by
                  $newResult['my_offers'][$j] = $data;
                    $newResult['my_offers'][$j]['vehicle_detail'] = $this->getVehicleDetail($data['vehicle_id']);
                    $newResult['my_offers'][$i]['vehicle_detail']['distance'] = $data['distance'];
                    unset($data['distance']);
                    ++$j;
                }else{
                    // $newResult['my_offers'][$j] = [];
                }
            }

            if (isset($newResult['my_request'])) {
                $newFinalResult['my_request'] = $newResult['my_request'];
            }else{
                $newFinalResult['my_request'] = [];
            }

            if (isset($newResult['my_offers'])) {
                $newFinalResult['my_offers'] = $newResult['my_offers'];
            }else{
                $newFinalResult['my_offers'] = [];
            }


            if (sizeof($newResult) > 0) {
                return response()->json(['success' => true, 'data' => $newFinalResult  , 'message' => 'My history fetched Successfully'], 201);
            }else{
                return response()->json(['success' => false, 'message' => 'Data not found'], 404);
            }

        } catch (\Exception $e) {
            print_r($e);
            return response()->json(['success' => false, 'message' => 'Unable to accpeted, please try again.'], 404);
        }  
    }

    public function getVehicleDetail($id = null)
    {
       $trucksposts = Vehicle::where('id', $id)->first();
        return $trucksposts; 
    }

    public function getJobDetail($id = null)
    {
         $jobPost = Job::where('id',$id)->first();

        return $jobPost; 
    }

    public function getHistory(Request $request){  //get all completed job by shipper side
        $accessToken = Auth::user()->token();
        $user        = User::where('id', $accessToken->user_id)->first();
        $user_id     = $user->id;
        
        try {
            $bookings = Booking::query();
            $bookings->where('approved', 3)
                      ->where('status', 2)
                      ->where(function($query) use($user_id) {
                            $query->orWhere('requested_by', $user_id);
                            $query->orWhere('posted_by', $user_id);
                      });
            $datas = $bookings->get();

            $newResult = [];
            $newFinalResult = [];
            $i=0;
            $j=0;

            foreach ($datas as  $key => $data) {
                if ($data['requested_by'] == $user_id && $data['vehicle_id'] != '') { // shipper side
                    $newResult['my_request'][$i] = $data;
                    $newResult['my_request'][$i]['vehicle_detail'] = $this->getVehicleDetail($data['vehicle_id']);
                    $newResult['my_request'][$i]['vehicle_detail']['distance'] = $data['distance'];
                    unset($data['distance']);
                    ++$i;
                }else{
                    //$newResult['my_request'][$j] = [NULL];
                }
            }

            foreach ($datas as  $key => $data) {
                if($data['posted_by'] == $user_id && $data['job_id'] != '') { // driver side request_by
                    $newResult['my_offers'][$j] = $data;
                    $newResult['my_offers'][$j]['job_detail'] = $this->getJobDetail($data['job_id']);
                    $newResult['my_offers'][$i]['job_detail']['distance'] = $data['distance'];
                    unset($data['distance']);
                    ++$j;
                }else{
                    //$newResult['my_offers'][$j] = [NULL];
                }
            }

            if (isset($newResult['my_request'])) {
                $newFinalResult['my_request'] = $newResult['my_request'];
            }else{
                $newFinalResult['my_request'] = [];
            }

            if (isset($newResult['my_offers'])) {
                $newFinalResult['my_offers'] = $newResult['my_offers'];
            }else{
                $newFinalResult['my_offers'] = [];
            
            }

            if (sizeof($newResult) > 0) {
                return response()->json(['success' => true, 'data' => $newFinalResult  , 'message' => 'My history fetched Successfully'], 201);
            }else{
                return response()->json(['success' => false, 'message' => 'Data not found'], 404);
            }
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unable to accpeted, please try again.'], 404);
        } 
    }

    // Get Notification

    public function getNotifications(){
        $accessToken = Auth::user()->token();
        $user        = User::where('id', $accessToken->user_id)->first();
        $user_id     = $user->id;
        try {
            $notification = Notification::select('title','data','created_at')
                             ->where('status', 0)
                             ->where('receiver_id', $user_id)
                             ->get();

            if (sizeof($notification)> 0) {
                return response()->json(['success' => true, 'notifications' => $notification  , 'message' => 'Notification fetched Successfully'], 201);
            } else {
                return response()->json(['success' => false, 'message' => 'Data not found'], 404);
            }
        } catch (Exception $e) {
           return response()->json(['success' => false, 'message' => 'Unable to accpeted, please try again.'], 404);
        }
    }


    public function getCompletedJobWeb(Request $request){  //get all completed job by driver side
        //$accessToken = Auth::user()->token();
        $id = Auth::user()->id;
        $user        = User::where('id', $id)->first();
        $user_id     = $user->id;

        try {
            $bookings = Booking::query();
            $bookings->where('approved', 3)
                      ->where('status', 2)
                      ->where(function($query) use($user_id) {
                            $query->orWhere('requested_by', $user_id);
                            $query->orWhere('posted_by', $user_id);
                      });
            $datas = $bookings->get();
            $newResult = [];
            $i=0;
            $j=0;

            foreach ($datas as $data) {
                if ($data['requested_by'] == $user_id) { // shipper side
                    $newResult['my_request'][$i] = $data;
                    $newResult['my_request'][$i]['job_detail'] = $this->getJobDetail($data['job_id']);
                    ++$i;
                }else{
                   // $newResult['my_request'][$i] = [];
                }

                if($data['posted_by'] == $user_id) { // driver side request_by
                  $newResult['my_offers'][$j] = $data;
                    $newResult['my_offers'][$j]['vehicle_detail'] = $this->getVehicleDetail($data['vehicle_id']);
                    ++$j;
                }else{
                    // $newResult['my_offers'][$j] = [];
                }
            }
            
            if (sizeof($newResult) > 0) {
                
                return view('trucks.history', compact('user','newResult',));
            }else{
                
                return view('trucks.history', compact('user' , 'newResult'));
            }

        } catch (\Exception $e) {
            return view('shippers.history');
        }  
    }

    public function getHistoryWeb(Request $request){  //get all completed job by shipper side
        $id = Auth::user()->id;
        $user        = User::where('id', $id)->first();
        $user_id     = $user->id;
        
        try {
            $bookings = Booking::query();
            $bookings->where('approved', 3)
                      ->where('status', 2)
                      ->where(function($query) use($user_id) {
                            $query->orWhere('requested_by', $user_id);
                            $query->orWhere('posted_by', $user_id);
                      });
            $datas = $bookings->get();

            $newResult = [];
            $newFinalResult = [];
            $i=0;
            $j=0;

            foreach ($datas as  $key => $data) {
                if ($data['requested_by'] == $user_id && $data['vehicle_id'] != '') { // shipper side
                    $newResult['my_request'][$i] = $data;
                    $newResult['my_request'][$i]['vehicle_detail'] = $this->getVehicleDetail($data['vehicle_id']);
                    ++$i;
                }else{
                    //$newResult['my_request'][$j] = [NULL];
                }
            }

            foreach ($datas as  $key => $data) {
                if($data['posted_by'] == $user_id && $data['job_id'] != '') { // driver side request_by
                    $newResult['my_offers'][$j] = $data;
                    $newResult['my_offers'][$j]['job_detail'] = $this->getJobDetail($data['job_id']);
                    ++$j;
                }else{
                    //$newResult['my_offers'][$j] = [NULL];
                }
            }


            if (isset($newResult['my_request'])) {
                $newFinalResult['my_request'] = $newResult['my_request'];
            }else{
                $newFinalResult['my_request'] = [];
            }

            if (isset($newResult['my_offers'])) {
                $newFinalResult['my_offers'] = $newResult['my_offers'];
            }else{
                $newFinalResult['my_offers'] = [];
            
            }
            
            if (sizeof($newFinalResult) > 0) {
                
                return view('shippers.history', compact('user','newResult',));
            }else{
                
                return view('shippers.history', compact('user' , 'newResult'));
            }
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unable to accpeted, please try again.'], 404);
        } 
    }


    public function historyView(Request $request,$reqid){  //get all completed job by driver side
        //$accessToken = Auth::user()->token();
        $id = Auth::user()->id;
        $user        = User::where('id', $id)->first();
        $user_id     = $user->id;

        try {
            $bookings = Booking::query();
            $bookings->where('approved', 3)
                      ->where('status', 2)
                      ->where('id', $reqid)
                      ->where(function($query) use($user_id) {
                            $query->orWhere('requested_by', $user_id);
                            $query->orWhere('posted_by', $user_id);
                      });
            $data = $bookings->first();
            $newResult = [];
            $i=0;
            $j=0;


            if ($data['requested_by'] == $user_id) { // shipper side
                $newResult = $data;
                $newResult['job_detail'] = $this->getJobDetail($data['job_id']);
                ++$i;
            }else{
               // $newResult['my_request'][$i] = [];
            }

            if($data['posted_by'] == $user_id) { // driver side request_by
                $newResult = $data;
                $newResult['vehicle_detail'] = $this->getVehicleDetail($data['vehicle_id']);
                ++$j;
            }else{
                // $newResult['my_offers'][$j] = [];
            }
            
            if ($newResult) {
                
                return view('trucks.history-view', compact('user','newResult',));
            }else{
                
                return view('trucks.history-view', compact('user' , 'newResult'));
            }

        } catch (\Exception $e) {
            return view('trucks.history-view', compact('user' ));
        }  
    }


    public function historyViewShipper(Request $request,$reqid){  //get all completed job by driver side
        //$accessToken = Auth::user()->token();
        $id = Auth::user()->id;
        $user        = User::where('id', $id)->first();
        $user_id     = $user->id;

        try {
            $bookings = Booking::query();
            $bookings->where('approved', 3)
                      ->where('status', 2)
                      ->where('id', $reqid)
                      ->where(function($query) use($user_id) {
                            $query->orWhere('requested_by', $user_id);
                            $query->orWhere('posted_by', $user_id);
                      });
            $data = $bookings->first();
            $newResult = [];
            $i=0;
            $j=0;

            
            if ($data['requested_by'] == $user_id && $data['vehicle_id'] != '') { // shipper side
                $newResult = $data;
                $newResult['vehicle_detail'] = $this->getVehicleDetail($data['vehicle_id']);
                ++$i;
            }else{
                //$newResult['my_request'][$j] = [NULL];
            }
            

            if($data['posted_by'] == $user_id && $data['job_id'] != '') { // driver side request_by
                $newResult = $data;
                $newResult['job_detail'] = $this->getJobDetail($data['job_id']);
                ++$j;
            }else{
                //$newResult['my_offers'][$j] = [NULL];
            }
            
                       
            if ($newResult) {
                return view('shippers.history-view', compact('user','newResult',));
            }else{
                return view('shippers.history-view', compact('user' , 'newResult'));
            }

        } catch (\Exception $e) {
            return view('shippers.history-view', compact('user' ));
        }  
    }

    public function getAllrequesttrucksByuserWeb(Request $request){ //shhiper side
       
            $id = Auth::user()->id;
            $user        = User::where('id', $id)->first();
            $user_id     = $user->id;
        

        try {
            $vehilesIds = Booking::where('requested_by',$user_id)->where('vehicle_id', '!=', null)->pluck('vehicle_id');
            $offers = Booking::where('posted_by',$user_id)->where('job_id', '!=', null)->pluck('job_id');

            $myrequestes = [];
            $myoffers  = [];
            $myrequest = [];
            $finalResult = [];
            if ($vehilesIds->isNotEmpty()) {
                $myrequestes = Booking::with('trucks','user_data:id,first_name,last_name,email,phone_number,profile_image')->where('requested_by',$user_id)->where('vehicle_id', '!=', null)->where('status', '!=', 2)->get();
                $myrequestes = $this->myoffersEquipment($myrequestes);
                
                foreach ($myrequestes as $key => $myoffer) {
                    //$truckspost = VehicleBrand::select('brand_name')->where('id', '=', $myoffer['trucks']['vehicle_brand'])->get();
                    //$myoffer['trucks']['brand_name'] = $truckspost[0]['brand_name'];
                    $myoffer['trucks']['brand_name'] = $myoffer['trucks']['vehicle_brand'];
                    $myrequest[]  = $myoffer;
                }
            }
            if ($offers->isNotEmpty()) {
               $myoffers = Booking::with('jobs','userByrequested:id,first_name,last_name,email,phone_number,profile_image')->where('posted_by',$user_id)->where('job_id', '!=', null)->where('status', '!=', 2)->get();
                $myoffers = $this->myrequestEquipment($myoffers);
            }
            
            $finalResult['myrequestes'] = $myrequestes;
            $finalResult['myoffers'] = $myoffers;
        
            if ($myrequestes != '' || $myoffers != '') {
                return view('shippers.myrequest', compact('user','finalResult'));
            }else{
                return view('shippers.myrequest', compact('user' , 'finalResult'));
            }
            

        } catch (\Exception $e) {
            // print_r($e);
            return response()->json(['success' => false, 'message' => 'Unable to fetche, please try again.'], 404);
    
        }
    }

    public function getAllrequestpostloadByuserWeb(Request $request){ // driver side
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $user_id = $user->id;
        
        try {
            $jobsIds = Booking::where('requested_by',$user_id)->where('job_id', '!=', null)->pluck('job_id');
            $offers = Booking::where('posted_by',$user_id)->where('vehicle_id', '!=', null)->pluck('vehicle_id');

            $myrequestes   = []; 
            $myoffer = [];
            $finalResult = [];
            if ($jobsIds->isNotEmpty()) {
                $myrequestes = Booking::with('jobs','user_data:id,first_name,last_name,email,phone_number,profile_image')->where('requested_by',$user_id)->where('job_id', '!=', null)->where('status', '!=', 2)->get();
                $myrequestes = $this->myrequestEquipment($myrequestes);
            }
            
            $names = [];
            if ($offers->isNotEmpty()) {
                $myoffer = Booking::with('trucks','userByrequested:id,first_name,last_name,email,phone_number,profile_image')->where('posted_by',$user_id)->where('vehicle_id', '!=', null)->where('status', '!=', 2)->get();
               
                $myoffers = $this->myoffersEquipment($myoffer);
                foreach ($myoffers as $key => $myoffer) {
                    //$truckspost = VehicleBrand::select('brand_name')->where('id', '=', $myoffer['trucks']['vehicle_brand'])->get();
                    $myoffer['trucks']['brand_name'] = $myoffer['trucks']['vehicle_brand'];
                    $names[]  = $myoffer;
                }
            }

            $finalResult['myrequestes'] = $myrequestes;
            $finalResult['myoffers'] = $names;
        
            if ($myrequestes != '' || $names != '') {
                return view('trucks.myrequest', compact('user','finalResult'));
            }else{
                return view('trucks.myrequest', compact('user' , 'finalResult'));
            }
            
           
        } catch (\Exception $e) {
            return view('trucks.myrequest', compact('user'));
        }
    }


    public function approveRequestWeb(Request $request){
        $accessToken = Auth::user()->id;
        $user        = User::where('id', $accessToken)->first();
        $user_id     = $user->id;
        $bookingId   = $request->booking_id;
        $push = new PushNotification('fcm'); 

        try {
            $bookings = Booking::query();
            $bookings->where('id', $bookingId);
            $data = $bookings->get();
            if ($data->contains('requested_by', $user_id) || $data->contains('posted_by', $user_id) ){
              $bookings = Booking::findOrFail($bookingId);
              $bookings->update(['approved' => 2]);
                // Sent notification
                if ($data[0]['posted_by'] != $user_id) {
                    $reciver_id =  $data[0]['posted_by'];
                }
                if ($data[0]['requested_by'] != $user_id) {
                    $reciver_id = $data[0]['requested_by'];
                }
                $reciverInfo  = User::where('id', $reciver_id)->first();

                if (!empty($reciverInfo)) {
                    $title = 'Accepted request!!';
                    $datas = 'Accepted request Successfully';
                    $response = $push->setMessage(['body'=>$datas,'title'=>$title, 'click_action' => "FLUTTER_NOTIFICATION_CLICK"])
                                     ->setApiKey('AAAA8IlH1LM:APA91bEwEqR-qe_Oxk2_WF-QXZSi_0oGofBUgnUpaMm0V40k0t1_E1L5TP96SB-NnuG9zkt_WrBVDV_Fi-86NdsVftD9q8zDXT-o_r0hG9gt-OvMR2z1IbV2E5FBtBv77QbyG775Pty9')
                                     ->setDevicesToken([$reciverInfo['device_token']])
                                     ->send()
                                     ->getFeedback();
                    $request->request->add(['sender_id' => $user_id]);
                    $request->request->add(['receiver_id' => $reciverInfo['id']]);
                    $request->request->add(['title' => $title]);
                    $request->request->add(['data' => $datas]);
                    $array = json_decode(json_encode($response), true);
                    if ($array['success'] == 1) {
                        Notification::create($request->only('sender_id', 'receiver_id', 'title', 'data'));
                    }
                }
                // end notification

              return response()->json(['success' => true, 'myrequests'=> $bookings, 'message' => 'Request accepted Successfully'], 201);
            }else{
                return response()->json(['success' => false, 'message' => 'Request not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unable to accpeted, please try again.'], 404);
        } 
    }

    public function hiredRequestWeb(Request $request){
        $accessToken = Auth::user()->id;
        $user        = User::where('id', $accessToken)->first();
        $user_id     = $user->id;
        $bookingId   = $request->booking_id;
        $push = new PushNotification('fcm'); 

        try { 
            $bookings = Booking::query();
            $bookings->where('id', $bookingId);
            $data = $bookings->get();
            if ($data->contains('requested_by', $user_id) || $data->contains('posted_by', $user_id) ){
                $bookings = Booking::findOrFail($bookingId);
                $bookings->update(['approved' => 3]);
                // Sent notification
                if ($data[0]['posted_by'] != $user_id) {
                    $reciver_id =  $data[0]['posted_by'];
                }
                if ($data[0]['requested_by'] != $user_id) {
                    $reciver_id = $data[0]['requested_by'];
                }
                $reciverInfo  = User::where('id', $reciver_id)->first();

                if (!empty($reciverInfo)) {
                    $title = 'Hired';
                    $datas = 'Hire Successfully';
                    $response = $push->setMessage(['body'=>$datas,'title'=>$title, 'click_action' => "FLUTTER_NOTIFICATION_CLICK" ])
                                     ->setApiKey('AAAA8IlH1LM:APA91bEwEqR-qe_Oxk2_WF-QXZSi_0oGofBUgnUpaMm0V40k0t1_E1L5TP96SB-NnuG9zkt_WrBVDV_Fi-86NdsVftD9q8zDXT-o_r0hG9gt-OvMR2z1IbV2E5FBtBv77QbyG775Pty9')
                                     ->setDevicesToken([$reciverInfo['device_token']])
                                     ->send()
                                     ->getFeedback();
                    $request->request->add(['sender_id' => $user_id]);
                    $request->request->add(['receiver_id' => $reciverInfo['id']]);
                    $request->request->add(['title' => $title]);
                    $request->request->add(['data' => $datas]);
                    $array = json_decode(json_encode($response), true);
                    if ($array['success'] == 1) {
                        Notification::create($request->only('sender_id', 'receiver_id', 'title', 'data'));
                    }
                }
                // end notification
				if ($bookings['job_id'] != NULL ) {
					$job = Job::findOrFail($bookings['job_id']);
					$job->update(['status' => 0]);
				}else{
					$vehicle = Vehicle::findOrFail($bookings['vehicle_id']);
					$vehicle->update(['status' => 0]);
				}
				return response()->json(['success' => true, 'myrequests'=> $bookings, 'message' => 'Hire Successfully'], 201);
			}else{
				return response()->json(['success' => false, 'message' => 'Request not found'], 404);
			}
	
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => 'Unable to accpeted, please try again.'], 404);
		} 
	}

	public function discussion(Request $request,$id1,$id2,$request_id){ 
        $id 		= Auth::user()->id;
        $user 		= User::where('id', $id)->first();
        $user_id	= $user->id;
        $chatArray  = array();

        $requests = Booking::where('id', $request_id)->first();
        $requeststype = $requests->approved;

        $user1      = $id1;
        $user2      = $id2;

        if($user1 > $user2){
            $ids  = "$user1-$user2";
        }else{
            $ids  = "$user2-$user1";
        }

        if($user_id == $user1){
            $reciver_id  = $user2;
        }else{
            $reciver_id  = $user1;
        }

		try {
            $citiesRef = $this->db->collection('message');
            $query = $citiesRef->where('chatId', '=', "$ids");
            // $query = $citiesRef->where('chatId', '=', "$requested_by-$posted_by");

            $documents = $query->orderBy('date', 'ASC')->documents();

            foreach ($documents as $document) {
                if ($document->exists()) {
                    $chatArray[] = $document->data();
                } else {
                }
            }

            //return view('trucks.discussion', compact('user','chatArray' , 'user_id','id1','id2','user_id' , 'reciver_id'));
			return view('trucks.discussion', compact('user','chatArray' , 'user_id','id1','id2','user_id' , 'reciver_id' ,'request_id' , 'requeststype'));
		} catch (\Exception $e) {
            
		}	
	}

    public function discussionAjax($id1,$id2,$request_id){
        $id         = Auth::user()->id;
        $user       = User::where('id', $id)->first();
        $user_id    = $user->id;
        $chatArray  = array();

        $user1      = $id1;
        $user2      = $id2;

        if($user1 > $user2){
            $ids  = "$user1-$user2";
        }else{
            $ids  = "$user2-$user1";
        }

        try {
            $citiesRef = $this->db->collection('message');
            $query = $citiesRef->where('chatId', '=', "$ids");
            // $query = $citiesRef->where('chatId', '=', "$requested_by-$posted_by");

            $documents = $query->orderBy('date', 'ASC')->documents();

            foreach ($documents as $document) {
                if ($document->exists()) {
                    //printf('Document data for document %s:' . PHP_EOL, $document->id());
                    $chatArray[] = $document->data();
                    //printf(PHP_EOL);
                } else {
                    printf('Document %s does not exist!' . PHP_EOL, $document->id());
                }
            }

            $conversation = '<ul>';
            foreach($chatArray as $chat){
                if($user_id == $chat['reciverId']){
                    $conversation .='<li class="sent">
                            <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil">
                            <p>'.$chat['messsage'].'</p>
                      </li>';
                  }elseif ($user_id == $chat['senderId']) {
                    $conversation .='<li class="replies">
                      <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil">
                      <p>'.$chat['messsage'].'</p>
                    </li>';
                }
            }       
            $conversation .= '</ul>';

            return response()->json(['success' => true, 'chatArray'=> $conversation, 'message' => 'fetched Successfully'], 201);
        } catch (\Exception $e) {
            
        }   
    }

    public function sendMessage(Request $request){
        $id         = Auth::user()->id;
        $user       = User::where('id', $id)->first();
        $user_id    = $user->id;

        $user1      = $request->id1;
        $user2      = $request->id2;

        if($user1 > $user2){
            $ids  = "$user1-$user2";
        }else{
            $ids  = "$user2-$user1";
        }

        $data = [
            'chatId'    => $ids ,
            'image'     => '',
            'messsage'  => $request->message,
            'name'      => $request->sender_name,
            'reciverId' => $request->reciver_id,
            'senderId'  => $request->sender_id,
            'date'      => new Timestamp(new DateTime())
        ];

        
        try {

            $insertdata = $this->db->collection('message')->add($data);

            /*for sender start*/
            $refUser = $this->db->collection("user")->document($user_id);
            $refUser->set(['title' => 'appexload']);

            $refUser->collection("chatUsers")->document($request->reciver_id)->set([
                "chatId"    =>  $ids,
                "date"      =>  new Timestamp(new DateTime()),
                "image"     =>  '',
                "messsage"  =>  $request->message,
                "reciverId" =>  $request->reciver_id,
                "senderId"  =>  $request->sender_id,
                "name"      =>  $request->sender_name,
            ]);
            /*end*/

            /*for reciver start*/

            $refUser = $this->db->collection("user")->document($request->reciver_id);
            $refUser->set(['title' => 'appexload']);

            $refUser->collection("chatUsers")->document($user_id)->set([
                "chatId"    =>  $ids,
                "date"      =>  new Timestamp(new DateTime()),
                "image"     =>  '',
                "messsage"  =>  $request->message,
                "reciverId" =>  $request->reciver_id,
                "senderId"  =>  $request->sender_id,
                "name"      =>  $request->sender_name,
            ]);

            /*end*/
            return response()->json(['success' => true,'message' => 'fetched Successfully'], 201);
        } catch (Exception $e) {
            print_r($e);
        }  
    }
}
