@if($form->getInstance()->id)
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                @includeIf('admin::widget.button', [
                    'jsaction' => 'setLocation("' . route('admin.payments.invoices.new', ['customer' => $form->getInstance()->id]) . '")', 
                    'label'    => 'Add new',
                    'route'    => 'admin.payments.invoices.new'
                ])        
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="align-top"><strong>Type</strong></th>
                            <th class="align-top"><strong>Invoice ID</strong></th>
                            <th class="align-top"><strong>Amount</strong></th>
                            <th class="align-top"><strong>Due Date</strong></th>
                            <th class="align-top"><strong>Status</strong></th>
                            <th class="align-top" width="10%"><strong>Actions</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($value as $invoice)
                        <tr>
                            <td>{{ \App\Payments\Model\Source\Type::getInstance()->getOptionLabel($invoice->type) }}</td>
                            <td>{{ $invoice->invoice_id }}</td>
                            <td>${{ $invoice->amount }}</td>
                            <td>{{ $invoice->due_date->format('d M Y') }}</td>
                            
                            <td>{{ \App\Payments\Model\Source\Status::getInstance()->getOptionLabel($invoice->status) }}</td>
                            <td>
                                @includeIf('admin::widget.button', [
                                    'jsaction' => 'setLocation("' . route('admin.payments.invoices.edit', ['id' => $invoice->id]) . '")',
                                    'label'    => 'Edit',
                                    'class'    => 'success',
                                    'route'    => 'admin.payments.invoices.edit',
                                ])
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif