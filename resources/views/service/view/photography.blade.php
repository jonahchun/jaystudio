@extends('layouts.app')

@section('content')
    <a class="btn-default--alt mb-3" href="{{ route('customer.teaser_photo.index') }}">{{ __('View Teaser Photo') }}</a>
    @include('service.view.parts.header', ['title' => __('Photography')])

    <div class="info-blocks">
        <div class="info-block">
            @include('service.view.parts.uploads', ['title' => __('Your Prototype Draft')])
        </div>
        <div class="info-block">
        @include('service.view.parts.edit_requests')
        </div>
    </div>

    @include('payments.invoice.upcoming')
    
@endsection
