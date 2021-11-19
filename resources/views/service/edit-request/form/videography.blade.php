@extends('layouts.app')

@section('content')

    <videography-edit-request
        form_action="{{ route('service.edit-request.save', ['service' => $service]) }}"
        cancel_action="{{ route('service.view', ['service' => $service]) }}"
    ></videography-edit-request>

@endsection
