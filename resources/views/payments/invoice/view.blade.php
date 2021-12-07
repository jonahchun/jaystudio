@extends('layouts.app')

@section('content')
<section class="invoices-detail">
    <header class="intro-heading row align-items-baseline">
        <h2 class="invoices-detail__title">{{ __('Invoice Detail') }}</h2>
        <button class="btn-primary print" onclick="javascript:window.print()">Print</button>
    </header>
    <div class="invoices-detail__info">
        <div class="invoices-detail__info-block">
            <a class="invoices-detail__info-logo" href="{{ route('paymets.invoice.list') }}">
                <img class="logo__img print" src="{{ \Settings::getConfigValueUrl('app/logo') ?: asset('images/logo-big.svg') }}" alt="JAY LIM STUDIO">
            </a>
            <p class="invoices-detail__info-item highlighted">
                {{ Settings::getConfigValue(\App\Payments\Model\PayPal\Api::PAYPAL_BUSINESS_NAME_PATH) }}
            </p>
            <p class="invoices-detail__info-item">
                {{ Settings::getConfigValue(\App\Payments\Model\PayPal\Api::PAYPAL_FIRST_NAME_PATH) }} 
                {{ Settings::getConfigValue(\App\Payments\Model\PayPal\Api::PAYPAL_LAST_NAME_PATH) }}
            </p>
            <p class="invoices-detail__info-item">
                {{ Settings::getConfigValue(\App\Payments\Model\PayPal\Api::PAYPAL_ADDRESS_LINE_1_PATH) }}
            </p>
            @if($addressLine2 = Settings::getConfigValue(\App\Payments\Model\PayPal\Api::PAYPAL_ADDRESS_LINE_2_PATH))
            <p class="invoices-detail__info-item">{{ $addressLine2 }}</p>
            @endif
            <p class="invoices-detail__info-item">
                {{ Settings::getConfigValue(\App\Payments\Model\PayPal\Api::PAYPAL_CITY_PATH) }},
                {{ Settings::getConfigValue(\App\Payments\Model\PayPal\Api::PAYPAL_STATE_PATH) }},
                {{ Settings::getConfigValue(\App\Payments\Model\PayPal\Api::PAYPAL_POSTAL_CODE_PATH) }}
            </p>
            @if(($phone = Settings::getConfigValue(\App\Payments\Model\PayPal\Api::PAYPAL_PHONE_NUMBER_PATH))
                && ($phoneCountryCode = Settings::getConfigValue(\App\Payments\Model\PayPal\Api::PAYPAL_PHONE_COUNTRY_CODE_PATH)))
            <p class="invoices-detail__info-item">{{ $phoneCountryCode . ' ' . $phone }}</p>
            @endif
            @if($email = Settings::getConfigValue(\App\Payments\Model\PayPal\Api::PAYPAL_MERCHANT_EMAIL_PATH))
            <a class="invoices-detail__info-link link-primary" href="mailto:{{ $email }}">{{ $email }}</a>
            @endif
        </div>
        <div class="invoices-detail__info-block j-end">
            <h3 class="invoices-detail__subtitle">{{ __('Invoice:') }}</h3>
            <div class="invoices-detail__info-item">
                <span class="invoices-detail__info-item-title">{{ __('Invoice #:') }}</span>
                <span class="invoices-detail__info-item-value">{{ $invoice->invoice_id }}</span>
            </div>
            <div class="invoices-detail__info-item">
                <span class="invoices-detail__info-item-title">{{ __('Invoice date:') }}</span>
                <span class="invoices-detail__info-item-value">{{ $invoice->created_at->format('M d, Y') }}</span>
            </div>
            <div class="invoices-detail__info-item">
                <span class="invoices-detail__info-item-title">{{ __('Due date:') }}</span>
                <span class="invoices-detail__info-item-value">{{ $invoice->due_date->format('M d, Y') }}</span>
            </div>
            <div class="invoices-detail__info-due">
                <span class="invoices-detail__info-due-title">{{ __('Amount due:') }}</span>
                <span class="invoices-detail__info-due-value">${{ number_format($invoice->due_amount, 2) }}</span>
            </div>
        </div>
        <div class="invoices-detail__info-block">
            <h3 class="invoices-detail__subtitle">{{ __('Bill to:') }}</h3>
            <p class="invoices-detail__info-item">
                {{ $invoice->payer->first_name }} {{ $invoice->payer->last_name }}
            </p>
            <p class="invoices-detail__info-item">+1 {{ $invoice->payer->phone }}</p>
            <a class="invoices-detail__info-link link-primary" href="mailto:{{ $invoice->payer->email }}">{{ $invoice->payer->email }}</a>
        </div>
    </div>
    <div class="invoices-detail__table">
        <div class="table-responsive">
            <table class="info-table">
                <colgroup>
                    <col style="width: 48%;">
                    <col style="width: 15%;">
                    <col style="width: 20%;">
                    <col style="width: 17%;">
                </colgroup>
                <thead>
                <tr>
                    <td>{{ __('Description') }}</td>
                    <td>{{ __('Quantity') }}</td>
                    <td>{{ __('Price') }}</td>
                    <td>{{ __('Amount') }}</td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $invoice->item_description }}</td>
                    <td>1</td>
                    <td>${{ $invoice->amount }}</td>
                    <td>${{ $invoice->amount }}</td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td></td><td></td><td class="title">{{ __('Subtotal:') }}</td><td>${{ $invoice->amount }}</td>
                </tr>
                <!-- <tr>
                    <td></td><td></td><td class="title">{{ __('Tax:') }}</td><td>${{ $invoice->tax_amount }}</td>
                </tr> -->
                <tr>
                    <td></td><td></td><td class="title">{{ __('Total:') }}</td><td>${{ $invoice->total }}</td>
                </tr>
                <tr>
                    <td></td><td></td><td class="title">{{ __('Amount Paid:') }}</td><td>-${{ $invoice->paid_amount }}</td>
                </tr>
                <tr class="highlighted">
                    <td></td><td></td><td class="title">{{ __('Amount Due:') }}</td><td>${{ $invoice->due_amount }} USD</td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</section>
@endsection
