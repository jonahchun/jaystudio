@extends('layouts.app')

@section('content')
<section class="wedding">
    <header class="intro-heading row">
        <div class="col-12 col-md-6">
            <h2>Invoice List</h2>
        </div>

        {{--
        <div class="col-12 col-md-6">
            <nav class="filter-nav">
                <ul class="filter-nav__list">
                    <li class="is-active"><a href="">All</a></li>
                    <li><a href="">Contract Services</a></li>
                    <li><a href="">Additional Services</a></li>
                </ul>
            </nav>
        </div>
        --}}
    </header>
</section>

<section class="invoices">
    <payment-invoices
        :initial_invoices="{{ $invoices->toJson() }}"
        detail_url="{{ route('paymets.invoice.view', ['id' => '__id__']) }}"
        :is_listing="true"
    ></payment-invoices>
</section>
@endsection
