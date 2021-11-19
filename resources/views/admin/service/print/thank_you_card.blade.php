@extends('admin.layouts.print')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-header-title">{{ __('Thank You Card') }}</h4>
            </div>
            <div class="card-body">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>{{ __('Completion') }}</td>
                            <td>{{ $service->completion ? $service->completion->format('d F Y') : 'TDB' }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Layout Type') }}</td>
                            <td>{{ \App\Card\Model\Source\LayoutType::getInstance()->getOptionLabel($service->layout_type) }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Message') }}</td>
                            <td>{{ $service->message }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Size') }}</td>
                            <td>{{ $service->size ? $service->size->title : $service->other_size }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Format') }}</td>
                            <td>{{ \App\Card\Model\Source\Format::getInstance()->getOptionLabel($service->format) }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Magnet') }}</td>
                            <td>{{ \App\Core\Model\Source\Yesno::getInstance()->getOptionLabel($service->is_magnet) }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Cards Amount') }}</td>
                            <td>{{ $service->cards_amount }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Front Side Template') }}</td>
                            <td>{{ $service->front_side_template->title }}</td>
                        </tr>
                        @if(is_array($service->front_side_images))
                        <tr>
                            <td>{{ __('Front Side Images') }}</td>
                            <td>
                            @foreach($service->front_side_images as $index => $image)
                                <p>{{ $index }}: {{ $image ?: 'N/A' }}</p>
                            @endforeach
                            </td>
                        </tr>
                        @endif
                        @if($service->inside_template && is_array($service->inside_images))
                        <tr>
                            <td>{{ __('Inside Template') }}</td>
                            <td>{{ $service->inside_template->title }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Inside Images') }}</td>
                            <td>
                            @foreach($service->inside_images as $index => $image)
                                <p>{{ $index }}: {{ $image ?: 'N/A' }}</p>
                            @endforeach
                            </td>
                        </tr>
                        @endif
                        @if($service->back_side_template && is_array($service->back_side_images))
                        <tr>
                            <td>{{ __('Back Side Template') }}</td>
                            <td>{{ $service->back_side_template->title }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Back Side Images') }}</td>
                            <td>
                            @foreach($service->back_side_images as $index => $image)
                                <p>{{ $index }}: {{ $image ?: 'N/A' }}</p>
                            @endforeach
                            </td>
                        </tr>
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