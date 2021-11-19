<div class="info-column__item flex-start">
    <h3 class="info-column__title narrow">{{ __('Color') }}</h3>
    <p class="info-column__value">{{ $service->art_deco_color->title }}</p>
</div>
<div class="info-column__item flex-start">
    <h3 class="info-column__title narrow">{{ __('Pattern') }}</h3>
    <div class="info-column__img-wrap">
        <image-with-zoom
            image_url="{{ $service->art_deco_pattern->getAttributeUrl('thumbnail') }}"
            image_class="info-column__img"
        ></image-with-zoom>
    </div>
</div>
<div class="info-column__item flex-start">
    <h3 class="info-column__title narrow">{{ __('Cover Image') }}</h3>
    <p class="info-column__value">{{ $service->art_deco_cover_image }}</p>
</div>