@extends('layouts.app')

@section('content')
<section class="wedding">
    <h2>Your Wedding</h2>
    @include('customer.account.wedding_info')
</section>

<section class="services">
    <div class="row mb-3">
        <div class="col-sm-8">
            <h2>{{ __('Your Services') }}</h2>
        </div>
        <div class="col-sm-4 text-sm-right">    
            <a href="{{ Auth::user()->getAttributeUrl('contract') }}" class="btn-primary-inverted mb-1" target="_blank" download="Contract">
                Download Contract
            </a>
            @include('service.add')
        </div>
    </div>

    <div class="table-responsive mb-4">
        @include('service.list')
    </div>
</section>

@include('payments.invoice.upcoming')

@endsection
