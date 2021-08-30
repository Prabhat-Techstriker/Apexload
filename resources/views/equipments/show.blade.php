@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Equipment Detail
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="200">
                            Type
                        </th>
                        <td>
                            {{ $equipments->type }}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Description
                        </th>
                        <td>
                            {{ $equipments->description ?? 'N.A' }}
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