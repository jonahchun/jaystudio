@extends('layouts.app')

@section('content')

    <photo-album-edit-request
        form_action="{{ route('service.edit-request.save', ['service' => $service]) }}"
        cancel_action="{{ route('service.view', ['service' => $service]) }}"
    ></photo-album-edit-request>

@endsection
