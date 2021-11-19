<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                @includeIf('admin::widget.button', [
                    'jsaction' => 'setLocation("' . route('admin.customer.service.uploads.create', ['service' => $form->getInstance()->id]) . '")', 
                    'label'    => 'Add new',
                    'route'    => 'admin.customer.service.uploads.create',
                ])        
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="align-top"><strong>{{ __('Date') }}</strong></th>    
                            <th class="align-top"><strong>{{ __('File') }}</strong></th>
                            <th class="align-top"><strong>{{ __('Status') }}</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($value as $upload)
                        <tr>
                            <td>{{ $upload->created_at->format('d M Y') }}</td>
                            <td><a href="{{ $upload->file_url }}" target="_blank">{{ $upload->file_title }}</a></td>
                            <td>{{ $upload->status_label }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>