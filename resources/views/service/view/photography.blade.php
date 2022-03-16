@extends('layouts.app')

@section('content')
    @include('service.view.parts.header', ['title' => __('Photography')])
    <div class="info-blocks">
        <div class="info-block">
            @include('service.view.parts.uploads', ['title' => __('Your Prototype Draft')])
        </div>
        <div class="info-block">
        @include('service.view.parts.edit_requests')
        </div>
    </div>
    @if(count($photos) > 0)
        <header class="intro-heading row">
            <div class="col-12 col-sm-8">
                <h2>{{ __('Teaser Photos') }}</h2>
            </div>

            <div class="col-12 col-sm-4 text-sm-right">
                <a class="link-primary" href="{{ route('customer.teaser_photo.index') }}" target="_blank">{{ __('See all') }}</a>
            </div>
        </header>
        <teaser-photo 
        :photos="{{ json_encode($photos) }}"
        ></teaser-photo>
    @endif
    @if(count($online_gallery) > 0)
        <header class="intro-heading row">
            <div class="col-12 col-sm-8">
                <h2>{{ __('Online Gallery Detail') }}</h2>
            </div>

            <div class="col-12 col-sm-4 text-sm-right">
                <a class="link-primary" href="{{$online_gallery_link}}" target="_blank">{{ __('Online Gallery') }}</a>
            </div>
        </header>
        <div class="mb-3">
            <div class="table-responsive">
                <table class="info-table">
                    <thead>
                        <tr>
                            <td>Gallery Name</td>
                            <td>Access Code</td>
                            <td>Password</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($online_gallery as $link)
                            <tr>
                                <td width="30%">{{ $link['gallery_name'] }}</td>
                                <td width="30%">{{ $link['access_code'] }}</td>
                                <td width="30%">{{ $link['password'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    @include('payments.invoice.upcoming')
    
@endsection
