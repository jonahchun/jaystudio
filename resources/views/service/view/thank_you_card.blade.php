@extends('layouts.app')

@section('content')

    @include('service.view.parts.header', ['title' => __('Thank You Cards')])

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



