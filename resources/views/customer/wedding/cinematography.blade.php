@extends('layouts.app')

@section('content')
	<h2>Cinematography Links</h2><br>
	<wedding-cinematography 
        :initial_links="{{ $links->toJson() }}"
        ></wedding-cinematography>
@endsection