@extends('layouts.app')

@section('content')
	<header class="intro-heading row">
        <div class="col-12 col-sm-8">
            <h2>{{ __('Online Gallery Detail') }}</h2>
        </div>
        @if(count($online_gallery) > 0)
	        <div class="col-12 col-sm-4 text-sm-right">
	            <a class="link-primary" href="{{$online_gallery_link}}" target="_blank">{{ __('Online Gallery') }}</a>
	        </div>
        @endif
    </header>
	<online-gallery 
        :online_gallery="{{ json_encode($online_gallery) }}"
        :online_gallery_link="{{ json_encode($online_gallery_link) }}"
        ></online-gallery>
@endsection