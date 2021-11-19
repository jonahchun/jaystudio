@extends('layouts.app')

@section('content')

    <newlywed-details-form 
        :newlywed_detail="{{ Auth::user()->newlywed_detail }}"
        :questions="{{ json_encode($questions) }}"
        :urls="{{ json_encode(['save' => route('customer.details.save')]) }}"
        :content="{{ json_encode(['title' => 'Details About You', 'description' => \Settings::getConfigValue('wedding_info/newlywed_details_form_description') ]) }}"
        :steps="{{ json_encode(['Your History', 'What You Like In Each Other', 'Your Wedding', 'Comments']) }}"
        :readonly="{{ Auth::user()->wedding_date->subWeek()->lt(Illuminate\Support\Carbon::now()) ? 'true' : 'false' }}"
    ></newlywed-details-form>

@endsection
