@extends('admin::layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row pt-2 pb-2">
        <div class="col-sm-9"><h4 class="page-title">Online Gallery</h4></div>
        <div class="col-sm-3">
            <div class="btn-group float-sm-right">
                @if(Auth::guard('admin')->user()->role->isAvailable('admin.gallery-link.save'))
                <button type="button" class="btn btn-success waves-effect waves-light" onclick="$('#gallery-link-form').submit();">
                    <i class="fa fa-check-circle"></i>
                    <span>Save</span>
                </button>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-uppercase">Gallery Link</div>
                    <div class="card-body">
                        <form id="gallery-link-form" action="{{ route('admin.gallery-link.save') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="content clearfix">
                                <section id="form-vertical-p-0" role="tabpanel" aria-labelledby="form-vertical-h-0" class="body current" aria-hidden="false" style="opacity: 1;">     
                                   <div class="form-group">
                                      <label for="basic-text">
                                      URL
                                      <em class="text-danger">*</em>
                                      </label>
                                      <input type="hidden" name="id" value="{{$id}}">
                                      <input type="text" name="url" class="form-control" required="" value="{{$link}}">                  
                                   </div>
                                </section>
                             </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection