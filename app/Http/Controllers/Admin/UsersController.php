<?php

namespace App\Http\Controllers\Admin;

use App\User;
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

class UsersController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $roles = Role::get()->pluck('name', 'name');

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsersRequest $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $user = User::create($request->all());
        $roles = $request->input('roles') ? $request->input('roles') : [];
        $user->assignRole($roles);

        return redirect()->route('admin.users.index');
    }


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $roles = Role::get()->pluck('name', 'name');

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUsersRequest $request, User $user)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $user->update($request->all());
        $roles = $request->input('roles') ? $request->input('roles') : [];
        $user->syncRoles($roles);

        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $user->load('roles');

        return view('admin.users.show', compact('user'));
    }

    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $user->delete();

        return redirect()->route('admin.users.index');
    }

    /**
     * Delete all selected User at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        User::whereIn('id', request('ids'))->delete();

        return response()->noContent();
    }

   //shipers

    public function shippers()
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $shippers = User::where('responsibilty_type', 1)->get();

        return view('shippers.index', compact('shippers'));
    }

    public function shippersShow($id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $shipper = User::find($id);
        return view('shippers.show', compact('shipper'));
    }

    public function shipperEdit($id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $user = User::find($id);

        return view('shippers.edit', compact('user'));
    }

    public function shipperUpdate(Request $request, $id)
    {
        
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $request->validate([
            'first_name'=>'required',
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if ($image = $request->file('profile_image')) {
            $filenameWithExt = $image->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            $mimeType = $image->getClientMimeType();
            $fileNameToStore = str_replace(" ", "-", $filename) . '_' . time() . '.' . $extension;
            $path = $image->storeAs('profile', $fileNameToStore);
        }
        $allRequest = $request->all();
        unset($allRequest['profile_image']);
        if (!empty($path)) {
            $allRequest['profile_image'] = $path;
        }
        $contact = User::find($id);
        $contact->update($allRequest);
        return redirect()->route('admin.shippers');

    }

    public function shipperDestroy(Request $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $accountType = User::find($request->id);
        $accountType->delete();
        if($accountType){
            echo 1;
        }else{
            echo 0;
        }
    }
    
    //drivers
    public function drivers()
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $drivers = User::where('responsibilty_type', 2)->get();
        foreach ($drivers as $key => $driver) {
            $created_by = getCreatedBy($driver['created_by']);
            $driver[$key] = $driver;
            $driver['driverBy'] = $created_by;

        }


        return view('drivers.index', compact('drivers'));
    }

    public function driverShow($id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $driver = User::find($id);

        return view('drivers.show', compact('driver'));
    }

    public function driverEdit(Request $request, $id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $user = User::find($id);

        return view('drivers.edit', compact('user'));
    }

    public function driverUpdate(Request $request, $id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $request->validate([
            'first_name'=>'required',
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if ($image = $request->file('profile_image')) {
            $filenameWithExt = $image->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            $mimeType = $image->getClientMimeType();
            $fileNameToStore = str_replace(" ", "-", $filename) . '_' . time() . '.' . $extension;
            $path = $image->storeAs('profile', $fileNameToStore);
        }
        $allRequest = $request->all();
        unset($allRequest['profile_image']);
        if (!empty($path)) {
            $allRequest['profile_image'] = $path;
        }
        $contact = User::find($id);
        $contact->update($allRequest);
        return redirect()->route('admin.drivers');

    }

    public function driverDestroy(Request $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $accountType = User::find($request->id);
        $accountType->delete();
        if($accountType){
            echo 1;
        }else{
            echo 0;
        }
    }

    //website profile
    public function webUpdateProfile(Request $request){
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
                'email'        => 'email|unique:users',
                'phone_number' => 'string|unique:users'
                
            ]);
        if ($validator->fails()) {
            return  back()->with('error','Email and phone number is already taken');
        }

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
        session()->flash('status', 'Profile created successfully updated');
        return redirect()->route('web.user-dashboard');
        
    }

    //Apis

    public function updateProfile(Request $request){
        $accessToken = Auth::user()->token();
        $user = User::where('id', $accessToken->user_id)->first();
        try {
            if ($image = $request->file('user_image')) {
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
            return response()->json(['success' => true, 'user_detail'=> $user, 'message' => 'User update Successfully.'], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }
    }
   
    public function getProfile(Request $request){
        $accessToken = Auth::user()->token();
        $user = User::where('id', $accessToken->user_id)->first();
        try {
            return response()->json(['success' => true, 'user_detail'=> $user, 'message' => 'Succeffully fetched my profile data.'], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }
    }

    public function saveSetting(Request $request){
        $accessToken = Auth::user()->token();
        $user = User::where('id', $accessToken->user_id)->first();
        print_r($user);
        exit();
        try {
            $user->fill($request->all());
            $user->save();
            return response()->json(['success' => true, 'user_setting'=> $user, 'message' => 'User setting save Successfully.'], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

    }

    public function saveOriginDestination(Request $request){

        $accessToken = Auth::user()->token();
        $user = User::where('id', $accessToken->user_id)->first();

        try {
            $equipment = implode(",", $request['equipments']);
            $request->request->add(['equipment' => $equipment]);
            $request->request->remove('equipments');
            $user->fill($request->all());
            $user->save();
            return response()->json(['success' => true, 'origin_destination'=> $user, 'message' => 'User origin and destination save Successfully.'], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }
    }

    public function getPreferredlocation(Request $request){
        $accessToken = Auth::user()->token();

        try {
            $user = User::select('id','preferred_origin','preferred_origin_lat','preferred_origin_long','preferred_destination','preferred_destination_lat','preferred_destination_long','equipment')->where('id', $accessToken->user_id)->first();
           
            return response()->json(['success' => true, 'preferred_location'=> $user, 'message' => 'Preferred location fetched Successfully.'], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }
    }

    public function addPeople(Request $request){
        $accessToken = Auth::user()->token();
        $user = User::where('id', $accessToken->user_id)->first();

        $validator = Validator::make($request->all(), [
            'first_name'         => 'required',
            'last_name'          => 'required',
            'email'              => 'required|email|unique:users',
            'phone_number'       => 'required|unique:users',
            'responsibilty_type' => 'required',
            'account_type'       => 'required'
            
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors(), 'message' => 'Validation failed'], 422);
        }
        try {

            $request->request->add(['created_by' => $user->id]);
            $data = User::create($request->all());
            return response()->json(['success' => true, 'data'=> $data, 'message' => 'Added people Successfully.'], 201);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }
    }

    public function saveOriginDestinationWeb(Request $request){
        $accessToken = Auth::user()->id;
        $user = User::where('id', $accessToken)->first();

        try {
            $equipment = implode(",", $request['equipments']);
            $request->request->add(['equipment' => $equipment]);
            $request->request->remove('equipments');
            
            $user->fill($request->all());
            $user->save();
            return response()->json(['success' => true, 'origin_destination'=> $user, 'message' => 'User origin and destination save Successfully.'], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }
    }
}