@if(($invoices = Auth::user()->upcoming_invoices()->paginate(5)) && $invoices->count())
    <section class="invoices">
        <header class="intro-heading row">
            <div class="col-12 col-sm-8">
                <h2>{{ __('Upcoming Invoices') }}</h2>
            </div>

            <div class="col-12 col-sm-4 text-sm-right">
                <a class="link-primary" href="{{ route('paymets.invoice.list') }}">{{ __('See All') }}</a>
            </div>
        </header>

        <payment-invoices
            :initial_invoices="{{ $invoices->toJson() }}"
            detail_url="{{ route('paymets.invoice.view', ['id' => '__id__']) }}"
            :is_listing="false"
        ></payment-invoices>
    </section>
@endif