<?php

namespace App\Http\Controllers;

use App\VehicleBrand;
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

class VehicleBrandsController extends Controller
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
        $brands = VehicleBrand::all();
        return view('brands.index', compact('brands'));
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
        $brands = VehicleBrand::get()->pluck('name', 'name');

        return view('brands.create', compact('brands'));
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
        $request->validate([
            'brand_name'=>'required|string'
        ]);
        $brands = VehicleBrand::create($request->all());
        return redirect()->route('admin.brands.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VehicleBrand  $vehicleBrand
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $brands = VehicleBrand::find($id);

        return view('brands.show', compact('brands'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VehicleBrand  $vehicleBrand
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $brands = VehicleBrand::find($id);
        return view('brands.edit', compact('brands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VehicleBrand  $vehicleBrand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $request->validate([
            'brand_name'=>'required|string'
        ]);
        $brands = VehicleBrand::find($id);
        $brands->update($request->all());
        return redirect()->route('admin.brands.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VehicleBrand  $vehicleBrand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $brands = VehicleBrand::find($id);
        $brands->delete();
        return redirect()->route('admin.brands.index');
    }

    public function massDestroy(Request $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        VehicleBrand::whereIn('id', request('ids'))->delete();

        return response()->noContent();
    }

    //API's
    public function getVehicleBrand(){
        try {
            $vehicleBrand = VehicleBrand::all();
            return response()->json(['success' => true, 'vehiclebrands'=> $vehicleBrand, 'message' => 'All Vehicle Brands'], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Vehicle Brand not found.'], 404);
        }
    }

}
