@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
       Post loads 
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
                            Pickup Date
                        </th>
                        <th>
                            Company Name
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
                    @foreach($jobs as $key => $job)
                        <tr data-entry-id="{{ $job->id }}">
                            
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ $job->poste_by }}
                            </td>
                            <td>
                                {{ $job->orign_name }}
                            </td>
                            <td>
                                {{ $job->destination_name }}
                            </td>
                            <td>
                                {{ $job->miles }}
                            </td>
                            <td>
                                {{ $job->pickup_date }}
                            </td>
                            <td>
                                {{ $job->com_name }}
                            </td>
                            <td>
                              @if($job->status == 0)         
                              <i style="color: green;" class="fa fa-check-circle" aria-hidden="true"></i> 
                            @else
                              <i style="color: #ffc107;" class="fa fa-clock-o" aria-hidden="true"></i>
                            @endif
                            </td>
                            
                            <td>
                                <a class="btn btn-xs btn-primary" href="{{ route('admin.post-loasds.show', $job->id) }}">
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