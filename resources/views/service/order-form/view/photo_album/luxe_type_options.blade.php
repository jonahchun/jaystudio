<div class="info-column__item">
    <h3 class="info-column__title narrow">{{ __('Album Collection') }}</h3>
    <p class="info-column__value">{{ $service->luxe_type->title }}</p>
</div>
@includeWhen(Settings::getConfigValue('photo_album/collection_genuine_leather_id') == $service->luxe_type_id, 'service.order-form.view.photo_album.luxe.leather')
@includeWhen(Settings::getConfigValue('photo_album/collection_vintage_id') == $service->luxe_type_id, 'service.order-form.view.photo_album.luxe.vintage')
@includeWhen(Settings::getConfigValue('photo_album/collection_black_matte_id') == $service->luxe_type_id, 'service.order-form.view.photo_album.luxe.black_matte')
@includeWhen(Settings::getConfigValue('photo_album/collection_art_deco_id') == $service->luxe_type_id, 'service.order-form.view.photo_album.luxe.art_deco')