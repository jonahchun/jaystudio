@include('customer.account.wedding_info')

<div class="row mb-3">
    <div class="col-sm-8">
        <h2>@yield('edit_request_title')</h2>
    </div>
    <div class="col-sm-4 text-sm-right">
        <a class="btn-primary" href="{{ route('service.view', ['service' => $edit_request->service]) }}">{{ __('Back to Service') }}</a>
    </div>
</div>

<div class="danger-panel col-xl-5 {{ strtolower(str_replace(' ', '-', $edit_request->status_label)) }}">
    <svg class="icon icon-warning"><use xlink:href="#icon-warning"></use></svg>
    <p>{{ $edit_request->status_label }}</p>
</div>