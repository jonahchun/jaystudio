@extends('layouts.app')

@section('content')

    <engagement_session-edit-request
        form_action="{{ route('service.edit-request.save', ['service' => $service]) }}"
        cancel_action="{{ route('service.view', ['service' => $service]) }}"
        note="* As a friendly reminder, you are allowed to request up to 25 photos for free edits. Additional fees will apply if number of photos pass 25 count."
    ></engagement_session-edit-request>

@endsection
