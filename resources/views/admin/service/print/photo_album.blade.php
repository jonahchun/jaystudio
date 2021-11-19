@extends('admin.layouts.print')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-header-title">{{ __('Photo Album') }}</h4>
            </div>
            <div class="card-body">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>{{ __('Completion') }}</td>
                            <td>{{ $service->completion ? $service->completion->format('d F Y') : 'TDB' }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Core Type') }}</td>
                            <td>{{ $service->core_type->title }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Type') }}</td>
                            <td>{{ $service->luxe_type ? $service->luxe_type->title : \App\Album\Model\Source\Type::getInstance()->getOptionLabel($service->album_type) }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Size') }}</td>
                            <td>{{ $service->size ? $service->size->title : $service->other_size }}</td>
                        </tr>
                        @if($service->luxe_type)
                            @switch($service->luxe_type->id)
                                @case(\Settings::getConfigValue('photo_album/collection_genuine_leather_id'))
                                    <tr>
                                        <td>{{ __('Leather Text') }}</td>
                                        <td>{{ $service->leather_text }}</td>
                                    </tr>
                                    @break
                                @case(\Settings::getConfigValue('photo_album/collection_vintage_id'))
                                    <tr>
                                        <td>{{ __('Cover') }}</td>
                                        <td>{{ $service->vintage_cover->title }}</td>
                                    </tr>
                                    @break
                                @case(\Settings::getConfigValue('photo_album/collection_black_matte_id'))
                                    <tr>
                                        <td>{{ __('Cover') }}</td>
                                        <td>{{ $service->black_matte_cover->title }}</td>
                                    </tr>
                                    @break
                                @case(\Settings::getConfigValue('photo_album/collection_art_deco_id'))
                                    <tr>
                                        <td>{{ __('Color') }}</td>
                                        <td>{{ $service->art_deco_color->title }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('Pattern') }}</td>
                                        <td>{{ $service->art_deco_pattern->title }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('Cover Image') }}</td>
                                        <td>{{ $service->art_deco_cover_image }}</td>
                                    </tr>
                                    @break
                            @endswitch
                        @else
                        <tr>
                            <td>{{ __('Cover Image') }}</td>
                            <td>{{ $service->acrylic_cover_image }}</td>
                        </tr>
                        @endif
                        @if(is_array($service->images))
                        <tr>
                            <td>{{ __('Images') }}</td>
                            <td></td>
                        </tr>
                        @foreach($service->images as $index => $image)
                        <tr>
                            <td>{{ $index }}:</td>
                            <td>{{ $image ?: 'N/A' }}</td>
                        </tr>
                        @endforeach
                        @endif
                        <tr>
                            <td>{{ __('Comment') }}</td>
                            <td>{{ $service->comment }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection