@extends('layouts.admin')
@section('content')

 <div class="card">
    <div class="card-header">
        Driver Detail
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="200">
                            Profile Image
                        </th>
                        <td>
                            @if($driver->profile_image != '')  
                              <img id="profileDisplay" src="{{ url('/') }}/storage/app/{{ $driver->profile_image}}">
                            @else
                              <img id="profileDisplay" src="{{ url('storage/app/images') }}/avatar-dummy.png">      
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Full Name
                        </th>
                        <td>
                             {{ $driver->first_name. ' ' .$driver->last_name}}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Email
                        </th>
                        <td>
                             {{ $driver->email ?? 'N.A'}}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Phone Number
                        </th>
                        <td>
                            {{ $driver->phone_number ?? 'N.A'}}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Address
                        </th>
                        <td>
                            {{ $driver->address ?? 'N.A'}}
                        </td>
                    </tr>

                </tbody>
            </table>
            <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
</div> 

@endsection
<style type="text/css">
    img#profileDisplay {
    width: 12%;
}
</style>