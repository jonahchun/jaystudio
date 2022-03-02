@extends('layouts.app')

@section('content')
	<h2>Cinematography Links</h2><br>
	<wedding-cinematography 
        :initial_links="{{ json_encode($links) }}"
        ></wedding-cinematography>
@endsection