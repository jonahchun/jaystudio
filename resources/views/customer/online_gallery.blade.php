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
            <div class="col-12 online_gallery_info">
                <p>Please click the 'ONLINE GALLERY' link on the right side of the page and use the below access code(s) and password(s) to access your photos.</p>
            </div>
        @endif
    </header>
	<online-gallery
        :online_gallery="{{ json_encode($online_gallery) }}"
        :online_gallery_link="{{ json_encode($online_gallery_link) }}"
        ></online-gallery>
@endsection

