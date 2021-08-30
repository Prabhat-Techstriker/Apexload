<?php

namespace App\Http\Controllers;

use App\Responsibility;
use App\AccountType;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;


class ResponsibilitiesController extends Controller
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
        $responsibilities = Responsibility::all();
        return view('responsibility.index', compact('responsibilities'));
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
        $responsibilities = Responsibility::get()->pluck('name', 'name');

        return view('responsibility.create', compact('responsibilities'));
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
            'responsibility_type'=>'required|string'
        ]);
        $responsibilities = Responsibility::create($request->all());
        return redirect()->route('admin.responsibility');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Responsibility  $responsibility
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $responsibilities = Responsibility::find($id);
        $account_types = AccountType::where('responsibility_id', $id)->get();

        return view('responsibility.show', compact('responsibilities','account_types')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Responsibility  $responsibility
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $responsibilities   = Responsibility::find($id);
        $account_types = AccountType::where('responsibility_id', $id)->get();
        if (empty($account_types)) {
            $account_types = array();
        }

        return view('responsibility.edit', compact('responsibilities','account_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Responsibility  $responsibility
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $request->validate([
            'responsibility_type'=>'required|string'
        ]);
        $responsibilities = Responsibility::find($id);
        $responsibilities->update($request->all());
        return redirect()->route('admin.responsibility');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Responsibility  $responsibility
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $responsibilities = Responsibility::find($id);
        $responsibilities->delete();
        return redirect()->route('admin.responsibility');
    }

    public function massDestroy(Request $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        Responsibility::whereIn('id', request('ids'))->delete();

        return response()->noContent();
    }


    public function addAccounttype(Request $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $request->validate([
            'accounts_type'=>'required|string'
        ]);
        $accountType = AccountType::create($request->all());
        if($accountType){
            echo 1;
        }else{
            echo 0;
        }
    }
    
    public function editAccount(Request $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $accountType = AccountType::where('id', $request->responsibility_id)->get();
        return response()->json($accountType);
    }

    public function updateAccount(Request $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $request->request->add(['accounts_type' => $request->accounts_typeup]);
        $accountType = AccountType::find($request->id);
        $accountType->update($request->only('accounts_type'));
        if($accountType){
            echo 1;
        }else{
            echo 0;
        }
    }

    public function detetedAccount(Request $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $accountType = AccountType::find($request->id);
        $accountType->delete();
        if($accountType){
            echo 1;
        }else{
            echo 0;
        }
    }

    //Api's
    
    public function getResponsibility(){
        try {
            $responsibilities = Responsibility::all();
            return response()->json(['success' => true, 'responsibilities'=> $responsibilities, 'message' => 'All Responsibilities'], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Responsibilities not found.'], 404);
        }
    }
    
    public function getAccountByresponsibityId(Request $request){
        try {
            $accountTypes = AccountType::where('responsibility_id', $request->responsibility_id)->get(); 
            return response()->json(['success' => true, 'accountTypes'=> $accountTypes, 'message' => 'All Account Types'], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Account Type not found.'], 404);
        }
    }
}
