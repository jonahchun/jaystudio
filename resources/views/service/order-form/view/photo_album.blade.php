@extends('layouts.app')

@section('content')

    @include('customer.account.wedding_info')

    <div class="row mb-3">
        <div class="col-sm-8">
            <h2>{{ __('Photo Album - Service View') }}</h2>
        </div>
        <div class="col-sm-4 text-sm-right">
            <a class="btn-primary" href="{{ route('service.view', ['service' => $service]) }}">{{ __('View') }}</a>
        </div>
    </div>

    <div class="danger-panel col-xl-5">
        @include('service.parts.status.short')
    </div>

    <div class="info-columns">
        <div class="info-column narrow">
            <div class="info-column__item">
                <h3 class="info-column__title narrow">{{ __('Album Type') }}</h3>
                <p class="info-column__value">{{ \App\Album\Model\Source\Type::getInstance()->getOptionLabel($service->album_type) }}</p>
            </div>
            <div class="info-column__item">
                <h3 class="info-column__title narrow">{{ __('Album Information') }}</h3>
                <p class="info-column__value">{{ $service->core_type->title }}</p>
            </div>
            <div class="info-column__item">
                <h3 class="info-column__title narrow">{{ __('Size') }}</h3>
                <p class="info-column__value">{{ $service->size ? $service->size->title : $service->other_size }}</p>
            </div>

            @includeIf('service.order-form.view.photo_album.' . $service->album_type . '_type_options')

            @if($service->delivery_location)
            <div class="info-column__item">
                <h3 class="info-column__title">{{ __('Delivery Location') }}</h3>
                <div class="info-column__values">
                    <p class="info-column__value">{{ $service->delivery_location->title }}</p>
                    <p class="info-column__value">{!! nl2br($service->delivery_location->address) !!}</p>
                    <a href="tel:{{ $service->delivery_location->getTelephoneAsNumber() }}" class="info-column__value link">
                        {{ $service->delivery_location->telephone }}
                    </a>
                    <p class="info-column__value">{!! nl2br($service->delivery_location->working_hours) !!}</p>
                </div>
            </div>
            @endif
            <div class="info-column__item">
                <h3 class="info-column__title">{{ __('Additional Note') }}</h3>
                <p class="info-column__value">{{ $service->comment }}</p>
            </div>
        </div>
        <div class="info-column wide">
            @include('service.order-form.view.photo_album.images')
        </div>
    </div>

@endsection
