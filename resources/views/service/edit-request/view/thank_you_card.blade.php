@extends('layouts.app')

@section('edit_request_title', __('Thank You Card - Edit Request'))

@section('content')

    @include('service.edit-request.view.parts.header')

    <div class="info-columns">
        <div class="info-column wide">
            <div class="info-column__item">
                <h3 class="info-column__title">{{ __('Request Details') }}</h3>
                <div class="info-column__values">
                @foreach($edit_request->detail as $data)
                    <p class="info-column__value">
                        {{ __('Page #:page - :description', ['page' => optional($data)['page'], 'description' => optional($data)['description']]) }}
                    </p>
                @endforeach
                </div>
            </div>
        </div>
        <div class="info-column narrow">
            <div class="info-column__item">
                <h3 class="info-column__title">{{ __('Additional Note') }}</h3>
                <p class="info-column__value">{{ $edit_request->comment }}</p>
            </div>
        </div>
    </div>

@endsection
