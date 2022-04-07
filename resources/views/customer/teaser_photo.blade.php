@extends('layouts.app')

@section('content')
    <div class="teaser_content_wrap">
        <h2 class="teaser_title">Teaser Photo</h2>
        @php
            $photoes_str = '';
            $photoes_arr = [];
        @endphp
            @if(count($photos)> 0)
                @foreach ($photos as $val)
                    @php
                        $photoes_arr[] = $val['image_url'];
                    @endphp
                @endforeach
                @php $photoes_str = implode('|',$photoes_arr); @endphp
            @endif

        @if($photoes_str !== '')
            <a href="{{route('customer.teaser_photo.zip-file-download',['file'=>base64_encode($photoes_str),'form'=>'teaser_photo'])}}" class="teaser_download_all btn-primary-inverted mb-1" >Download All</a>
        @endif
    </div>
    <br>
	<teaser-photo
        :photos="{{ json_encode($photos) }}"
        ></teaser-photo>
@endsection
