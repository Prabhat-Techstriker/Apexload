@extends('layouts.admin')
@section('content')

 <div class="card">
    <div class="card-header">
        Shipper Detail
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
                            @if($shipper->profile_image != '')  
                              <img id="profileDisplay" src="{{ url('/') }}/storage/app/{{ $shipper->profile_image}}">
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
                             {{ $shipper->first_name. ' ' .$shipper->last_name}}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Email
                        </th>
                        <td>
                             {{ $shipper->email ?? 'N.A'}}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Phone Number
                        </th>
                        <td>
                            {{ $shipper->phone_number ?? 'N.A'}}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Address
                        </th>
                        <td>
                            {{ $shipper->address ?? 'N.A'}}
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