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
            if(Auth::user()->wedding_date->subWeek()->lt(Illuminate\Support\Carbon::now())){
                $readonly_flag = 'true';
            }elseif(Auth::user()->wedding_date->subMonth('4')->gt(Illuminate\Support\Carbon::now())){
                $readonly_flag = 'true';

            }
        }
    ?>
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
        :readonly="{{ $readonly_flag }}"
    ></wedding-checklist-form>

@endsection
