@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Responsibility Detail
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="200">
                            Responsibility Type
                        </th>
                        <td>
                            {{ $responsibilities->responsibility_type }}
                        </td>
                    </tr>
                    <tr>
                        <th width="200">
                            Responsibility Description
                        </th>
                        <td>
                            {{ $responsibilities->responsibility_description ?? 'N.A' }}
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
<div class="card">
    <div class="card-header">
       Account Types
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                <thead>
                    <tr>
                        <th width="10">S.No </th>
                        <th>
                            Account Type
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($account_types as $account_type)
                    <tr data-entry-id="{{ $account_type->id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $account_type->accounts_type ?? '' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection