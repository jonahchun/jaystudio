@extends('layouts.app')

@section('content')
    <wedding-schedule-form 
        :wedding_schedule="{{ Auth::user()->wedding_schedule }}"
        :urls="{{ json_encode(['save' => route('customer.wedding.schedule.save')]) }}"
        :steps="{{ json_encode([
          Auth::user()->first_newlywed->first_name . '\'s Preparation',
          Auth::user()->second_newlywed->first_name . '\'s Preparation',
          'Ceremony', 'Reception', 'Portrait session / First look', 'Other Information']) }}"
        :relations="{{ json_encode(Auth::user()->wedding_schedule->getRelations()) }}"
        :ceremony_settings="{{ \App\WeddingSchedule\Model\Ceremony\Setting::orderBy('sort_order', 'asc')->get() }}"
        :preparation_settings="{{ \App\WeddingSchedule\Model\Preparation\Setting::orderBy('sort_order', 'asc')->get() }}"
        :ceremony_details="{{ \App\WeddingSchedule\Model\Ceremony\Detail::orderBy('sort_order', 'asc')->get() }}"
        :ceremony_traditions="{{ \App\WeddingSchedule\Model\Ceremony\Tradition::orderBy('sort_order', 'asc')->get() }}"
        :contacts="{{ \App\Customer\Model\Contact::where('customer_id', Auth::user()->id)->get() }}"
        :newlywed_types="{{ json_encode([Auth::user()->first_newlywed->bridegroom, Auth::user()->second_newlywed->bridegroom]) }}"
        :readonly="{{ Auth::user()->wedding_date->subWeek()->lt(Illuminate\Support\Carbon::now()) ? 'true' : 'false' }}"
    ></wedding-schedule-form>

@endsection
