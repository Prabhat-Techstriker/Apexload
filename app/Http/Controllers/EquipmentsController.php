<?php

namespace App\Http\Controllers;

use App\Equipment;
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

class EquipmentsController extends Controller
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
        $equipments = Equipment::all();
        return view('equipments.index', compact('equipments'));
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
        $equipments = Equipment::get()->pluck('name', 'name');

        return view('equipments.create', compact('equipments'));
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
            'type'=>'required|string'
        ]);
        $equipments = Equipment::create($request->all());
        return redirect()->route('admin.equipments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $equipments = Equipment::find($id);

        return view('equipments.show', compact('equipments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $equipments = Equipment::find($id);
        return view('equipments.edit', compact('equipments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $request->validate([
            'type'=>'required|string'
        ]);
        $equipments = Equipment::find($id);
        $equipments->update($request->all());
        return redirect()->route('admin.equipments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $brands = Equipment::find($id);
        $brands->delete();
        return redirect()->route('admin.equipments.index');
    }

    public function massDestroy(Request $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        Equipment::whereIn('id', request('ids'))->delete();
        return response()->noContent();
    }

    //API's
    public function getEquipmentType(){
        try {
            $equipments = Equipment::all();
            return response()->json(['success' => true, 'equipments'=> $equipments, 'message' => 'All Equipments Type'], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Equipments not found.'], 404);
        }
    }
}
