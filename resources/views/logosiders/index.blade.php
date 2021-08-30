@extends('layouts.admin')
@section('content')
@can('users_manage' )
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{route('admin.logoslider.add')}}">
                Add Logos
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        Slider logo
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            S.No
                        </th>
                        <th>
                          Logo                        
                        </th>
                         <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sliderlogo as $key => $logo)

                        <tr data-entry-id="{{ $logo->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                           
                         
                            <td class="imagepro">
                                @if($logo->filenames != '')  
                                  <img id="profileDisplay" src="{{ url('/') }}/public/brandlogos/{{ $logo->filenames}}">
                                @endif
                            </td>
                                   

                            <td>
                                <a class="btn btn-xs btn-info" href="{{ route('admin.logoslider.edit',$logo->id) }}">
                                    {{ trans('global.edit') }}
                                </a>

                                <form action="{{ route('admin.logoslider.destroy', $logo->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                </form>
                            </td>
                           
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>
</div>
@endsection
<style type="text/css">
    img#profileDisplay {
    height: 80px;
}
</style>