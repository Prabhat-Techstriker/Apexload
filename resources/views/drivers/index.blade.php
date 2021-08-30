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
       All Drivers
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
                            Fleet Manager Name
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
                    @foreach($drivers as $key => $driver)
                        <tr data-entry-id="{{ $driver->id }}">
                            
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td class="imagepro">
                                @if($driver->profile_image != '')  
                                  <img id="profileDisplay" src="{{ url('/') }}/storage/app/{{ $driver->profile_image}}">
                                @else
                                  <img id="profileDisplay" src="{{ url('storage/app/images') }}/avatar-dummy.png">      
                                @endif
                            </td>
                            <td>
                               
                              {{ $driver->driverBy  }}
                            </td>
                            <td>
                                {{ $driver->first_name. ' ' .$driver->last_name}}
                              
                            </td>
                            
                            <td>
                                {{ $driver->email ?? 'N.A'}}
                              
                            </td>
                            <td>
                                
                              {{ $driver->phone_number ?? 'N.A'}}
                            </td>

                           <td>
                                
                              {{ $driver->address ?? 'N.A'}}
                            </td>
                           <td>
                                
                            @if($driver->email_verify == 1)         
                              <i style="color: green;" class="fa fa-check-circle" aria-hidden="true"></i>        
                            @elseif($driver->phone_verify == 1)
                              <i style="color: green;" class="fa fa-check-circle" aria-hidden="true"></i>   
                            @else
                              <i style="color: red;" class="fa fa-times-circle" aria-hidden="true"></i>
                            @endif
                              
                            </td>
                            
                           
                            <td>
                                <a class="btn btn-xs btn-primary" href="{{ route('admin.driver.show', $driver->id) }}">
                                    {{ trans('global.view') }}
                                </a>

                                <a class="btn btn-xs btn-info" href="{{ route('admin.driver.edit',$driver->id) }}">
                                    {{ trans('global.edit') }}
                                </a>

                                <!-- <form action="{{ route('admin.driver.delete', $driver->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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