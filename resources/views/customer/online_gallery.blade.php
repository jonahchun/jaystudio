@extends('layouts.app')

@section('content')
	<header class="intro-heading row">
        <div class="col-12 col-sm-8">
            @if($gallery_name == App\Services\Model\Source\Type::ENGAGEMENT_SESSION)
                <h2>{{ __('Engagement Photo') }}</h2>
            @endif
            @if($gallery_name == App\Services\Model\Source\Type::PHOTO)
                <h2>{{ __('Wedding Photo') }}</h2>
            @endif

            
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