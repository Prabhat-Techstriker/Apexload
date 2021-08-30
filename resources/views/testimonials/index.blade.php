@extends('layouts.admin')
@section('content')
@can('users_manage' )
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{route('admin.testimonials.create')}}">
                Add Testimonials
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
       Testimonials
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
                          User Image                        
                        </th>
                        <th>
                          Name                      
                        </th>
                        <th>
                          Comment                      
                        </th>
                         <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($testimonials as $key => $testimonial)

                        <tr data-entry-id="{{ $testimonial->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $loop->iteration }}
                            </td>

                           
                         
                            <td class="imagepro">
                                @if($testimonial->user_image != '')  
                                  <img id="profileDisplay" src="{{ url('/') }}/public/testimonialsUser/{{ $testimonial->user_image}}">
                                @endif
                            </td>
                            <td>
                                {{ $testimonial->name }}
                            </td>
                                   
                            <td>
                                {{ $testimonial->description }}
                            </td>
                            <td>
                                <a class="btn btn-xs btn-info" href="{{ route('admin.testimonials.edit',$testimonial->id) }}">
                                    {{ trans('global.edit') }}
                                </a>

                                <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
    height: 65px;
}
</style>