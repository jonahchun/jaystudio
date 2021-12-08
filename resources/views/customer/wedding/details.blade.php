@extends('layouts.app')

@section('content')
	<?php
		$before_date = date("Y-m-d H:i:s", strtotime ( '-4 month' , strtotime (Auth::user()->wedding_date) )) ;
		
		$readonly_flag = 'false';
		if(Auth::user()->is_disable_update == 'Yes'){
			$readonly_flag = 'true';
		}else{
			if(Auth::user()->wedding_date->subMonth('4')->gt(Illuminate\Support\Carbon::now())){
				// dd('1');
				$readonly_flag = 'true';
			}elseif(Auth::user()->wedding_date->lt(Illuminate\Support\Carbon::now())){
			// }elseif(Auth::user()->wedding_date->subWeek()->lt(Illuminate\Support\Carbon::now())){
				// dd('2');
				$readonly_flag = 'true';
			}
			

		}
	?>
    <newlywed-details-form 
        :newlywed_detail="{{ Auth::user()->newlywed_detail }}"
        :questions="{{ json_encode($questions) }}"
        :urls="{{ json_encode(['save' => route('customer.details.save')]) }}"
        :content="{{ json_encode(['title' => 'Details About You', 'description' => \Settings::getConfigValue('wedding_info/newlywed_details_form_description') ]) }}"
        :steps="{{ json_encode(['Your History', 'What You Like In Each Other', 'Your Wedding', 'Comments']) }}"
        :readonly="{{ $readonly_flag }}"
    ></newlywed-details-form>

    <!-- <newlywed-details-form 
        :newlywed_detail="{{ Auth::user()->newlywed_detail }}"
        :questions="{{ json_encode($questions) }}"
        :urls="{{ json_encode(['save' => route('customer.details.save')]) }}"
        :content="{{ json_encode(['title' => 'Details About You', 'description' => \Settings::getConfigValue('wedding_info/newlywed_details_form_description') ]) }}"
        :steps="{{ json_encode(['Your History', 'What You Like In Each Other', 'Your Wedding', 'Comments']) }}"
        :readonly="{{ (Auth::user()->wedding_date->subWeek()->lt(Illuminate\Support\Carbon::now())) ? 'true' : 'false' }}"
    ></newlywed-details-form> -->

@endsection
