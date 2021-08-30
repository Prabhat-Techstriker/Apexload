@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
       Trucks Posts 
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
                          Posted by
                        </th>
                        <th>
                            Orign
                        </th>
                       <th>
                            Destination
                        </th>
                       <th>
                        Miles
                            
                        </th>
                       
                       <th>
                            Available Date
                        </th>
                       
                       <th>
                            Status
                        </th>
                       
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($newTrucks as $key => $truck)
                        <tr data-entry-id="{{ $truck['id'] }}">
                            
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ $truck->poste_by }}
                            </td>
                            <td>
                                {{ $truck->orign_name }}
                            </td>
                            <td>
                                {{ $truck->destination_name }}
                            </td>
                            <td>
                                {{ $truck->miles ?? 'N.A' }}
                            </td>
                            <td>
                               {{ $truck->available_date ?? 'N.A' }}
                            </td>
                            <td>
                              @if($truck->status == 0)         
                              <i style="color: green;" class="fa fa-check-circle" aria-hidden="true"></i> 
                            @else
                              <i style="color: #ffc107;" class="fa fa-clock-o" aria-hidden="true"></i>
                            @endif
                            </td>
                            
                            <td>
                                <a class="btn btn-xs btn-primary" href="{{ route('admin.trucks.show', $truck->id) }}">
                                    {{ trans('global.view') }}
                                </a>
                                
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection