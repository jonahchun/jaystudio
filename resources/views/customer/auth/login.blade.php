@extends('layouts.empty')

@section('content')

    <div class="auth">
        <div class="auth__inner">
            <a class="logo" href="{{ route('dashboard') }}">
                <img class="logo__img" src="{{ \Settings::getConfigValueUrl('app/logo') ?: asset('images/logo-big.svg') }}" alt="JAY LIM STUDIO">
            </a>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-header-title">{{ __('Login') }}</h4>
                </div>
                <div class="card-body">
                    <form class="js-validate" method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            <label for="account_id">{{ __('Account ID') }}</label>

                            <input id="account_id" type="text" class="form-control-bordered @error('account_id') is-invalid @enderror" name="account_id" value="{{ old('account_id') }}" required autocomplete="account_id" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">{{ __('Password') }}</label>

                            <input id="password" type="password" class="form-control-bordered @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="d-flex align-items-center">
                                <input class="form-check-input bordered" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                        <div class="form-group-actions">
                                <button type="submit" class="btn btn-block btn-primary btn-login">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="link-primary" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
