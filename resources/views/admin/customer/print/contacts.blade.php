@extends('admin.layouts.print')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-header-title">{{ __('Contacts') }}</h4>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="align-top"><strong>Photo</strong></th>
                            <th class="align-top"><strong>First Name</strong></th>
                            <th class="align-top"><strong>Last Name</strong></th>
                            <th class="align-top"><strong>Email</strong></th>
                            <th class="align-top"><strong>Phone Number</strong></th>
                            <th class="align-top"><strong>Role</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($customer->contacts as $contact)
                        <tr>
                            <td><img src="{{ $contact->getAttributeUrl('photo') }}" width="50" /></td>
                            <td>{{ $contact->first_name }}</td>
                            <td>{{ $contact->last_name }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->telephone }}</td>
                            <td>{{ $contact->role->title }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection