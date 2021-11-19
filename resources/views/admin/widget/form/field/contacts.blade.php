@if($form->getInstance()->id)
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                @includeIf('admin::widget.button', [
                    'jsaction' => 'window.open("' . route('admin.customer.print.contacts', ['customer' => $form->getInstance()->id]) . '")', 
                    'label'    => 'Print',
                    'route'    => 'admin.customer.print.contacts',
                ])        
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="align-top"><strong>Photo</strong></th>
                            <th class="align-top"><strong>First Name</strong></th>
                            <th class="align-top"><strong>Last Name</strong></th>
                            <th class="align-top"><strong>Email</strong></th>
                            <th class="align-top"><strong>Phone Number</strong></th>
                            <th class="align-top"><strong>Role</strong></th>
                            <th class="align-top"><strong>Actions</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($value as $contact)
                        <tr>
                            <td><img src="{{ $contact->getAttributeUrl('photo') }}" width="50" /></td>
                            <td>{{ $contact->first_name }}</td>
                            <td>{{ $contact->last_name }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->telephone }}</td>
                            <td>{{ optional($contact->role)->title }}</td>
                            <td>
                                @includeIf('admin::widget.button', [
                                    'jsaction' => 'window.open("' . route('admin.customer.contact.edit', ['id' => $contact->id]) . '", "_blank")',
                                    'label'    => 'View',
                                    'route'    => 'admin.customer.contact.edit',
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