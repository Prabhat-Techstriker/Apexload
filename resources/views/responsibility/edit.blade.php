@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        Edit Responsibility
    </div>
    <div class="card-body">
        <form action="{{ route("admin.responsibility.update", [$responsibilities->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-row">
                <div class="form-group {{ $errors->has('project_name') ? 'has-error' : '' }} col-md-12">
                    <label for="responsibility_type">Responsbility Type<span>*</span></label>
                    <input type="text" id="responsibility_type" name="responsibility_type" class="form-control" value="{{ old('responsibility_type', isset($responsibilities) ? $responsibilities->responsibility_type : '') }}" required>
                    @if($errors->has('responsibility_type'))
                    <em class="invalid-feedback">
                        {{ $errors->first('responsibility_type') }}
                    </em>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('responsibility_description') ? 'has-error' : '' }} col-md-12">
                    <label for="responsibility_description">Responsbility Description</label>
                    <textarea id="responsibility_description" name="responsibility_description" class="form-control">{{ old('responsibility_description', isset($responsibilities) ? $responsibilities->responsibility_description : '') }}</textarea>
                    @if($errors->has('responsibility_description'))
                    <em class="invalid-feedback">
                        {{ $errors->first('responsibility_description') }}
                    </em>
                    @endif
                </div>
            </div>
            <div>
                <input class="btn btn-success" type="submit" value="Update" style="float: right;">
            </div>
        </form>

    </div>
</div>

<div class="card">
    <div class="card-header">
       Account Types
    </div>
    <div class="card-body">
    <div style="padding-bottom: 20px;">
        <a href="javascript:void(0);" class="btn btn-success" data-toggle="modal" data-target="#addAccountType">Add account type</a>
    </div>
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                <thead>
                    <tr>
                        <th width="10">
                        </th>
                        <th  width="10">
                            S.No
                        </th>
                        <th>
                            Account Type
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($account_types as $account_type)
                    <tr data-entry-id="{{ $account_type->id }}">
                        <td></td>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $account_type->accounts_type ?? '' }}</td>
                        <td><a href="javascript:void(0);" class="btn btn-xs btn-info editAccounttype" data-id="{{$account_type->id}}" data-toggle="modal" data-target="#editAccounttype">Edit</a>
                            <a href="javascript:void(0);" class="btn btn-xs btn-danger deleteProperty" data-id="{{$account_type->id}}">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Account Modal -->
<div class="modal fade" id="addAccountType" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Account Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.accounts.addaccounttype') }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="accounts_type" class="col-form-label">Account Type:</label>
                        <input type="text" name="accounts_type" class="form-control" id="accounts_type">
                        <input type="hidden" name="responsibility_id" id="responsibility_id" value="{{$responsibilities->id}}">
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="javascript:void(0);" class="btn btn-success addAccountType">Add</a>
                    
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Account Modal -->
 <div class="modal fade" id="editAccounttype" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Account Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.account.updateAccounts') }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="accounts_type" class="col-form-label">Account Type:</label>
                        <input type="text" name="accounts_type" class="form-control" id="accounts_typeup" value="" required="">
                        <input type="hidden" name="account_id" id="account_id" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="javascript:void(0);" class="btn btn-success updateAccountType">Update</a>
                </div>
            </form>
        </div>
    </div>
</div> 

<!-- confirmDelete Account Modal -->
 <div class="modal fade" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Parmanently</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure about this ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" data-con="confirm"  id="confirm">Delete</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent
<script>
$(function () {
let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('users_manage')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.responsibility_mass_destroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-User:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})


$(document).ready(function(){
    $('.addAccountType').on('click', function() {
        var accounts_type = $("#accounts_type").val();
        var responsibility_id = $("#responsibility_id").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('admin.accounts.addaccounttype') }}",
            type: 'post',
            data: {accounts_type:accounts_type, responsibility_id:responsibility_id},
            dataType: 'json',
            success: function(response){ 
                if (response==1) {
                    toastr.success('Data insert successfully!', 'Added Account')
                    location.reload();
                }else{
                    toastr.error('Please try again later!', 'Not Added Account')
                }
            }
        });
    });

    // edit property
    $('.editAccounttype').on('click', function() {
        var responsibility_id = $(this).attr('data-id');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('admin.account.editAccounts') }}",
            type: 'post',
            data: {responsibility_id:responsibility_id},
            dataType: 'json',
            success: function(response){ 
                $("#accounts_typeup").val(response[0].accounts_type);
                $("#account_id").val(response[0].id);
            }
        });
    });

    // Update Property
    $('.updateAccountType').on('click', function() {
        var accounts_typeup = $("#accounts_typeup").val();
        var id              = $("#account_id").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('admin.account.updateAccounts') }}",
            type: 'post',
            data: {accounts_typeup:accounts_typeup,id:id},
            dataType: 'json',
            success: function(response){ 
                if (response==1) {
                    toastr.success('Successfully!', 'Update Account Type')
                    location.reload();
                }else{
                    toastr.error('Please try again later!')
                }
                
            }
        });
    });


    // detetedProperty
    $('.deleteProperty').on('click', function() {
        $('#confirmDelete').modal('show');
        var id = $(this).attr('data-id');
        $('#confirm').on('click', function() {
            var confirmval = $("#confirm").attr('data-con');
            if (confirmval == "confirm") {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('admin.account.detetedAccounts') }}",
                    type: 'post',
                    data: {id:id},
                    dataType: 'json',
                    success: function(response){ 
                        if (response==1) {
                            toastr.success('Successfully!', 'Delete Account Type')
                            location.reload();
                        }else{
                            toastr.error('Please try again later!')
                        }
                        
                    }
                });
            }
        });

    });

});

</script>
@endsection
<style type="text/css">
    .dt-buttons {
    display: none;
}
td.select-checkbox {
    display: none;
}
th.select-checkbox.sorting_disabled {
    display: none;
}
</style>