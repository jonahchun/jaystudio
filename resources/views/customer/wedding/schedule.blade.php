@extends('layouts.app')

@section('content')
    <?php
        // This wedding form is accessible only before 1 week and In between 4 months from wedding date
        // If current date between 1 week of wedding date then not accessible and
        // If form is access before 4 month then not accessible

        $before_date = date("Y-m-d H:i:s", strtotime ( '-4 month' , strtotime (Auth::user()->wedding_date) )) ;

        $readonly_flag = 'false';
        if(Auth::user()->is_disable_update == 'Yes'){
            $readonly_flag = 'true';
        }else{
            // if(Auth::user()->wedding_date->subWeek()->lt(Illuminate\Support\Carbon::now())){
            //     $readonly_flag = 'true';
            // }elseif(Auth::user()->wedding_date->subMonth('4')->gt(Illuminate\Support\Carbon::now())){
            //     $readonly_flag = 'true';

            // }
            if(Auth::user()->wedding_date->subMonth('4')->gt(Illuminate\Support\Carbon::now())){
                $readonly_flag = 'true';

            }
        }

        $is_download_file = 0;
        if(!empty(Auth::user()->insurance_certificate_file)){
            $is_download_file = 1;
        }
    ?>
    <wedding-schedule-form
        :wedding_schedule="{{ Auth::user()->wedding_schedule }}"
        :urls="{{ json_encode(['save' => route('customer.wedding.schedule.save')]) }}"
        :download_urls="{{ json_encode(['download' => route('downloadInsuranceFile',Auth::user()->id)]) }}"
        :time_options="{{json_encode(config('common.wedding_form_time_option'))}}"
        :is_download_file="{{$is_download_file}}"
        :steps="{{ json_encode([
          Auth::user()->first_newlywed->first_name . '\'s Preparation',
          Auth::user()->second_newlywed->first_name . '\'s Preparation',
          'Ceremony', 'Reception', 'Portrait Session', 'Other Information']) }}"
        :relations="{{ json_encode(Auth::user()->wedding_schedule->getRelations()) }}"
        :ceremony_settings="{{ \App\WeddingSchedule\Model\Ceremony\Setting::orderBy('sort_order', 'asc')->get() }}"
        :preparation_settings="{{ \App\WeddingSchedule\Model\Preparation\Setting::orderBy('sort_order', 'asc')->get() }}"
        :ceremony_details="{{ \App\WeddingSchedule\Model\Ceremony\Detail::orderBy('sort_order', 'asc')->get() }}"
        :ceremony_traditions="{{ \App\WeddingSchedule\Model\Ceremony\Tradition::orderBy('sort_order', 'asc')->get() }}"
        :contacts="{{ \App\Customer\Model\Contact::where('customer_id', Auth::user()->id)->get() }}"
        :newlywed_types="{{ json_encode([Auth::user()->first_newlywed->bridegroom, Auth::user()->second_newlywed->bridegroom]) }}"
        :readonly="{{ $readonly_flag }}"
    ></wedding-schedule-form>

@endsection
