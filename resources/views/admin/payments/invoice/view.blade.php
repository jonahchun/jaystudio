@extends('admin::layouts.app')

@section('content')
<div class="container-fluid form">
    <div class="row pt-2 pb-2">
        <div class="col-sm-12">
            <div class="btn-group float-sm-right">
                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="setLocation('{{ route('admin.paypal.invoices') }}')">
                    <i class="fa fa-arrow-circle-o-left"></i>
                    <span>Back</span>
                </button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-uppercase">{{ __('Invoice Detail') }}</div>
                <div class="card-body">
                    <form>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ __('Customer Account') }}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{ $invoice->customer->account_id }}" disabled="disabled" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ __('Customer Email') }}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{ $invoice->customer->email }}" disabled="disabled" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ __('Invoice ID') }}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{ $invoice->invoice_id }}" disabled="disabled" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ __('Invoice PayPal ID') }}</label>
                            <div class="col-sm-9">
                                <a href="{{ $invoice->invoice_url }}" target="_blank">{{ $invoice->paypal_invoice_id }}</a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ __('Amount') }}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="${{ number_format($invoice->amount, 2) }}" disabled="disabled" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ __('Status') }}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{ $invoice->status }}" disabled="disabled" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection