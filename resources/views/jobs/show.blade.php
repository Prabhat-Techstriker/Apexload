@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Post Loads Detail
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <h4>Load Information</h4>
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
                            {{$jobDetails->orign_name ?? 'N.A'}}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Destination
                        </th>
                        <td>
                            {{$jobDetails->destination_name ?? 'N.A'}}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Miles
                        </th>
                        <td>
                            {{$jobDetails->miles ?? 'N.A'}}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Pickup Date
                        </th>
                        <td>
                            {{$jobDetails->pickup_date ?? 'N.A'}}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Load
                        </th>
                        <td>
                            {{$jobDetails->load ?? 'N.A'}}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Weight
                        </th>
                        <td>
                            {{$jobDetails->weight ?? 'N.A'}}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Lenght
                        </th>
                        <td>
                            {{$jobDetails->lenght ?? 'N.A'}}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Hieght
                        </th>
                        <td>
                            {{$jobDetails->hieght ?? 'N.A'}}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Width
                        </th>
                        <td>
                            {{$jobDetails->width ?? 'N.A'}}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Pieces
                        </th>
                        <td>
                            {{$jobDetails->pieces ?? 'N.A'}}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Quantity
                        </th>
                        <td>
                            {{$jobDetails->quantity ?? 'N.A'}}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Orign
                        </th>
                        <td>
                            {{$jobDetails->orign_name ?? 'N.A'}}
                        </td>
                    </tr>
                     <tr>
                        <th width="200">
                            Status
                        </th>
                        <td>
                            @if($jobDetails->status == 0)         
                             Completed
                            @else
                              Active
                            @endif
                            
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered table-striped">
                <h4>Company Information</h4>
                <tbody>
                    <tr>
                        <th width="200">
                            Company name
                        </th>
                        <td>
                            {{$jobDetails->com_name ?? 'N.A'}}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Company Email
                        </th>
                        <td>
                            {{$jobDetails->com_email ?? 'N.A'}}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Company Phone
                        </th>
                        <td>
                            {{$jobDetails->com_phone ?? 'N.A'}}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Company Office
                        </th>
                        <td>
                            {{$jobDetails->com_office ?? 'N.A'}}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Company Fax
                        </th>
                        <td>
                            {{$jobDetails->com_fax ?? 'N.A'}}
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered table-striped">
                <h4>Personal Information</h4>
                <tbody>
                    <tr>
                        <th width="200">
                            User Name
                        </th>
                        <td>
                            {{$jobDetails->per_user ?? 'N.A'}}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Contact Number
                        </th>
                        <td>
                            {{$jobDetails-> per_phone ?? 'N.A'}}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Email
                        </th>
                        <td>
                            {{$jobDetails->per_email ?? 'N.A'}}
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