<?php
use App\Core\Model\OnlineGalleryLink;
?>


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
    @if(count($online_gallery) > 0 )
        <header class="intro-heading row">
            <div class="col-12 col-sm-8">
                <h2>{{ __('Online Gallery Detail') }}</h2>
            </div>

            <div class="col-12 col-sm-4 text-sm-right">
                @if(isset($online_gallery[0]['customer']['online_gallery_link']['name'])
                    && $online_gallery[0]['customer']['online_gallery_link']['name'] === OnlineGalleryLink::ZENFOLIO)
                <a class="link-primary" href="{{$online_gallery_link}}" target="_blank">{{ __('Online Gallery') }}</a>
                @endif
            </div>
        </header>
        <div class="mb-3">
            @if(isset($online_gallery[0]['customer']['online_gallery_link']['name'])
                    && $online_gallery[0]['customer']['online_gallery_link']['name'] === OnlineGalleryLink::ZENFOLIO)
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
                                    <td width="50%">{{ $link['gallery_name'] }}</td>
                                    <td width="25%">{{ $link['access_code'] }}</td>
                                    <td width="25%">{{ $link['password'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="table-responsive">
                    <table class="info-table">
                        <thead>
                        <tr>
                            <td>Collection URL</td>
                            <td>Collection Password</td>
                            <td>Download PIN</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($online_gallery as $link)
                            <tr>
                                <td width="50%"><a style="color: blue; text-decoration: underline;" target="_blank" href="{{ $link['collection_url'] }}" >{{ $link['collection_url'] }}</a></td>
                                <td width="25%">{{ $link['collection_password'] }}</td>
                                <td width="25%">{{ $link['download_pin'] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    @endif

    @include('payments.invoice.upcoming')

@endsection
