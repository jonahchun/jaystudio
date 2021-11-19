@extends('layouts.empty')

@section('content')
    <div class="auth">
        <div class="auth__inner">
            <a class="logo" href="{{ route('dashboard') }}">
                <img class="logo__img" src="{{ \Settings::getConfigValueUrl('app/logo') ?: asset('images/logo-big.svg') }}" alt="JAY LIM STUDIO">
            </a>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-header-title">{{ __('Complete Profile') }}</h4>
                </div>

                <div class="card-body">
                    <form class="js-validate" method="POST" action="{{ route('customer.complete.profile.save') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}" />

                        <div class="form-group">
                            <label for="account_id">{{ __('Account ID') }}</label>
                            <input id="account_id" type="text" class="form-control-bordered" value="{{ $customer->account_id }}" disabled="disabled" />
                        </div>

                        <div class="form-group">
                            <label for="password">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control-bordered @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group ">
                            <label for="password-confirm">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control-bordered" name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="form-group-actions">
                            <button type="submit" class="btn btn-block btn-primary">
                                {{ __('Complete') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
