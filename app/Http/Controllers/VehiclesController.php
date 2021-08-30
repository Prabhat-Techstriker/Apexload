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


class VehiclesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $allTrucks = Vehicle::all();
        $newTrucks = [];
        foreach ($allTrucks as $key => $altrucks) {
            $newTrucks[$key] = $altrucks;
            $newTrucks[$key]['poste_by'] = getCreatedBy($altrucks['posted_by']);
        }
        return view('trucks.index', compact('newTrucks'));
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
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $truckDetails = Vehicle::find($id);
        $created_by = getCreatedBy($truckDetails['posted_by']);
        return view('trucks.show', compact('truckDetails','created_by')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehicle $vehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id,Vehicle $Vehicle)
    {
        try {
            $jobPost = Vehicle::where('id',$id)->delete();

            return response()->json(['success' => true, 'message' => 'Vehicle deleted Successfully'], 201);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'message' => 'Unable to added, please try again.'], 404);
        }
        
    }

     //Apis

     public function vehiclePost(Request $request){
        $accessToken = Auth::user()->token();
        $user = User::where('id', $accessToken->user_id)->first();
        $request->request->add(['posted_by' => $user->id]);
        $validator = Validator::make($request->all(), [
            'posted_by'             => 'required',
            'miles'                 => 'required',
            'available_date_from'   => 'required',
            'available_date_to'     => 'required',
            /*'orign_name'          => 'required',
            'orign_lat'             => 'required',
            'orign_long'            => 'required',
            'destination_name'      => 'required',
            'destination_lat'       => 'required',
            'destination_long'      => 'required',
            'equipment'           => 'required',
            'load_size'             => 'required',
            'lenght'                => 'required',
            'hieght'                => 'required',
            'width'                 => 'required'
            'vehicle_brand'         => 'required'*/
            
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors(), 'message' => 'Validation failed'], 422);
        }
        try {
            $vehiclepost = Vehicle::create($request->all());

            $vehiclepost->eqp_types()->attach(explode(",", $request['equipment']));

            return response()->json(['success' => true, 'vehiclepost'=> $vehiclepost, 'message' => 'Vehicle added Successfully'], 201);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'message' => 'Unable to added, please try again.'], 404);
        }
    }

    public function vehicleEditPost(Request $request){
        $accessToken = Auth::user()->token();
        $user = User::where('id', $accessToken->user_id)->first();
        $request->request->add(['posted_by' => $user->id]);
        $validator = Validator::make($request->all(), [
            'posted_by'             => 'required',
            'miles'                 => 'required',
            'available_date_from'   => 'required',
            'available_date_to'     => 'required',
            /*'destination_name'    => 'required',
            'destination_lat'       => 'required',
            'destination_long'      => 'required',
            'equipment'             => 'required',
            'load_size'             => 'required',
            'lenght'                => 'required',
            'hieght'                => 'required',
            'width'                 => 'required'
            'vehicle_brand'         => 'required',
            'vehicle_number'        => 'required',
            'description'           => 'required'
            'set_price'             => 'required'*/
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors(), 'message' => 'Validation failed'], 422);
        }
        try {
            $vehiclepost = Vehicle::where('id', '=', $request->id)->first();

            if (!empty($vehiclepost)) {
                $vehiclepost->update($request->all());
            }else{
                return response()->json(['success' => false, 'message' => 'Unable to upadte, please try again.'], 404);
            }
            
            return response()->json(['success' => true, 'vehiclepost'=> $vehiclepost, 'message' => 'Vehicle updated Successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unable to upadte, please try again.'], 404);
        }
    }

    public function getInfoVehicleBand($data) {
        $names = [];
        foreach ($data as $key => $brand) {
            $brand = json_decode(json_encode($brand), true);
            $truckspost = VehicleBrand::select('brand_name')->where('id', '=', $brand['vehicle_brand'])->get();
            $brand['brand_name'] = "MAN";
            $names[$key] = $brand;
        }
        foreach ($names as $key => $jobPost) {
            $ids = explode(",", $jobPost['equipment']);
            $jobPost['eqp_types'] = Equipment::select('type')->whereIn('id', $ids)->get();
            $names[$key] = $jobPost;
        }
        return $names;
    }


    public function getNearbyVehiclePost(Request $request){
        $accessToken = Auth::user()->token();
        $user = User::where('id', $accessToken->user_id)->first();
        $latitude  =  $request->latitude;
        $longitude =  $request->longitude;

        try {
            $data = DB::table('vehicles')->select('*', DB::raw(sprintf(
            '(6371 * acos(cos(radians(%1$.7f)) * cos(radians(orign_lat)) * cos(radians(orign_long) - radians(%2$.7f)) + sin(radians(%1$.7f)) * sin(radians(orign_lat)))) AS distance',
            $request->input('latitude'),
            $request->input('longitude')
            )))
            ->where('status','=',1)
            ->having('distance', '<', 20)
            ->orderBy('distance', 'asc')
            ->limit(10)->get();
           $data = $this->getInfoVehicleBand($data);

            if (sizeof($data) > 0) {
                return response()->json(['success' => true, 'truckspostlist'=> $data, 'message' => 'Vehicles fetched Successfully'], 201);
            }else{
                return response()->json(['success' => false,  'message' => 'Vehicles not found '], 404);
            }
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unable to fetched, please try again.'], 404);
        }
    }

    public function brands($trucksposts) {
        $names = [];
        foreach ($trucksposts as $key => $brandadd) {
            //$truckspost = VehicleBrand::select('brand_name')->where('id', '=', $brandadd->vehicle_brand)->get();
            $brandadd['brand_name'] = 'N.A';
            $names[$key] = $brandadd;
        }

        foreach ($names as $key => $jobPost) {
            $ids = explode(",", $jobPost->equipment);
            $jobPost['eqp_types'] = Equipment::select('type')->whereIn('id', $ids)->get();
            $names[$key] = $jobPost;
        }

        return $names;
    }

    public function getallTruckslist(Request $request){
        $accessToken = Auth::user()->token();
        $user = User::where('id', $accessToken->user_id)->first();
        try {
            $trucksposts = Vehicle::where('status','=',1)->where('posted_by','=', $user->id)->get();

            $brand = $this->brands($trucksposts);
            
            if (sizeof($trucksposts) > 0) {
                return response()->json(['success' => true, 'truckspostlist'=> $brand, 'message' => 'Truck post fetched Successfully'], 201);
            }else{
                return response()->json(['success' => false,  'message' => 'Truck post not found '], 404);
            }

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unable to fetched, please try again.'], 404);
        }
    }

    public function searchTrucks(Request $request) {
        $accessToken = Auth::user()->token();
        $user = User::where('id', $accessToken->user_id)->first();

        try {

            $items = $request->all();
            $request->request->add(['user_id' => $user->id]);
            $request->request->remove('equipment');

            $allVehicles = Vehicle::query();
            $allVehicles->where('status', 1);

            /* if(!empty($items['orign_lat'])) {
                $allVehicles->where('orign_lat','=', round($items['orign_lat'],7));
            }

            if(!empty($items['orign_long'])){
                $allVehicles->where('orign_long','=',round($items['orign_long'],7));
            }

            if(!empty($items['destination_lat'])){
                $allVehicles->where('destination_lat','=',round($items['destination_lat'],7));
            }

            if(!empty($items['destination_long'])){
                $allVehicles->where('destination_long','=',round($items['destination_long'],7));
            }

            if(!empty($items['miles'])){
                $allVehicles->where('miles','=',$items['miles']);
            }*/
            

            if(!empty($items['available_date']) && ($items['available_date'] != "Any")) {
                //$allVehicles->where('available_date_from', '=', $items['available_date']);
                //$dates = $allVehicles->get();
               	$allVehicles
               	 ->where('available_date_from', '<=', $items['available_date'])
               	 ->where('available_date_to', '>=', $items['available_date']);
            }

            // if(count($items['equipment']) > 0 ) {
            if($items['equipment']) {
                $allVehicles
                ->with(array('eqp_types' => function($query) use($items) {
                    $query->select('equipments.type');
                    $query->whereIN('equipments.id', $items['equipment']);
                }))
                ->whereHas('eqp_types', function($q) use($items) {
                    $q->whereIn('equipments.id', $items['equipment']);
                });
            } else {
                $allVehicles
                ->with(array('eqp_types' => function($query) {
                    $query->select('equipments.type');
                }));
            }

             // $data = $allVehicles->get();  
            $data = $allVehicles->selectRaw('*, ( 6371 * acos( cos( radians( ? ) ) * cos( radians( orign_lat ) ) * cos( radians( orign_long ) - radians( ? ) ) + sin( radians( ? ) ) * sin( radians( orign_lat ) ) ) ) AS distance', [$items['orign_lat'], $items['orign_long'] ,$items['orign_lat']])
            ->having('distance', '<', $request->search_radius)
            //->having('distance', '<', 10)
            ->get();

            /*$finalArray = array();

            foreach ($data as $key => $value) {
                $distance = $this->distance($items['orign_lat'],$items['orign_long'],$value->orign_lat,$value->orign_long,"K");
                $finalArray = $value;
            }*/

            $names = [];
            foreach ($data as $key => $brandadd) {
                //$truckspost = VehicleBrand::select('brand_name')->where('id', '=', $brandadd->vehicle_brand)->get();
                // $distance = $this->distance($items['orign_lat'],$items['orign_long'],$brandadd->orign_lat,$brandadd->orign_long,"K");
                $distance = $this->distance($items['orign_name'],$brandadd['orign_name'],"K");
                //$brandadd['brand_name'] = $truckspost[0]['brand_name'];
                $brandadd['brand_name'] = "N.A";
                $names[$key]            = $brandadd;
            }
            
            if (sizeof($names) > 0) {
                Search::create($request->all());
                return response()->json(['success' => true, 'truckspostlist' => $names, 'message' => 'Truck post fetched Successfully'], 201);
            }else{
                return response()->json(['success' => false,  'message' => 'Truck post not found.'], 404);
            }

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unable to fetched, please try again.'], 404);
        }
    }

    function distance($lat1, $lon1, $unit = "K") {

        /*$theta = $lon1 - $lon2;
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
        }*/
        $URL = 'https://maps.googleapis.com/maps/api/directions/json?origin='.str_replace(' ', '+', $lat1).'&destination='.str_replace(' ', '+', $lon1).'&key=AIzaSyCEoZn5xObT7Pt051ckM9xDbt2MGVzZXr4';

        $crl = curl_init();

        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);
     
        curl_setopt($crl, CURLOPT_URL, $URL);
        //curl_setopt($crl, CURLOPT_HTTPHEADER, $headr);
     
        curl_setopt($crl, CURLOPT_POST, 0);
        //curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
     
        $rest = curl_exec($crl);

        $result = json_decode($rest);

        //$result = str_replace(' km', '', $result->routes[0]->legs[0]->distance->text);
        $result = $result->routes[0]->legs[0]->distance->text;

        return $result;
    }
}
