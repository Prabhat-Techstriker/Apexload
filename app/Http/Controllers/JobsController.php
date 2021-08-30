<?php

namespace App\Http\Controllers;

use App\Job;
use App\User;
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

class JobsController extends Controller
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
        $jobs = Job::all();
        foreach ($jobs as $key => $job) {
            $created_by = getCreatedBy($job['posted_by']);
            $job[$key] = $job;
            $job['poste_by'] = $created_by;
        }
        return view('jobs.index', compact('jobs'));
        
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
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $jobDetails = Job::find($id);
        $created_by = getCreatedBy($jobDetails['posted_by']);
        return view('jobs.show', compact('jobDetails','created_by')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id,Job $job)
    {
        try {
            $jobPost = Job::where('id',$id)->delete();

            return response()->json(['success' => true, 'message' => 'Job deleted Successfully'], 201);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'message' => 'Unable to added, please try again.'], 404);
        }
    }

    //Apis
    public function jobPost(Request $request){
        $accessToken = Auth::user()->token();
        $user = User::where('id', $accessToken->user_id)->first();
        $request->request->add(['posted_by' => $user->id]);
        $validator = Validator::make($request->all(), [
            'posted_by'        => 'required',
            'orign_name'       => 'required',
            'orign_lat'        => 'required',
            'orign_long'       => 'required',
            'destination_name' => 'required',
            'destination_lat'  => 'required',
            'destination_long' => 'required',
            'miles'            => 'required',
            'pickup_date'      => 'required',
            'equipment'        => 'required',
            'delivery_date'    => 'required',
            /*'load'             => 'required',
            'weight'           => 'required',
            'hieght'           => 'required',
            'width'            => 'required',
            'lenght'           => 'required',            
            'pieces'           => 'required',
            'quantity'         => 'required'*/
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors(), 'message' => 'Validation failed'], 422);
        }
        try {
            $jobPost = Job::create($request->all());
            $jobPost->eqp_types()->attach(explode(",", $request['equipment']));

            return response()->json(['success' => true, 'jobpost'=> $jobPost, 'message' => 'Job added Successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unable to added, please try again.'], 404);
        }
    }

    public function editjobPost(Request $request){
        $accessToken = Auth::user()->token();
        $user = User::where('id', $accessToken->user_id)->first();
        $request->request->add(['posted_by' => $user->id]);
        $validator = Validator::make($request->all(), [
            'posted_by'        => 'required',
            'orign_name'       => 'required',
            'orign_lat'        => 'required',
            'orign_long'       => 'required',
            'destination_name' => 'required',
            'destination_lat'  => 'required',
            'destination_long' => 'required',
            'miles'            => 'required',
            'pickup_date'      => 'required',
            'delivery_date'    => 'required',
            /*'equipment'        => 'required',
            'load'             => 'required',
            'weight'           => 'required',
            'lenght'           => 'required',
            'hieght'           => 'required',
            'width'            => 'required',
            'pieces'           => 'required',
            'quantity'         => 'required'*/
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors(), 'message' => 'Validation failed'], 422);
        }
        try {
            $jobPost = Job::where('id', '=', $request->id)->first();
            if (!empty($jobPost)) {
                $jobPost->update($request->all());
            }else{
                return response()->json(['success' => false, 'message' => 'Unable to upadte, please try again.'], 404);
            }

            return response()->json(['success' => true, 'jobpost'=> $jobPost, 'message' => 'Post Load added Successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unable to upadte, please try again.'], 404);
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

    public function getNearbyLocationJobsPost(Request $request){
        $accessToken = Auth::user()->token();
        $user = User::where('id', $accessToken->user_id)->first();
        $latitude  =  $request->latitude;
        $longitude =  $request->longitude;
        try {
            $datas = DB::table('jobs')->select('*', DB::raw(sprintf(
            '(6371 * acos(cos(radians(%1$.7f)) * cos(radians(orign_lat)) * cos(radians(orign_long) - radians(%2$.7f)) + sin(radians(%1$.7f)) * sin(radians(orign_lat)))) AS distance',
            $request->input('latitude'),
            $request->input('longitude')
            )))
            ->where('status','=',1)
            ->having('distance', '<', 20)
            ->orderBy('distance', 'asc')
            ->limit(10)->get();
            $equipments = $this->equipmentdata($datas);
            if (sizeof($equipments) > 0) {
               return response()->json(['success' => true, 'jobpostlist'=> $equipments, 'message' => 'Post Load fetched Successfully'], 201);
            }else{
                return response()->json(['success' => false,  'message' => 'Post Load not found '], 404);
            }
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unable to fetched, please try again.'], 404);
        }
    }

    public function equipmentIds($jobPosts) {
        $names = [];
        foreach ($jobPosts as $key => $jobPost) {
            $ids = explode(",", $jobPost->equipment);
            $jobPost['eqp_types'] = Equipment::select('type')->whereIn('id', $ids)->get();
            $names[$key] = $jobPost;
        }
        return $names;
    }

    public function getJobsPostlist(Request $request){
        $accessToken = Auth::user()->token();
        $user = User::where('id', $accessToken->user_id)->first();
        try {
            $jobPost = Job::where('status','=',1)->where('posted_by','=', $user->id)->get();
            $equipments = $this->equipmentIds($jobPost);
            if (sizeof($jobPost) > 0) {
                return response()->json(['success' => true, 'jobpostlist'=> $equipments, 'message' => 'Post Load fetched Successfully'], 201);
            }else{
                return response()->json(['success' => false,  'message' => 'Post load not found.'], 404);
            }
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unable to fetched, please try again.'], 404);
        }
    }

    public function searchPostLoads(Request $request) {
        $accessToken = Auth::user()->token();
        $user = User::where('id', $accessToken->user_id)->first();

        try {
            $items = $request->all();
            $request->request->add(['user_id' => $user->id]);
            $request->request->remove('equipment');

            $allPosts = Job::query();
            $allPosts->where('status', 1);

            /* if(!empty($items['orign_lat'])) {
                $allPosts->where('orign_lat','=',round($items['orign_lat'],7));
            }

            if(!empty($items['orign_long'])){
                $allPosts->where('orign_long','=',round($items['orign_long'],7));
            }

            if(!empty($items['destination_lat'])){
                $allPosts->where('destination_lat','=',round($items['destination_lat'],7));
            }

            if(!empty($items['destination_long'])){
                $allPosts->where('destination_long','=',round($items['destination_long'],7));
            }

            if(!empty($items['miles'])){
                $allPosts->where('miles','=',$items['miles']);
            }*/

            if(!empty($items['available_date']) && ($items['available_date'] != "Any")) {
                $allPosts->where('pickup_date', '=', $items['available_date']);
            }

            // if(count($items['equipment']) > 0 ) {
            if($items['equipment']) {
                $ar = explode(",",$items['equipment']);
                
                $allPosts->with(array('eqp_types' => function($query) use($items,$ar) {
                    $query->select('equipments.type');
                    $query->whereIN('equipments.id', $ar);
                }))
                ->whereHas('eqp_types', function($q) use($items,$ar) {
                    $q->whereIn('equipments.id', $ar);
                });
            } else {
                $allPosts
                ->with(array('eqp_types' => function($query) {
                    $query->select('equipments.type');
                }));
            }

            $data = $allPosts->selectRaw('*, ( 6371 * acos( cos( radians( ? ) ) * cos( radians( orign_lat ) ) * cos( radians( orign_long ) - radians( ? ) ) + sin( radians( ? ) ) * sin( radians( orign_lat ) ) ) ) AS distance', [$items['orign_lat'], $items['orign_long'] ,$items['orign_lat']])
            ->having('distance', '<', $request->search_radius)
            //->having('distance', '<', 10)
            ->get();

            $finalArray = array();

            foreach ($data as $key => $value) {
                // $distance = $this->distance($items['orign_lat'],$items['orign_long'],$value->orign_lat,$value->orign_long,"K");
                unset($value['distance']);
                $value->distance = $this->distance($items['orign_name'],$value['orign_name'],"K");
                $finalArray[] = $value;
            }

            if (sizeof($data) > 0) {
                Search::create($request->all());

                Search::where('user_id', $user->id)
                                ->where('orign_name','=', $items['orign_name'])
                                ->where('destination_name','=', $items['destination_name'])
                ->update(['search_radius' => $items['search_radius']]);
                return response()->json(['success' => true, 'jobpostlist' => $finalArray, 'message' => 'Post Loads fetched Successfully'], 201);
            }else{
                return response()->json(['success' => false,  'message' => 'Post load not found.'], 404);
            }
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unable to fetched, please try again.'], 404);
        }
    }

    function distance($lat1, $lon1, $unit = "K") {

        $URL = 'https://maps.googleapis.com/maps/api/directions/json?origin='.str_replace(' ', '+', $lat1).'&destination='.str_replace(' ', '+', $lon1).'&key=AIzaSyCEoZn5xObT7Pt051ckM9xDbt2MGVzZXr4';
        // $URL = 'https://maps.googleapis.com/maps/api/directions/json?origin=Garhi+Malook+No-1,+Keshav Nagar,+Saharanpur,+Uttar+Pradesh&destination=Delhi+Airport,+New+Delhi,+Delhi&key=AIzaSyCEoZn5xObT7Pt051ckM9xDbt2MGVzZXr4';

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
