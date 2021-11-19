<?php
namespace App\Services\Model\Service;

class PhotoAlbumDetail extends PhotoDetail
{

    const MEDIA_PATH = 'service' . DIRECTORY_SEPARATOR . 'photo-album' . DIRECTORY_SEPARATOR;

    const TYPE = \App\Services\Model\Source\Type::PHOTO_ALBUM;

    protected $fillable = [
        'service_id', 'album_type', 'core_type_id', 'luxe_type_id',
        'size_id', 'other_size', 'vintage_cover_id', 'black_matte_cover_id',
        'art_deco_color_id', 'art_deco_pattern_id', 'leather_text',
        'art_deco_cover_image', 'acrylic_cover_image', 'images',
        'delivery_location_id', 'comment', 'file', 'completion'
    ];

    protected $casts = [
        'images' => 'array',
    ];

    protected $mediaFields = ['file'];

    public function size()
    {
        return $this->belongsTo(\App\Album\Model\Size::class);
    }

    public function core_type()
    {
        return $this->belongsTo(\App\Album\Model\CoreType::class);
    }

    public function luxe_type()
    {
        return $this->belongsTo(\App\Album\Model\LuxeType::class);
    }

    public function vintage_cover()
    {
        return $this->belongsTo(\App\Album\Model\VintageCover::class);
    }

    public function black_matte_cover()
    {
        return $this->belongsTo(\App\Album\Model\BlackMatteCover::class);
    }

    public function art_deco_color()
    {
        return $this->belongsTo(\App\Album\Model\ArtDecoColor::class);
    }

    public function art_deco_pattern()
    {
        return $this->belongsTo(\App\Album\Model\ArtDecoPattern::class);
    }

}