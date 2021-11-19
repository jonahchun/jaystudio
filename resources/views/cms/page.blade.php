@extends('layouts.app')

@section('content')
    <div class="general-cms">
        <div class="container">
            <div class="row">
                <div class="col-xl-9">
                    {!! $page->getContent() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
