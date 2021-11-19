@extends('layouts.app')

@section('content')

    <photo-album-form
        :form_action="'{{ route('service.order-form.save', ['service' => $service]) }}'"
        :album_types="{{ json_encode(\App\Album\Model\Source\Type::getInstance()->getOptionsArray()) }}"
        :luxe_album_type="'{{ \App\Album\Model\Source\Type::LUXE_TYPE }}'"
        :acrylic_album_type="'{{ \App\Album\Model\Source\Type::ACRYLIC_TYPE }}'"
        :core_types="{{ \App\Album\Model\CoreType::orderBy('sort_order', 'asc')->get() }}"
        :luxe_types="{{ \App\Album\Model\LuxeType::orderBy('sort_order', 'asc')->get() }}"
        :leather_luxe_type_id="{{ \Settings::getConfigValue('photo_album/collection_' . \App\Album\Model\Source\Collection::GENUINE_LEATHER . '_id') }}"
        :vintage_luxe_type_id="{{ \Settings::getConfigValue('photo_album/collection_' . \App\Album\Model\Source\Collection::VINTAGE . '_id') }}"
        :black_mate_luxe_type_id="{{ \Settings::getConfigValue('photo_album/collection_' . \App\Album\Model\Source\Collection::BLACK_MATTE . '_id') }}"
        :art_deco_luxe_type_id="{{ \Settings::getConfigValue('photo_album/collection_' . \App\Album\Model\Source\Collection::ART_DECO . '_id') }}"
        :vintage_covers="{{ \App\Album\Model\VintageCover::orderBy('sort_order', 'asc')->get() }}"
        :black_matte_covers="{{ \App\Album\Model\BlackMatteCover::orderBy('sort_order', 'asc')->get() }}"
        :art_deco_colors="{{ \App\Album\Model\ArtDecoColor::orderBy('sort_order', 'asc')->get() }}"
        :art_deco_patterns="{{ \App\Album\Model\ArtDecoPattern::orderBy('sort_order', 'asc')->get() }}"
        :acrylic_sizes="{{ \App\Album\Model\Size::whereIn('id', explode(',', \Settings::getConfigValue('photo_album/acrylic_sizes')))->orderBy('sort_order', 'asc')->get() }}"
        :acrylic_images="{{ \App\Album\Model\AcrylicImage::orderBy('sort_order', 'asc')->get() }}"
        :directions="{{ json_encode([\Settings::getConfigValue('photo_album/directions')]) }}"
        :locations="{{ \App\Core\Model\PickupLocation::orderBy('sort_order', 'asc')->get() }}"
    ></photo-album-form>


@endsection
