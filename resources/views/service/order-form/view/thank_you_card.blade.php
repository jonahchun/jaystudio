@extends('layouts.app')

@section('content')

    @include('customer.account.wedding_info')

    <div class="row mb-3">
        <div class="col-sm-8">
            <h2>{{ __('Thank You Card - Order Form') }}</h2>
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
                <h3 class="info-column__title narrow">{{ __('Card Type') }}</h3>
                <p class="info-column__value">{{ __(':type card', ['type' => \App\Card\Model\Source\LayoutType::getInstance()->getOptionLabel($service->layout_type) ]) }}</p>
            </div>
            @if($service->message)
                <div class="info-column__item">
                    <h3 class="info-column__title narrow">{{ __('Message') }}</h3>
                    <p class="info-column__value">{{ $service->message }}</p>
                </div>
            @endif
            @foreach(\App\Card\Model\Source\Sides::getInstance()->getOptions() as $key => $label)
                @php
                    if($service->layout_type == \App\Card\Model\Source\LayoutType::FLAT 
                        && $key == \App\Card\Model\Source\Sides::INSIDE)
                            continue;
                @endphp
                @if($template = $service->{$key . '_template'})
                <div class="info-column__item flex-start">
                    <h3 class="info-column__title narrow">{{ __(':side Template', ['side' => $label]) }}</h3>
                    <div class="info-column__img-wrap">
                        <image-with-zoom
                            image_url="{{ $template->getAttributeUrl('image') }}"
                            image_class="info-column__img"
                        ></image-with-zoom>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
        <div class="info-column wide">
            <div class="info-column__item">
                <h3 class="info-column__title">{{ __('Card Information') }}</h3>
                <div class="info-column__values">
                    <p class="info-column__value">
                        {{ __('Size: :size', ['size' => optional($service->size)->title]) }}
                    </p>
                    <p class="info-column__value">
                        {{ __('Format: :format', ['format' => \App\Card\Model\Source\Format::getInstance()->getOptionLabel($service->detail->format)]) }}
                    </p>
                    <p class="info-column__value">
                        {{ __('Amount of Cards: :amount', ['amount' => intval($service->detail->cards_amount)]) }}
                    </p>
                </div>
            </div>
            @foreach(\App\Card\Model\Source\Sides::getInstance()->getOptions() as $key => $label)
                @php
                    if($service->layout_type == \App\Card\Model\Source\LayoutType::FLAT 
                        && $key == \App\Card\Model\Source\Sides::INSIDE)
                            continue;
                @endphp
                @if(($images = $service->{$key . '_images'}) && ($template = $service->{$key . '_template'}))
                <div class="info-column__item">
                    <h3 class="info-column__title">{{ __(':side Images', ['side' => $label]) }}</h3>
                    <div class="info-column__uploads">
                        @for($i = 1; $i <= $template->images_count; $i++)
                        <order-form-image-edit
                            image_number="{{ $i }}"
                            name_prefix="{{ $key . '_images' }}"
                            image_val="{{ !empty($images[$i]) ? $images[$i] : false }}"
                            url="{{ route('service.order-form.update', ['service' => $service->id]) }}"
                            :can_edit="{{ $service->status == \App\Services\Model\Source\Status::ORDER_FORM_SUBMITTED ? 'true' : 'false' }}"
                        ></order-form-image-edit>
                        @endfor
                    </div>
                </div>
                @endif
            @endforeach
        </div>
        <div class="info-column narrow">
            <order-form-comment-edit
                comment_value="{{ $service->comment }}"
                url="{{ route('service.order-form.update', ['service' => $service->id]) }}"
                :can_edit="{{ $service->status == \App\Services\Model\Source\Status::ORDER_FORM_SUBMITTED ? 'true' : 'false' }}"
            ></order-form-comment-edit>
        </div>
    </div>
@endsection
