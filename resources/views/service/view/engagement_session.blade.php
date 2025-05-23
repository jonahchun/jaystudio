<?php
use App\Core\Model\OnlineGalleryLink;
?>


@extends('layouts.app')

@section('content')

    @include('service.view.parts.header2', ['title' => __('Engagement Session')])

    @if(count($online_gallery) > 0)
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
        @if(isset($online_gallery[0]['customer']['online_gallery_link']['name'])
                    && $online_gallery[0]['customer']['online_gallery_link']['name'] === OnlineGalleryLink::ZENFOLIO)
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
                                <td width="50%">{{ $link['gallery_name'] }}</td>
                                <td width="25%">{{ $link['access_code'] }}</td>
                                <td width="25%">{{ $link['password'] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="table-responsive">
                <table class="info-table">
                    <thead>
                    <tr>
                        <td>Gallery Name</td>
                        <td>Collection URL</td>
                        <td>Collection Password</td>
                        <td>Download PIN</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($online_gallery as $link)
                        <tr>
                            <td width="30%">{{ $link['gallery_name'] }}</td>
                            <td width="30%"><a style="color: blue; text-decoration: underline;" target="_blank" href="{{ $link['collection_url'] }}" >{{ $link['collection_url'] }}</a></td>
                            <td width="20%">{{ $link['collection_password'] }}</td>
                            <td width="20%">{{ $link['download_pin'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif



    @endif

    <div>&nbsp;</div>
    @include('payments.invoice.upcoming')

@endsection
