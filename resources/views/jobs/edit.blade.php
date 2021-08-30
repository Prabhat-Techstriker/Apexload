@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        Edit Project
    </div>
    <div class="card-body">
        <form action="{{ route("admin.projects.update", [$projects->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-row">
                <div class="form-group {{ $errors->has('project_name') ? 'has-error' : '' }} col-md-12">
                    <label for="project_name">Project Name<span>*</span></label>
                    <input type="text" id="project_name" name="project_name" class="form-control" value="{{ old('project_name', isset($projects) ? $projects->project_name : '') }}" required>
                    @if($errors->has('project_name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('project_name') }}
                    </em>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('project_description') ? 'has-error' : '' }} col-md-12">
                    <label for="project_description">Project Description</label>
                    <textarea id="project_description" name="project_description" class="form-control">{{ old('project_description', isset($projects) ? $projects->project_description : '') }}</textarea>
                    @if($errors->has('project_description'))
                    <em class="invalid-feedback">
                        {{ $errors->first('project_description') }}
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
       Property Types
    </div>
    <div class="card-body">
    <div style="padding-bottom: 20px;">
        <a href="javascript:void(0);" class="btn btn-success" data-toggle="modal" data-target="#addProperty">Add property</a>
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
                            Property Type
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($properties as $property)
                    <tr data-entry-id="{{ $property->id }}">
                        <td></td>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $property->property_name ?? '' }}</td>
                        <td><a href="javascript:void(0);" class="btn btn-xs btn-info editProperty" data-toggle="modal" data-target="#editProperty">Edit</a>
                            <a href="javascript:void(0);" class="btn btn-xs btn-danger deleteProperty" data-id="{{$property->id}}">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Property Modal -->
<div class="modal fade" id="addProperty" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Property</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.projects.addProperty') }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="property_name" class="col-form-label">Property Name:</label>
                        <input type="text" name="property_name" class="form-control" id="property_name">
                        <input type="hidden" name="project_id" id="project_id" value="{{$projects->id}}">
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="javascript:void(0);" class="btn btn-success addProperty">Add</a>
                    
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Property Modal -->
<div class="modal fade" id="editProperty" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Property</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.property.updateProperty') }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="property_name" class="col-form-label">Property Name:</label>
                        <input type="text" name="property_name" class="form-control" id="property_nameup" value="" required="">
                        <input type="hidden" name="property_id" id="property_id" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="javascript:void(0);" class="btn btn-success updateProperty">Update</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- confirmDelete Property Modal -->
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
@can('sales_manage')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.projects.mass_destroy') }}",
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
    $('.addProperty').on('click', function() {
        var property_name = $("#property_name").val();
        var project_id = $("#project_id").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('admin.projects.addProperty') }}",
            type: 'post',
            data: {property_name:property_name, project_id:project_id},
            dataType: 'json',
            success: function(response){ 
                if (response==1) {
                    toastr.success('Data insert successfully!', 'Added Property')
                    location.reload();
                }else{
                    toastr.error('Please try again later!', 'Not Added Property')
                }
            }
        });
    });

    // edit property
    $('.editProperty').on('click', function() {
        var project_id = $("#project_id").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('admin.property.editProperty') }}",
            type: 'post',
            data: {project_id:project_id},
            dataType: 'json',
            success: function(response){ 
                $("#property_nameup").val(response[0].property_name);
                $("#property_id").val(response[0].id);
            }
        });
    });
    // Update Property
    $('.updateProperty').on('click', function() {
        var property_nameup = $("#property_nameup").val();
        var property_id     = $("#property_id").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('admin.property.updateProperty') }}",
            type: 'post',
            data: {property_nameup:property_nameup,property_id:property_id},
            dataType: 'json',
            success: function(response){ 
                if (response==1) {
                    toastr.success('Successfully!', 'Update Property')
                    location.reload();
                }else{
                    toastr.error('Please try again later!')
                }
                
            }
        });
    });

    //

    // detetedProperty
    $('.deleteProperty').on('click', function() {
        $('#confirmDelete').modal('show');

        var property_id = $(".deleteProperty").attr('data-id');
        $('#confirm').on('click', function() {
            var confirmval = $("#confirm").attr('data-con');
            if (confirmval == "confirm") {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('admin.property.detetedProperty') }}",
                    type: 'post',
                    data: {property_id:property_id},
                    dataType: 'json',
                    success: function(response){ 
                        if (response==1) {
                            toastr.success('Successfully!', 'Delete Property')
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