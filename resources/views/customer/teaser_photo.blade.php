@extends('layouts.app')

@section('content')
	<h2>Teaser Photo</h2><br>
	<teaser-photo 
        :photos="{{ json_encode($photos) }}"
        ></teaser-photo>
@endsection