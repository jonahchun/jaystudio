<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="align-top"><strong>{{ __('Date') }}</strong></th>    
                            <th class="align-top"><strong>{{ __('Status') }}</strong></th>
                            <th class="align-top"><strong>{{ __('Comment') }}</strong></th>
                            <th class="align-top"><strong>{{ __('Actions') }}</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($value as $request)
                        <tr>
                            <td>{{ $request->created_at->format('d M Y') }}</td>
                            <td>{{ $request->status_label }}</td>
                            <td>{{ $request->comment }}</td>
                            <td>
                                @includeIf('admin::widget.button', [
                                    'jsaction' => 'setLocation("' . route('admin.customer.service.edit_request.edit', ['id' => $request->id]) . '")',
                                    'label'    => 'View',
                                    'class'    => 'success',
                                    'type'     => 'edit',
                                    'route'    => 'admin.customer.service.edit_request.edit',
                                ])
                                @includeIf('admin::widget.button', [
                                    'jsaction' => 'window.open("' . route('admin.customer.service.edit_request.print', ['id' => $request->id]) . '")',
                                    'label'    => 'Print',
                                    'route'    => 'admin.customer.service.edit_request.print',
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