@extends('layouts.empty')

@section('content')
    <div class="maintenance-page">
        <a class="maintenance-page__logo" href="{{ route('dashboard') }}">
            <img class="logo__img" src="{{ \Settings::getConfigValueUrl('app/logo') ?: asset('images/logo-big.svg') }}" alt="JAY LIM STUDIO">
        </a>
        <div class="maintenance-page__inner">
            <h1 class="maintenance-page__title"><span>{{ __("Welcome to") }}</span>{{ __("Jay Lim Studio") }}</h1>
            <p class="maintenance-page__subtitle">{{ __("Our website is undergoing scheduled maintenance at the moment. We will be back soon.") }}</p>
        </div>
    </div>
@endsection
