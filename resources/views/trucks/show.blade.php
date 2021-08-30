@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Truck Post Detail
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
               
                <tbody>
                    <tr>
                        <th width="200">
                            Posted By
                        </th>
                        <td>
                            {{$created_by}}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Orign
                        </th>
                        <td>
                            {{$truckDetails->orign_name ?? 'N.A'}}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Destination
                        </th>
                        <td>
                            {{$truckDetails->destination_name ?? 'N.A'}}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Miles
                        </th>
                        <td>
                            {{$truckDetails->miles ?? 'N.A'}}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Available Date
                        </th>
                        <td>
                            {{$truckDetails->available_date ?? 'N.A'}}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Load Size
                        </th>
                        <td>
                            {{$truckDetails->load_size ?? 'N.A'}}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Width
                        </th>
                        <td>
                            {{$truckDetails->width ?? 'N.A'}}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Lenght
                        </th>
                        <td>
                            {{$truckDetails->lenght ?? 'N.A'}}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Hieght
                        </th>
                        <td>
                            {{$truckDetails->hieght ?? 'N.A'}}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Description
                        </th>
                        <td>
                            {{$truckDetails->description ?? 'N.A'}}
                        </td>
                    </tr>
                     <tr>
                        <th width="200">
                            Status
                        </th>
                        <td>
                            @if($truckDetails->status == 0)         
                             Completed
                            @else
                              Active
                            @endif
                            
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