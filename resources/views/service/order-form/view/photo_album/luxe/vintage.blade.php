<div class="info-column__item flex-start">
    <h3 class="info-column__title narrow">{{ __('Cover option') }}</h3>
    <div class="info-column__img-wrap">
        <image-with-zoom
            image_url="{{ $service->vintage_cover->getAttributeUrl('thumbnail') }}"
            image_class="info-column__img"
        ></image-with-zoom>
    </div>
</div>
<div class="info-column__item flex-start">
    <h3 class="info-column__title narrow">{{ __('Cover option') }}</h3>
    <div class="info-column__img-wrap">
        <image-with-zoom
            image_url="{{ $service->black_matte_cover->getAttributeUrl('thumbnail') }}"
            image_class="info-column__img"
        ></image-with-zoom>
    </div>
</div>