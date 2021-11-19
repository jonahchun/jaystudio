<div class="col-lg-8">
    <div class="card bg-dark">
        <div class="card-header bg-transparent text-white border-0">
            {{ __('Recent Invoices') }}
            <div class="card-action">
                <a class="btn btn-light mb-2" href="{{ route('admin.payments.invoices') }}">{{ __('View All') }}</a>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                    <thead>
                        <tr>
                            <th>{{ __('Invoice ID') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Amount') }}</th>
                            <th>{{ __('Due Date') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach(\App\Payments\Helper\Data::getRecentInvoices() as $invoice)
                        <tr>
                            <td>{{ $invoice->invoice_id}}</td>
                            <td>{{ \App\Payments\Model\Source\Type::getInstance()->getOptionLabel($invoice->type) }}</td>
                            <td>{{ __('$:amount ($:tax_amount TAX)', ['amount' => number_format($invoice->amount, 2), 'tax_amount' => number_format($invoice->tax_amount, 2)]) }}</td>
                            <td>{{ $invoice->due_date->format('d F Y') }}</td>
                            <td>
                                <span class="badge @if($invoice->status == \App\Payments\Model\Source\Status::OVERDUE) bg-danger @else bg-warning @endif text-white">
                                    {{ \App\Payments\Model\Source\Status::getInstance()->getOptionLabel($invoice->status) }}
                                </span>
                            </td>
                            <td><a class="btn btn-light btn-sm" href="{{ route('admin.payments.invoices.edit', ['id' => $invoice->id]) }}">{{ __('Edit') }}</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>