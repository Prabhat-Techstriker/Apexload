<?php

namespace App\Http\Controllers;

use App\LogoSlider;
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


class LogoSlidersController extends Controller
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
        $sliderlogo = LogoSlider::all();        
        return view('logosiders.index', compact('sliderlogo'));
        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        return view('logosiders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $this->validate($request, [
                'filenames' => 'required',
                'filenames.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if($request->hasfile('filenames')){
            foreach($request->file('filenames')  as $key  => $file){
                $name = time().$key.'.'.$file->extension();
                $file->move(public_path().'/brandlogos/', $name);  
                $data = $name;  
            }
        }
        $logos = new LogoSlider();
        $logos->filenames=$data;
        $logos->save();
        return back()->with('success', 'Your logo has been successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LogoSlider  $logoSlider
     * @return \Illuminate\Http\Response
     */
    public function show(LogoSlider $logoSlider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LogoSlider  $logoSlider
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $logo = LogoSlider::find($id);
        return view('logosiders.edit', compact('logo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LogoSlider  $logoSlider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $request->validate([
            'filenames' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if ($image = $request->file('filenames')) {
            $filenameWithExt = $image->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            $mimeType = $image->getClientMimeType();
            $fileNameToStore = str_replace(" ", "-", $filename) . '_' . time() . '.' . $extension;
            $path = $image->move(public_path().'/brandlogos/', $fileNameToStore);
        }
        $allRequest = $request->all();
        unset($allRequest['profile_image']);
        if (!empty($path)) {
            $allRequest['filenames'] = $fileNameToStore;
        }
        $LogoSlider = LogoSlider::find($id);
        $LogoSlider->update($allRequest);

        return redirect()->route('admin.logoslider');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LogoSlider  $logoSlider
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $LogoSlider = LogoSlider::find($id);
        $LogoSlider->delete();
        return redirect()->route('admin.logoslider');
    }
}
