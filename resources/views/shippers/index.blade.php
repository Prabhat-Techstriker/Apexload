@extends('layouts.admin')
@section('content')
@can('users_manage' )
    <!-- <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{route('admin.responsibility.create')}}">
                Add Responsbility
            </a>
        </div>
    </div> -->
@endcan
<div class="card">
    <div class="card-header">
       All Shippers
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped">
                <thead>
                    <tr>
                        
                        <th>
                            S.No
                        </th>
                        <th>
                            Profile
                        </th>
                        <th>
                            Full Name
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            Phone Number
                        </th>
                        <th>
                           Address
                        </th>
                        <th>
                            Verify
                        </th>
                          
                        
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($shippers as $key => $shipper)
                        <tr data-entry-id="{{ $shipper->id }}">
                           
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td class="imagepro">
                                @if($shipper->profile_image != '')  
                                  <img id="profileDisplay" src="{{ url('/') }}/storage/app/{{ $shipper->profile_image}}">
                                @else
                                  <img id="profileDisplay" src="{{ url('storage/app/images') }}/avatar-dummy.png">      
                                @endif
                            </td>
                            <td>
                                {{ $shipper->first_name. ' ' .$shipper->last_name}}
                              
                            </td>
                            <td>
                                {{ $shipper->email ?? 'N.A'}}
                              
                            </td>
                            <td>
                                
                              {{ $shipper->phone_number ?? 'N.A'}}
                            </td>
                           <td>
                                
                              {{ $shipper->address ?? 'N.A'}}
                            </td>
                           <td>
                                
                            @if($shipper->email_verify == 1)         
                              <i style="color: green;" class="fa fa-check-circle" aria-hidden="true"></i>        
                            @elseif($shipper->phone_verify == 1)
                              <i style="color: green;" class="fa fa-check-circle" aria-hidden="true"></i>   
                            @else
                              <i style="color: red;" class="fa fa-times-circle" aria-hidden="true"></i>
                            @endif
                              
                            </td>
                            
                           
                            <td>
                                <a class="btn btn-xs btn-primary" href="{{ route('admin.shipper.show', $shipper->id) }}">
                                    {{ trans('global.view') }}
                                </a>

                                <a class="btn btn-xs btn-info" href="{{ route('admin.shipper.edit',$shipper->id) }}">
                                    {{ trans('global.edit') }}
                                </a>

                                <!-- <form action="{{ route('admin.shipper.delete', $shipper->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                </form> -->
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
@endsection
<style type="text/css">
img#profileDisplay {
    width: 50px;
    border-radius: 50%;
    height: 50px;
    object-fit: cover;
}
td.imagepro {
    width: 10%;
}
</style>