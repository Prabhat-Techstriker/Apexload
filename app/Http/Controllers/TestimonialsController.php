<?php

namespace App\Http\Controllers;

use App\Testimonial;
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


class TestimonialsController extends Controller
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
        $testimonials = Testimonial::all();        
        return view('testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        return view('testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        if ($image = $request->file('user_image')) {
            $filenameWithExt = $image->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            $mimeType = $image->getClientMimeType();
            $fileNameToStore = str_replace(" ", "-", $filename) . '_' . time() . '.' . $extension;
            $path = $image->move(public_path().'/testimonialsUser/', $fileNameToStore);
        }
        $allRequest = $request->all();
        unset($allRequest['user_image']);
        if (!empty($path)) {
            $allRequest['user_image'] = $fileNameToStore;
        }
        $testimonial = Testimonial::create($allRequest);

        return redirect()->route('admin.testimonials.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function show(Testimonial $testimonial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $testimonial = Testimonial::find($id);
        return view('testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if ($image = $request->file('user_image')) {
            $filenameWithExt = $image->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            $mimeType = $image->getClientMimeType();
            $fileNameToStore = str_replace(" ", "-", $filename) . '_' . time() . '.' . $extension;
            $path = $image->move(public_path().'/testimonialsUser/', $fileNameToStore);
        }
        $allRequest = $request->all();
        unset($allRequest['user_image']);
        if (!empty($path)) {
            $allRequest['user_image'] = $fileNameToStore;
        }
        $testimonial = Testimonial::find($id);
        $testimonial->update($allRequest);

        return redirect()->route('admin.testimonials.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $testimonial = Testimonial::find($id);
        $testimonial->delete();
        return redirect()->route('admin.testimonials.index');
    }
}
