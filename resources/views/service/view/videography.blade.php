@extends('layouts.app')

@section('content')
    @include('service.view.parts.header', ['title' => __('Cinematography')])

    <div class="info-blocks">
        <div class="info-block">
            @include('service.view.parts.uploads', ['title' => __('Your Prototype Draft')])
        </div>
        <div class="info-block">
        @include('service.view.parts.edit_requests')
        </div>
    </div>

    <h2 class="mb-3">Links</h2>
    @if(count($links) > 0)
        <div class="mb-3">
            <div class="table-responsive">
                <table class="info-table">
                    <thead>
                        <tr>
                            <td>Type</td>
                            <td>Link</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($links as $link)
                            <tr>
                                <td width="30%">{{ $link['type'] }}</td>
                                <td><a href="{{$link['link']}}" style="color:blue;    text-decoration: underline;" target="_blank">{{ $link['link'] }}</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="mb-3">There are no links in your list</div>
    @endif
    @include('payments.invoice.upcoming')

@endsection
