@extends('layouts.app')

@section('content')

<section class="wedding">
    <header class="intro-heading row">
        <div class="col-sm-8">
            <h2>Wedding Information</h2>
            <p>{{ \Settings::getConfigValue('wedding_info/description') }}</p>
        </div>
        <div class="col-sm-4 text-sm-right">Deadline: {{ Auth::user()->wedding_date->subWeek()->format('F jS') }}</div>
    </header>
</section>

<div class="row">
    <div class="col-sm-4 col-md-6 col-lg-4">
        <div class="service-card text-center">
            <svg class="service-card__icon icon icon-calendar-2"><use xlink:href="#icon-calendar-2"></use></svg>
            <h3 class="service-card__ttl">{{ __('Wedding Schedule') }}</h3>
            <p>{{ \Settings::getConfigValue('wedding_info/schedule_description') }}</p>
            <a class="btn-primary lowercase" href="{{ route('customer.wedding.schedule') }}">
                {{ Auth::user()->wedding_schedule ? 'Edit' : 'Start' }}
            </a>
        </div>
    </div>

    <div class="col-sm-4 col-md-6 col-lg-4">
        <div class="service-card text-center">
            <svg class="service-card__icon icon icon-checklist"><use xlink:href="#icon-checklist"></use></svg>
            <h3 class="service-card__ttl">{{ __('Wedding Checklist') }}</h3>
            <p>{{ \Settings::getConfigValue('wedding_info/checklist_description') }}</p>
            <a class="btn-primary lowercase" href="{{ route('customer.wedding.checklist') }}">
                {{ Auth::user()->wedding_checklist ? 'Edit' : 'Start' }}
            </a>
        </div>
    </div>

    <div class="col-sm-4 col-md-6 col-lg-4">
        <div class="service-card text-center">
            <svg class="service-card__icon icon icon-two-men"><use xlink:href="#icon-two-men"></use></svg>
            <h3 class="service-card__ttl">{{ __('Details About You') }}</h3>
            <p>{{ \Settings::getConfigValue('wedding_info/personal_details_description') }}</p>
            <a class="btn-primary lowercase" href="{{ route('customer.details.form') }}">
                {{ Auth::user()->newlywed_detail ? 'Edit' : 'Start' }}
            </a>
        </div>
    </div>
</div>

@endsection
