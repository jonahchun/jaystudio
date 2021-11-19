@extends('layouts.app')

@section('content')

    <customer-contacts 
        :initial_contacts="{{ $contacts->toJson() }}"
        :urls="{{ json_encode(['delete' => route('customer.contacts.delete', ['id' => '__id__']), 'save' => route('customer.contacts.save')]) }}"
        :content="{{ json_encode(['title' => 'Contacts', 'description' => \Settings::getConfigValue('contacts/description') ]) }}"
        :roles="{{ json_encode(\App\Customer\Model\Source\ContactRoles::getInstance()->getOptions()) }}"
    ></customer-contacts>
    @include('page.components.confirmation')

@endsection
