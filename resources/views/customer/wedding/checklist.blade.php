@extends('layouts.app')

@section('content')

    <wedding-checklist-form
        :wedding_checklist="{{ Auth::user()->wedding_checklist }}"
        :preparation="{{ $preparation }}"
        :ceremony="{{ $ceremony }}"
        :reception="{{ $reception }}"
        :portrait_session="{{ $portrait_session }}"
        :vendors="{{ $vendors }}"
        :relations="{{ json_encode(Auth::user()->wedding_checklist->getRelations()) }}"
        :urls="{{ json_encode(['save' => route('customer.wedding.checklist.save')]) }}"
        :steps="{{ json_encode(['Preparation', 'Ceremony', 'Portrait Session/ First Look', 'Reception', 'Cinematography Music', 'Vendors', 'Other Information']) }}"
        song_list="{{\Settings::getConfigValue('songs_list/song_list_content')}}"
        :readonly="{{ Auth::user()->wedding_date->subWeek()->lt(Illuminate\Support\Carbon::now()) ? 'true' : 'false' }}"
    ></wedding-checklist-form>

@endsection
