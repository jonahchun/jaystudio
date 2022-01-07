@extends('admin::layouts.app')
<style type="text/css">
    .link-primary {
      position: relative;
      text-transform: uppercase;
      color: #e1bd9e;
    }

    .link-primary:after {
      position: absolute;
      content: '';
      bottom: 0;
      left: 0;
      width: 100%;
      height: 1px;
      background-color: #e1bd9e;
      -webkit-transform: translate(0, -5px);
              transform: translate(0, -5px);
      opacity: 0;
      -webkit-transition: .3s ease;
      transition: .3s ease;
    }

    .link-primary:hover {
      color: #e1bd9e;
    }

    .link-primary:hover:after {
      -webkit-transform: translate(0, -2px);
              transform: translate(0, -2px);
      opacity: 1;
      -webkit-transition: .3s ease;
      transition: .3s ease;
    }

    .link-primary .ajax-loader {
      position: absolute;
      top: 50%;
      -webkit-transform: translate(0, -50%);
      transform: translate(0, -50%);
      left: 105%;
    }
    .invoices-detail__title {
      margin: 0 25px 30px 15px;
    }
    .invoices-detail{
        margin-left: 10px;
    }
    .invoices-detail__info {
      display: -webkit-box;
      display: flex;
      flex-wrap: wrap;
      max-width: 1400px;
    }

    .invoices-detail__info-block {
      display: -webkit-box;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
              flex-direction: column;
      -webkit-box-align: start;
              align-items: flex-start;
      width: 100%;
      margin-bottom: 30px;
    }

    @media (min-width: 576px) {
      .invoices-detail__info-block {
        width: 50%;
        margin-bottom: 50px;
      }
    }

    @media (min-width: 576px) and (min-width: 576px) and (max-width: 1439px) {
      .invoices-detail__info-block.j-end {
        -webkit-box-pack: end;
                justify-content: flex-end;
      }
    }

    @media (min-width: 1440px) {
      .invoices-detail__info-block {
        width: calc(25% - 19px);
      }

      .invoices-detail__info-block:not(:last-child) {
        margin-right: 25px;
      }
    }

    .invoices-detail__info-logo {
      max-width: 90px;
      margin-bottom: 15px;
    }

    .invoices-detail__info-due {
      display: -webkit-box;
      display: flex;
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
              flex-direction: column;
      -webkit-box-align: center;
              align-items: center;
      background-color: #FFF;
      width: 170px;
      border-radius: 5px;
      padding: 15px;
      margin-top: 20px;
    }

    @media (max-width: 575px) {
      .invoices-detail__info-due {
        margin-bottom: 25px;
      }
    }

    .invoices-detail__info-due-title {
      font-weight: 700;
    }

    .invoices-detail__info-due-value {
      font-weight: 700;
      font-size: 21px;
      color: #393939;
    }

    .invoices-detail__info-item {
      margin: 0;
    }

    .invoices-detail__info-item.highlighted {
      font-weight: bold;
      color: #393939;
    }

    .invoices-detail__info-item-title {
      font-weight: 700;
      color: #393939;
    }

    .invoices-detail__info-link {
      text-transform: none;
      margin-top: 15px;
    }

    .invoices-detail__table {
      width: 100%;
    }
    @media print {
      #sidebar-wrapper,
      .footer,
      .topbar-nav {
        position: absolute;
        display: none;
        width: 0;
        height: 0;
        opacity: 0;
      }

      .content-wrapper{
        margin-left: 0px !important;
      }

      .invoices-detail .btn-primary.print,
      .invoices-detail .print.btn-primary-inverted,
      .invoices-detail .print.btn-default,
      .invoices-detail .print.btn-default--alt,
      .invoices-detail .print.btn-submit {
        display: none;
      }

      .invoices-detail .invoices-detail__info-due {
        background-color: #f3e5da !important;
        -webkit-print-color-adjust: exact;
      }

      .invoices-detail .invoices-detail__info-link {
        color: #393939;
        text-decoration: none;
        background-color: transparent !important;
        -webkit-print-color-adjust: exact;
      }

      .invoices-detail .info-table thead td {
        background-color: #f3e5da !important;
        -webkit-print-color-adjust: exact;
      }

      .invoices-detail .info-table tbody td {
        border-bottom: 1px solid #dee2e6;
      }

      .invoices-detail .info-table tbody td:first-child {
        border-left: 1px solid #dee2e6;
      }

      .invoices-detail .info-table tbody td:last-child {
        border-right: 1px solid #dee2e6;
      }

      .invoices-detail .info-table tfoot tr:first-child td {
        border-top: 1px solid #dee2e6;
      }

      .invoices-detail .info-table tfoot tr.highlighted td:not(:empty) {
        background-color: #f3e5da !important;
        -webkit-print-color-adjust: exact;
      }

      .invoices-detail .info-table tfoot td {
        border-bottom: 1px solid #dee2e6;
      }

      .invoices-detail .info-table tfoot td:first-child {
        border-left: 1px solid #dee2e6;
      }

      .invoices-detail .info-table tfoot td:last-child {
        border-right: 1px solid #dee2e6;
      }

      .invoices-detail .info-table tfoot td.title {
        border-left: 1px solid #dee2e6;
      }
    }


    .info-table {
      border-spacing: 0 1px;
      border-collapse: separate;
      width: 100%;
      min-width: 760px;
    }

    .info-table--rounded {
      border-spacing: 0 10px;
    }

    .info-table.info-table--rounded td:first-child,
    .info-table.info-table--rounded th:first-child {
      border-radius: 5px 0 0 5px !important;
    }

    .info-table.info-table--rounded td:last-child,
    .info-table.info-table--rounded th:last-child {
      border-radius: 0 5px 5px 0 !important;
    }

    .info-table thead td,
    .info-table thead th {
      background-color: #fff;
      padding-top: 38px;
      padding-bottom: 28px;
      padding-left: 15px;
      font-weight: 700;
      color: #393939;
      text-align: left;
      border-bottom: 3px solid #f4f4f4;
    }

    .info-table thead td:first-child,
    .info-table thead th:first-child {
      border-radius: 5px 0 0 8px;
      padding-left: 28px;
    }

    @media (min-width: 1200px) {
      .info-table thead td:first-child,
      .info-table thead th:first-child {
        padding-left: 48px;
      }
    }

    .info-table thead td:last-child,
    .info-table thead th:last-child {
      border-radius: 0 5px 8px 0;
    }

    .services .info-table thead td,
    .services .info-table thead th {
      border-bottom: 0;
    }

    .info-table tbody tr:first-child td:first-child {
      border-radius: 5px 0 0 0;
    }

    .info-table tbody tr:first-child td:last-child {
      border-radius: 0 5px 0 0;
    }

    .info-table tbody tr:last-child td:first-child {
      border-radius: 0 0 0 5px;
    }

    .info-table tbody tr:last-child td:last-child {
      border-radius: 0 0 5px 0;
    }

    .info-table tbody td,
    .info-table tbody th {
      background-color: #fff;
      padding-top: 21px;
      padding-bottom: 21px;
      padding-left: 15px;
      color: #393939;
      text-align: left;
    }

    .info-table tbody td:first-child,
    .info-table tbody th:first-child {
      padding-left: 28px;
    }

    @media (min-width: 1200px) {
      .info-table tbody td:first-child,
      .info-table tbody th:first-child {
        padding-left: 48px;
      }
    }

    .info-table tbody td:last-child,
    .info-table tbody th:last-child {
      padding-right: 30px;
    }

    .info-table .icon {
      display: inline-block;
      vertical-align: middle;
    }

    .info-table .icon-cash {
      width: 36px;
      height: 21px;
    }

    .info-table .icon-card {
      width: 36px;
      height: 29px;
    }

    .info-table .paid .icon-cash {
      color: #e1bd9e;
    }

    .info-table .paid .icon-check-circle {
      display: inline-block;
      margin-right: 10px;
      color: #7ae592;
    }

    .info-table .label-due {
      color: #ffc826;
    }

    .info-table .label-paid {
      color: #7ae592;
    }

    .info-table .label-overdue {
      color: #fb434c;
    }

    .info-table .danger-panel,
    .info-table .warning-panel {
      max-width: 240px;
      margin-left: auto;
      margin-right: auto;
      padding-left: 0;
      padding-right: 0;
      font-size: 12px;
      -webkit-box-align: center;
              align-items: center;
    }

    .info-table tfoot:before {
      display: block;
      content: '';
      opacity: 0;
      height: 2px;
    }

    .info-table tfoot tr:first-child td:empty + td:not(:empty) {
      border-radius: 5px 0 0 0;
    }

    .info-table tfoot tr:first-child td:last-child {
      border-radius: 0 5px 0 0;
    }

    .info-table tfoot tr:last-child td:empty + td:not(:empty) {
      border-radius: 0 0 0 5px;
    }

    .info-table tfoot tr:last-child td:last-child {
      border-radius: 0 0 5px 0;
    }

    .info-table tfoot tr.highlighted td {
      background-color: #f3e5da;
    }

    .info-table tfoot td,
    .info-table tfoot th {
      background-color: #fff;
      padding-top: 21px;
      padding-bottom: 21px;
      padding-left: 15px;
      color: #393939;
      text-align: left;
    }

    .info-table tfoot td:first-child,
    .info-table tfoot th:first-child {
      padding-left: 28px;
    }

    @media (min-width: 1200px) {
      .info-table tfoot td:first-child,
      .info-table tfoot th:first-child {
        padding-left: 48px;
      }
    }

    .info-table tfoot td:last-child,
    .info-table tfoot th:last-child {
      padding-right: 30px;
    }

    .info-table tfoot td:empty {
      opacity: 0;
    }

    .info-table tfoot td.title {
      font-weight: 700;
    }

</style>
@section('content')
<section class="invoices-detail">
    <header class="intro-heading row align-items-baseline">
        <h2 class="invoices-detail__title">{{ __('Invoice Detail') }}</h2>
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
<script type="text/javascript">
    window.print();
</script>
