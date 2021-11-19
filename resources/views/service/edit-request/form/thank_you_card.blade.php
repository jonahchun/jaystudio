@extends('layouts.app')

@section('content')

    <card-edit-request
        form_action="{{ route('service.edit-request.save', ['service' => $service]) }}"
        cancel_action="{{ route('service.view', ['service' => $service]) }}"
    ></card-edit-request>

@endsection
