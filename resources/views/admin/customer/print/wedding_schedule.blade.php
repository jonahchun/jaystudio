@extends('admin.layouts.print')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <h2 class="card-header-title">{{ __('Wedding Schedule') }}</h2>
        </div>
    </div>
</div>
@php
    $weddingSchedule = $customer->wedding_schedule
@endphp

@foreach(\App\WeddingSchedule\Model\Source\Steps::getInstance()->getOptions() as $_value => $label)
    @if($_value == 'preparation')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-header-title">{{ $customer->first_newlywed->first_name . '\'s Preparation' }}</h4>
                </div>
                <div class="card-body">
                    @include('admin.widget.form.field.wedding_schedule_parts.first_newlywed_' . $_value)
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                <h4 class="card-header-title">{{ $customer->second_newlywed->first_name . '\'s Preparation' }}</h4>
                </div>
                <div class="card-body">
                    @include('admin.widget.form.field.wedding_schedule_parts.second_newlywed_' . $_value)
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-header-title">{{ $label }}</h4>
                </div>
                <div class="card-body">
                    @include('admin.widget.form.field.wedding_schedule_parts.' . $_value)
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-header-title">{{ __('Additional Comment') }}</h4>
            </div>
            <div class="card-body">
                <div class="card-comment">
                    {{ $customer->wedding_schedule->comment }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
