@extends('admin.layouts.print')

@section('content')
@php
    $entities = \App\WeddingChecklist\Model\ChecklistEntities::getEntities();
    $value = $customer->wedding_checklist;
@endphp
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <h2 class="card-header-title">{{ __('Wedding Checklist') }}</h2>
        </div>
    </div>
</div>
@foreach(\App\WeddingChecklist\Model\Source\Steps::getInstance()->getOptions() as $_value => $label)
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-header-title">{{ $label }}</h4>
            </div>
            <div class="card-body">
            @if($_value == \App\WeddingChecklist\Model\Source\Steps::CINEMATOGRAPHY)
                <table class="table table-bordered">
                    <tr>
                        <td style="white-space:normal;width:50%;"><strong>{{ __('I want to have music picked by') }}</strong></td>
                        <td style="white-space:normal;width:50%;">
                            @switch($value->music)
                                @case(1)
                                    {{ __('JAYlim Studio') }}
                                    @break
                                @case(2)
                                    {{ __('Myself') }}
                                    @break
                            @endswitch
                        </td>
                    </tr>
                    <tr>
                        <td style="white-space:normal;width:50%;"><strong>{{ __('Song List') }}</strong></td>
                        <td style="white-space:normal;width:50%;"></td>
                    </tr>
                    @foreach($value->music_songs as $song)
                    <tr>
                        <td style="white-space:normal;width:50%;"><strong>{{ $song->song_name }}</strong></td>
                        <td style="white-space:normal;width:50%;">
                            @switch($song->type)
                                @case(1)
                                    {{ __('Highlight Reel') }}
                                    @break
                                @case(2)
                                    {{ __('Full Video') }}
                                    @break
                            @endswitch
                        </td>
                    </tr>
                    @endforeach
                </table>
            @elseif($_value !== \App\WeddingChecklist\Model\Source\Steps::VENDORS)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Yes / No</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entities[$_value] as $entity)
                        <tr>
                            <td style="white-space:normal;width:40%;"><strong>{{ $entity->title }}</strong></td>
                            <td style="white-space:normal;width:10%;">
                                @if(!empty($value[$_value][$entity->id]['value']))
                                    <h6 class="text-success">Yes</h6>
                                @else
                                    <h6 class="text-danger">No</h6>
                                @endif
                            </td>
                            <td style="white-space:normal">
                                {{ !empty($value[$_value][$entity->id]['details']) ? $value[$_value][$entity->id]['details'] : '' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="form-group">
                    <h4>Other Comments:</h4>
                    {{ !empty($value[$_value]['comment']) ? $value[$_value]['comment'] : '' }}
                </div>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Name / Company</th>
                            <th>Social Media Handle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entities['vendors'] as $vendor)
                        <tr>
                            <td style="white-space:normal;width:33%;"><strong>{{ $vendor->title }}</strong></td>
                            <td style="white-space:normal;width:33%;">
                                {{ !empty($value->vendors[$vendor->id]['company']) ? $value->vendors[$vendor->id]['company'] : '---' }}
                            </td>
                            <td style="white-space:normal;width:33%;">
                                {{ !empty($value->vendors[$vendor->id]['socials']) ? $value->vendors[$vendor->id]['socials'] : '---' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            </div>
        </div>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-header-title">{{ __('Additional Comment') }}</h4>
            </div>
            <div class="card-body">
                <div class="card-comment">
                    {{ $customer->wedding_checklist->comment }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
