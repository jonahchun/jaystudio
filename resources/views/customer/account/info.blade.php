@extends('layouts.app')

@section('content')

<form class="personal-info-form" action="{{ route('customer.update') }}" method="post" enctype="multipart/form-data" autocomplete="off">
    {{ csrf_field() }}
    <header class="intro-heading row">
        <div class="personal-info__tabs">
            <ul class="tabs justify-content-lg-end js-tabset">
                <li class="tabs__item active"><a class="tabs__link" href="#user-details">User Details</a></li>
                <li class="tabs__item"><a class="tabs__link" href="#billing-address">Billing address</a></li>
            </ul>
        </div>
    </header>

    <section class="personal-info" id="user-details">
        <h2 class="personal-info__block-title">{{ __('Personal Information') }}</h2>
        <div class="personal-info__blocks">
            @foreach(NewlywedType::getInstance()->getOptions() as $type => $label)
                <div class="personal-info__block">
                    <h4>{{ NewlywedPosition::getInstance()->getOptionLabel(Auth::user()->getNewlywedAttribute($type, 'bridegroom')) }}</h4>
                    <div class="user-ava js-newlywed-avatar">
                        <svg class="user-ava_icon icon icon-{{ Auth::user()->getNewlywedAttribute($type, 'bridegroom') }}">
                            <use xlink:href="#icon-{{ Auth::user()->getNewlywedAttribute($type, 'bridegroom') }}"></use>
                        </svg>
                        <div class="user-ava__input-wrap">
                            <svg class="icon icon-edit"><use xlink:href="#icon-edit"></use></svg>
                            <input name="{{ 'avatar_' . $type }}[file]" id="{{ 'imgInp' . $type }}" class="user-ava__input btn-edit js-newlywed-avatar-input" type="file" />
                        </div>
                        <img class="user-ava__img" src="{{ Auth::user()->{$type . '_newlywed'}->getAttributeUrl('avatar') }}" />
                        <input name="{{ 'avatar_' . $type }}" value="{{ Auth::user()->getNewlywedAttribute($type, 'avatar') }}" type="hidden" />
                    </div>
                    <div class="personal-info__inputs">
                        <div class="personal-info__input-wrap form-control-wrap js-input-wrap">
                            <label class="form-control-label js-form-label" for="{{ 'first_name_input_' . $type }}">{{ __('First Name') }}</label>
                            <input class="form-control js-form-input"
                                   type="text"
                                   id="{{ 'first_name_input_' . $type }}"
                                   autocomplete="off"
                                   name="{{ 'first_name_' . $type }}"
                                   value="{{ Auth::user()->getNewlywedAttribute($type, 'first_name') }}" />
                        </div>
                        <div class="personal-info__input-wrap form-control-wrap js-input-wrap">
                            <label class="form-control-label js-form-label" for="{{ 'last_name_input_' . $type }}">{{ __('Last Name') }}</label>
                            <input class="form-control js-form-input"
                                   type="text"
                                   id="{{ 'last_name_input_' . $type }}"
                                   autocomplete="off"
                                   name="{{ 'last_name_' . $type }}"
                                   value="{{ Auth::user()->getNewlywedAttribute($type, 'last_name') }}" />
                        </div>
                        <div class="personal-info__input-wrap form-control-wrap js-input-wrap">
                            <label class="form-control-label js-form-label" for="{{ 'email_input_' . $type }}">{{ __('Email address') }}</label>
                            <input class="form-control js-form-input"
                                   type="email"
                                   id="{{ 'email_input_' . $type }}"
                                   autocomplete="off"
                                   name="{{ 'email_' . $type }}"
                                   value="{{ Auth::user()->getNewlywedAttribute($type, 'email') }}" />
                        </div>
                        <div class="personal-info__input-wrap form-control-wrap js-input-wrap">
                            <label class="form-control-label js-form-label" for="{{ 'phone_input_' . $type }}">{{ __('Phone number') }}</label>
                            <input class="form-control js-form-input"
                                   type="tel"
                                   id="{{ 'phone_input_' . $type }}"
                                   autocomplete="new-password"
                                   name="{{ 'phone_' . $type }}"
                                   value="{{ Auth::user()->getNewlywedAttribute($type, 'phone') }}" />
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="personal-info__block">
                <h3 class="personal-info__block-title h2 mb-s">{{ __('Change password') }}</h3>
                <div class="personal-info__inputs">
                    <div class="personal-info__input-wrap form-control-wrap full-width js-input-wrap">
                        <label class="form-control-label js-form-label" for="current_password">{{ __('Current password') }}</label>
                        <input class="form-control js-form-input"
                               id="current_password"
                               name="current_password"
                               type="password"
                               autocomplete="new-password">
                    </div>
                    <div class="personal-info__input-wrap form-control-wrap js-input-wrap">
                        <label class="form-control-label js-form-label" for="new_password">{{ __('New password') }}</label>
                        <input class="form-control js-form-input"
                               id="new_password"
                               name="password"
                               type="password"
                               autocomplete="new-password">
                    </div>
                    <div class="personal-info__input-wrap form-control-wrap js-input-wrap">
                        <label class="form-control-label js-form-label" for="confirm_password">{{ __('Confirm password') }}</label>
                        <input class="form-control js-form-input"
                               id="confirm_password"
                               name="password_confirmation"
                               type="password"
                               autocomplete="new-password">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="personal-info" id="billing-address">
        <div class="personal-info__block full-width">
            <h2 class="personal-info__block-title">Billing Address</h2>
            <div class="personal-info__inputs">
                <div class="personal-info__input-wrap form-control-wrap js-input-wrap">
                    <label class="form-control-label js-form-label" for="address_line_1">{{ __('Address Line #1') }}</label>
                    <input class="form-control js-form-input"
                           type="text"
                           id="address_line_1"
                           name="address_line_1"
                           autocomplete="new-password"
                           value="{{ Auth::user()->billing_address->address_line_1 }}" />
                </div>
                <div class="personal-info__input-wrap form-control-wrap js-input-wrap">
                    <label class="form-control-label js-form-label" for="address_line_2">{{ __('Address Line #2') }}</label>
                    <input class="form-control js-form-input"
                           type="text"
                           id="address_line_2"
                           name="address_line_2"
                           autocomplete="new-password"
                           value="{{ Auth::user()->billing_address->address_line_2 }}" />
                </div>
                <div class="personal-info__input-wrap form-control-wrap js-input-wrap">
                    <label class="form-control-label js-form-label" for="state">{{ __('State / Province') }}</label>
                    <input class="form-control js-form-input"
                           type="text"
                           id="state"
                           name="state"
                           autocomplete="new-password"
                           value="{{ Auth::user()->billing_address->state }}" />
                </div>
                <div class="personal-info__input-wrap form-control-wrap js-input-wrap">
                    <label class="form-control-label js-form-label" for="city">{{ __('City') }}</label>
                    <input class="form-control js-form-input"
                           type="text"
                           id="city"
                           name="city"
                           autocomplete="new-password"
                           value="{{ Auth::user()->billing_address->city }}" />
                </div>
                <div class="personal-info__input-wrap form-control-wrap js-input-wrap">
                    <label class="form-control-label js-form-label" for="zip">{{ __('ZIP / Postcode') }}</label>
                    <input class="form-control js-form-input"
                           type="text"
                           id="zip"
                           name="zip"
                           autocomplete="new-password"
                           value="{{ Auth::user()->billing_address->zip }}" />
                </div>
            </div>
        </div>
    </section>
    
    <div class="personal-info__form-submit">
        <button class="btn-primary wide lowercase" type="submit">{{ __('Save') }}</button>
    </div>
</form>

@endsection
