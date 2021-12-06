@if($form->getInstance()->id)
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                @includeIf('admin::widget.button', [
                    'jsaction' => 'setLocation("' . route('admin.customer.service.create', ['customer' => $form->getInstance()->id]) . '")', 
                    'label'    => 'Add new',
                    'route'    => 'admin.customer.service.create'
                ])     
                @includeIf('admin::widget.button', [
                    'jsaction' => 'setLocation("' . route('admin.customer.service.servicecreate', ['customer' => $form->getInstance()->id]) . '")', 
                    'label'    => 'Manage Service',
                    'route'    => 'admin.customer.service.servicecreate'
                ])      
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="align-top"><strong>Type</strong></th>
                            <th class="align-top"><strong>Status</strong></th>
                            <th class="align-top" width="10%"><strong>Actions</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($value as $service)
                        <tr>
                            <td>{{ \App\Services\Model\Source\Type::getInstance()->getOptionLabel($service->type) }}</td>
                            <td>{{ \App\Services\Model\Source\Status::getInstance()->getOptionLabel($service->status) }}</td>
                            <td>
                                @includeIf('admin::widget.button', [
                                    'jsaction' => 'setLocation("' . route('admin.customer.service.edit', ['id' => $service->id]) . '")',
                                    'label'    => 'Edit',
                                    'class'    => 'success',
                                    'route'    => 'admin.customer.service.edit',
                                ])
                                @includeIf('admin::widget.button', [
                                    'jsaction' => 'confirmSetLocation("' . route('admin.customer.service.delete', ['id' => $service->id]) . '")',
                                    'label'    => 'Delete',
                                    'class'    => 'danger',
                                    'route'    => 'admin.customer.service.delete',
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