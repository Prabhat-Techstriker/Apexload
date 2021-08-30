<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Twilio\Rest\Client;
use App\User;
use App\Notifications\SignupActivate;
use Illuminate\Support\Str;
use App\Notifications\ForgetPasswordRequest;
use App\Responsibility;
use App\AccountType;
use DB;
use App\Equipment;
use App\Job;
use App\Vehicle;
use App\VehicleBrand;
class DashboardController extends Controller
{
	public function postLoad(Request $request)
	{
		$id = Auth::user()->id;
		$user = User::where('id', $id)->first();
		$equipments = Equipment::get();
        $postloads = Job::where('posted_by',$id)->get();

		return view('shippers.post-load', compact('user','equipments'));
	}

	public function jobPost(Request $request){
		
        $equipment = implode(', ', $request['equipment']);
        unset($request['equipment']);

        $request['equipment'] = $equipment;

        $user = User::where('id', Auth::user()->id)->first();
        $request->request->add(['posted_by' => $user->id]);
        $validator = Validator::make($request->all(), [
            'posted_by'        => 'required',
            'orign_name'       => 'required',
            'orign_lat'        => 'required',
            'orign_long'       => 'required',
            'destination_name' => 'required',
            'destination_lat'  => 'required',
            'destination_long' => 'required',
            //'miles'            => 'required',
            'pickup_date'      => 'required',
            'equipment'        => 'required',
            /*'load'             => 'required',
            'weight'           => 'required',
            'lenght'           => 'required',
            'hieght'           => 'required',
            'width'            => 'required',
            'pieces'           => 'required',
            'quantity'         => 'required'*/
        ]);

        unset($request['miles']);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors(), 'message' => 'Validation failed'], 422);
        }
        try {
            $mile = distance($request->orign_name, $request->destination_name, $unit = "K");
           
            $request->request->add(['miles' => $mile]);
            $jobPost = Job::create($request->all());
            $jobPost->eqp_types()->attach(explode(",", $request['equipment']));

            return response()->json(['success' => true, 'jobpost'=> $jobPost, 'message' => 'Job added Successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unable to added, please try again.'], 404);
        }
    }

    public function jobPostList(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $postloads = Job::where('posted_by',$id)->get();
      
        return view('shippers.post-load-list', compact('user','postloads' ));
    }

    public function postloadedit($postid)
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $postloads = Job::where('id',$postid)->first();
        $postloads->equipment = explode(",",$postloads->equipment);
        $equipments = Equipment::get();
        return view('shippers.post-load-edit', compact('user','postloads','equipments'));
    }

    public function editjobPost(Request $request){

        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $request->request->add(['posted_by' => $user->id]);
        $validator = Validator::make($request->all(), [
            'posted_by'        => 'required',
            'orign_name'       => 'required',
            'orign_lat'        => 'required',
            'orign_long'       => 'required',
            'destination_name' => 'required',
            'destination_lat'  => 'required',
            'destination_long' => 'required',
            'pickup_date'      => 'required',
            /*'equipment'        => 'required',
            'miles'            => 'required',
            'load'             => 'required',
            'weight'           => 'required',
            'lenght'           => 'required',
            'hieght'           => 'required',
            'width'            => 'required',
            'pieces'           => 'required',
            'quantity'         => 'required'*/
        ]);

        $equipment = implode(', ', $request['equipment']);
        unset($request['equipment']);
        $request['equipment'] = $equipment;

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors(), 'message' => 'Validation failed'], 422);
        }
        try {
            $jobPost = Job::where('id', '=', $request->post_id)->first();
            
            if (!empty($jobPost)) {
                $mile = distance($request->orign_name, $request->destination_name, $unit = "K");

                $request->request->add(['miles' => $mile]);

                $jobPost->update($request->all());
            }else{

                return response()->json(['success' => false, 'message' => 'Unable to upadte, please try again.'], 404);
            }

            return response()->json(['success' => true, 'jobpost'=> $jobPost, 'message' => 'Post Load added Successfully'], 201);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'message' => 'Unable to upadte, please try again.'], 404);
        }
    }

    public function vehiclePost()
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $equipments = Equipment::get();
        $VehicleBrand = VehicleBrand::get();
        return view('trucks.vehicle-post', compact('user','equipments','VehicleBrand'));
    } 


    public function vehicleList()
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $truckDetails = Vehicle::where(['posted_by' => $user->id])->orderBy('id','asc')->get();

        return view('trucks.vehicle-list', compact('truckDetails','user')); 
    }

    public function vehiclePostAdd(Request $request){
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $request->request->add(['posted_by' => $user->id]);
        $validator = Validator::make($request->all(), [
            'posted_by'             => 'required',
            'miles'                 => 'required',
            'available_date_from'   => 'required',
            'equipment'             => 'required',
            'load_size'             => 'required',
            'lenght'                => 'required',
            'hieght'                => 'required',
            'width'                 => 'required'
            /*'vehicle_brand'       => 'required',
            'orign_name'            => 'required',
            'orign_lat'             => 'required',
            'orign_long'            => 'required',
            'destination_name'      => 'required',
            'destination_lat'       => 'required',
            'destination_long'      => 'required',
            'available_date_to'     => 'required'*/            
        ]);


        $equipment = implode(', ', $request['equipment']);
        unset($request['equipment']);
        $request['equipment'] = $equipment;

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors(), 'message' => 'Validation failed'], 422);
        }
        try {
            $mile = distance($request->orign_name, $request->destination_name, $unit = "K");
            $mileparam = str_replace(" km","",$mile);
           
            $request->request->add(['miles' => $mileparam]);
            $vehiclepost = Vehicle::create($request->all());

            $vehiclepost->eqp_types()->attach(explode(",", $request['equipment']));

            return response()->json(['success' => true, 'vehiclepost'=> $vehiclepost, 'message' => 'Vehicle added Successfully'], 201);
        } catch (\Exception $e) {
            print_r($e);
            return response()->json(['success' => false, 'message' => 'Unable to added, please try again.'], 404);
        }
    }

     public function vehicleEdit($pid){
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $vehiclePost = Vehicle::where('id',$pid)->first();
        $vehiclePost->equipment = explode(",",$vehiclePost->equipment);
        $equipments = Equipment::get();
        $VehicleBrand = VehicleBrand::get();
        return view('trucks.vehicle-edit', compact('user','vehiclePost','equipments','VehicleBrand'));
     }

    public function vehiclePostEdit(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $request->request->add(['posted_by' => $user->id]);
        $validator = Validator::make($request->all(), [
            'posted_by'        => 'required',
            /*'destination_name' => 'required',
            'destination_lat'  => 'required',
            'destination_long' => 'required',*/
            //'miles'            => 'required',
            'available_date_from'   => 'required',
            // 'available_date_to'   => 'required',
            'equipment'        => 'required',
            'load_size'        => 'required',
            'lenght'           => 'required',
            'hieght'           => 'required',
            'width'            => 'required'
            /*'vehicle_brand'    => 'required',*/
            /*'vehicle_number'   => 'required',
            'description'      => 'required'*/
            /*'set_price'        => 'required'*/
        ]);

        $equipment = implode(',', $request['equipment']);
        unset($request['equipment']);
        $request['equipment'] = $equipment;

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors(), 'message' => 'Validation failed'], 422);
        }
        try {
            $vehiclepost = Vehicle::where('id', '=', $request->post_id)->first();


            if (!empty($vehiclepost)) {

                $mile = distance($request->orign_name, $request->destination_name, $unit = "K");
                $mileparam = str_replace(" km","",$mile);
           
                $request->request->add(['miles' => $mileparam]);

                $vehiclepost->update($request->all());
            }else{
                return response()->json(['success' => false, 'message' => 'Unable to upadte, please try again.'], 404);
            }
            
            return response()->json(['success' => true, 'vehiclepost'=> $vehiclepost, 'message' => 'Vehicle updated Successfully'], 201);
        } catch (\Exception $e) {
print_r($e);die;
            return response()->json(['success' => false, 'message' => 'Unable to upadte, please try again.'], 404);
        }
    }


    public function setting(Request $request){
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        return view('trucks.settings', compact('user'));
    }

    public function prefrences(Request $request){
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $equipments = Equipment::get();
        return view('trucks.prefrences', compact('user','equipments'));
    }

    public function myprofile(Request $request){
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $equipments = Equipment::get();
        return view('trucks.myprofile', compact('user','equipments'));
    }


    public function updatemyprofile(Request $request){
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
                //'email'        => 'required|string|email|unique:users',
                //'device_token' => 'required|string|unique:users',
                //'password'     => 'required|string'
            'first_name'     => 'required|string',
            'last_name'     => 'required|string',
            'phone_number'     => 'required|string'
            ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors(), 'message' => 'Validation failed'], 422);
        }

        try {
            $image = $request->file('user_image');
            if (!empty($image)) {
                $filenameWithExt = $image->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $getName = $image->getClientOriginalName();
                $mimeType = $image->getClientMimeType();
                $fileNameToStore = str_replace(" ", "-", $filename) . '_' . time() . '.' . $extension;
                $path = $image->storeAs('profile', $fileNameToStore);
                $request->request->add(['profile_image' => $path]);
            }
            $user->fill($request->all());
            $user->save();
            //session()->flash('status', 'Profile updated successfully updated');
            return redirect('/web/myprofile')->with('success', 'Profile updated successfully updated');
            //return view('trucks.myprofile', compact('user'));
        } catch (Exception $e) {
            
        }
    }
}
