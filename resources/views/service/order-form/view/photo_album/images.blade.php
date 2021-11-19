<h3 class="info-column__title full-width">{{ __('List of images to put in the album') }}</h3>
<div class="info-column__uploads">
    @php
        $images = $service->images;
    @endphp
    @for($i = 1; $i <= $service->core_type->photos_count; $i++)
        <order-form-image-edit
            image_number="{{ $i }}"
            name_prefix="images"
            image_val="{{ !empty($images[$i]) ? $images[$i] : false }}"
            url="{{ route('service.order-form.update', ['service' => $service->id]) }}"
            :can_edit="{{ $service->status == \App\Services\Model\Source\Status::ORDER_FORM_SUBMITTED ? 'true' : 'false' }}"
        ></order-form-image-edit>
    @endfor
</div>