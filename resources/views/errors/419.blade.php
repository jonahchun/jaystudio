@extends((Auth::check()) ? 'layouts.app' :'layouts.empty')

@section('content')
    <div class="not-found">
        @if(!Auth::check())
        <a class="not-found__logo" href="{{ route('dashboard') }}">
            <img class="logo__img" src="{{ \Settings::getConfigValueUrl('app/logo') ?: asset('images/logo-big.svg') }}" alt="JAY LIM STUDIO">
        </a>
        @endif
        <div class="not-found__inner">
            <h1 class="not-found__title">{{ __('Oops!') }}</h1>
            <p class="not-found__subtitle">{{ __('Your session has been expired') }}</p>
            <a class="not-found__link btn btn-primary wide" href="{{ url('/') }}">{{ __('Get home') }}</a>
        </div>
    </div>
@endsection
