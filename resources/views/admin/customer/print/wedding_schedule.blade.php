@extends('admin.layouts.print')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="text-center p-4 table-warning" style="background-color: #f8ebed;">
            <a class="logo" href="{{ route('dashboard') }}">
                <img src="{{ \Settings::getConfigValueUrl('app/logo') ?: asset('images/logo-big.svg') }}" alt="">
            </a>
        </div>
        <div class="text-center p-3 table-info" style="background-color: #fcf6f7;">
          <h5 class="m-0">Wedding Schedule</h5>
        </div>
    </div>
</div> 
@php
    $weddingSchedule = $customer->wedding_schedule
@endphp
<div class="row py-2 mt-3">
    @foreach(NewlywedType::getInstance()->getOptions() as $type => $label)
   <?php 
     $customer_data = $customer->{$type . '_newlywed'};
   ?>
      <div class="col-6">
        <div class="row align-items-center form-group">
          <div class="col-4">
            <div class="d-flex flex-wrap">
              <div class="d-flex align-items-center">
                <input type="checkbox" id="Bride" name="Bride" value="Bride" @if($customer_data->bridegroom == 'bride') checked @endif>
                <label for="Bride" class="m-0 pl-2"> Bride /</label>
              </div>
              <div class="d-flex align-items-center ml-2">
                <input type="checkbox" id="Groom" name="Groom" value="Groom" @if($customer_data->bridegroom == 'groom') checked @endif>
                <label for="Groom" class="m-0 pl-2"> Groom :</label>
              </div>
            </div>
          </div>
          <div class="col-8">
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="First & Last Name" value="{{$customer_data->first_name .' '. $customer_data->last_name}}">
          </div> 
        </div>
    </div>
    @endforeach
    <div class="col-6">
        <div class="row align-items-center form-group">
          <div class="col-4">
            <label for="wedding_date" class="m-0"> Wedding Date :</label>
          </div>
          <div class="col-8">
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="(MM/DD/YYYY)" value="{{date('m/d/Y',strtotime($customer->wedding_date))}}">
          </div> 
        </div>
    </div>
    <div class="col-6"></div>
    <div class="col-6">
        <div class="row align-items-center">
          <div class="col-4">
            <label for="Groomsman" class="m-0"> # of Groomsman :</label>
          </div>
          <div class="col-8">
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Ring Boys, Jr. Groomsman, etc.">
          </div> 
        </div>
    </div>
    <div class="col-6">
        <div class="row align-items-center">
          <div class="col-4">
            <label for="Bridesmaids" class="m-0"> # of Bridesmaids :</label>
          </div>
          <div class="col-8">
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Flower Girls, Jr. Bridesmaids, etc.">
          </div> 
        </div>
    </div>
</div>
<hr>
<div class="row">
    @foreach(NewlywedType::getInstance()->getOptions() as $type => $label)
   <?php 
        $customer_datas = $customer->{$type . '_newlywed'};

        $preparation_address = $customer->{$type . '_newlywed_preparation'};
        $wed_address = $customer->{$type . '_newlywed_address'};

        $address = $wed_address->address_line_1 . (!empty($wed_address->address_line_1) ? ",".$wed_address->address_line_1 : '') ."," .$wed_address->state .",". $wed_address->city ."-".$wed_address->zip;
      
        if($preparation_address->hair_makeup == 0){
            $hair_makeup_address = $wed_address->hair_makeup_address_line_1 . (!empty($wed_address->hair_makeup_address_line_1) ? ",".$wed_address->hair_makeup_address_line_1 : '') . (!empty($wed_address->hair_makeup_state) ? "," .$wed_address->hair_makeup_state: '') . (!empty($wed_address->hair_makeup_city)? ",". $wed_address->hair_makeup_city:'') . (!empty($wed_address->hair_makeup_zip) ? "-".$wed_address->hair_makeup_zip : '');
        }else{
            $hair_makeup_address = "Same as above";
        }
   ?>
    <div class="col-6">
        <div class="d-flex form-group">
          <div class="d-flex align-items-center">
            <input type="radio" id="Bride" name="{{$type}}_bride_groom" value="Bride" @if($customer_datas->bridegroom == 'bride') checked @endif>
            <h5 for="Bride" class="m-0 pl-2"> Bride /</h5>
          </div>
          <div class="d-flex align-items-center ml-2">
            <input type="radio" id="Groom" name="{{$type}}_bride_groom" value="Groom" @if($customer_datas->bridegroom == 'groom') checked @endif>
            <h5 for="Groom" class="m-0 pl-2"> Groom Preparation</h5>
          </div>
        </div>
        <div class="d-flex align-items-center ml-2">
            <label class="mr-2">Hair/make up in the same location:</label>
            <input type="checkbox" id="Yes" name="Yes" value="Yes" @if($preparation_address->hair_makeup == 1) checked @endif>
            <label for="Yes" class="m-0 pr-2 pl-2"> Yes </label>

            <input type="checkbox" id="No" name="No" value="No" @if($preparation_address->hair_makeup == 0) checked @endif>
            <label for="No" class="m-0 pl-2"> No </label>
        </div>
        <p class="m-0">Getting Ready (Location & Address)</p>

        <textarea class="form-control my-3" id="exampleFormControlTextarea1" rows="3">{{$address}}</textarea>

        <p class="m-0">Hair/Makeup (Location & Address)</p>

        <textarea class="form-control my-3" id="exampleFormControlTextarea1" rows="3">{{$hair_makeup_address}}</textarea>
        <div class="row align-items-center">
          <div class="col-4">
            <label for="Bride" class="m-0"> JLS Finish Time:</label>
          </div>
          <div class="col-8">
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="@if(($time = $preparation_address->preparation_start_time) && strpos($time, ':') !== false){{ Illuminate\Support\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}@endif">
          </div> 
        </div>
        <div class="row align-items-center">
          <div class="col-4">
            <label for="Bride" class="m-0"> Transportation Departure Time:</label>
          </div>
          <div class="col-8">
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="@if(($time = $preparation_address->transportation_start_time) && strpos($time, ':') !== false){{ Illuminate\Support\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}@endif">
          </div> 
        </div>
        <div class="row align-items-center">
          <div class="col-4">
            <label for="Bride" class="m-0"> Emergency Contact:</label>
          </div>
          <div class="col-8">
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="@if($preparation_address->contact){{ optional($preparation_address->contact)->first_name }}{{ optional($preparation_address->contact)->last_name }}({{ optional($preparation_address->contact)->telephone }})@else {{ $preparation_address->contact_name }}({{ $preparation_address->contact_phone }})@endif">
          </div> 
        </div>
        <small>(Name, Phone, & Relation) - Member of Wedding Party Suggested</small>
    </div>
@endforeach
</div>
<hr>
<div class="row">
  <div class="col-6">
    <h5> Ceremony</h5>
    <p class="m-0">Name of the Location & Address :</p>
    <?php 
        $ceremony_address = optional($weddingSchedule->ceremony->address)->address_line_1.(!empty($weddingSchedule->ceremony->address->address_line_2) ? ",".optional($weddingSchedule->ceremony->address)->address_line_2 : '').",".optional($weddingSchedule->ceremony->address)->state.",".optional($weddingSchedule->ceremony->address)->city."-".optional($weddingSchedule->ceremony->address)->zip;

        $details = [];
        foreach ($weddingSchedule->ceremony->details as $key=>$identifier) {
            $detail = \App\WeddingSchedule\Model\Ceremony\Detail::where('identifier', $identifier)->first();
            $details[$key] = $detail ? $detail->title : $identifier;
        }

        $traditions = [];

        foreach($weddingSchedule->ceremony->ceremony_tradition_labels as $identifier) {
            $tradition = \App\WeddingSchedule\Model\Ceremony\Tradition::where('identifier', $identifier)->first();
            if($tradition){
                $traditions[$identifier] = $tradition->title;
            }else{
                $traditions['other'] = $identifier;

            }
        }
    ?>
    <textarea class="form-control my-3" id="exampleFormControlTextarea1" rows="3">{{optional($weddingSchedule->ceremony)->name_of_ceremony}}&#13;&#10;{{$ceremony_address}}</textarea>
    <div class="row align-items-center py-1">
      <div class="col-4">
        <label for="Bride" class="m-0"> Invitation Start Time:</label>
      </div>
      <div class="col-8">
        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="@if($time = $weddingSchedule->ceremony->invitation_start_time){{ Illuminate\Support\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}@endif">
      </div> 
    </div>
    <div class="row align-items-center py-1">
      <div class="col-4">
        <label for="Bride" class="m-0"> Ceremony Start Time:</label>
      </div>
      <div class="col-8">
        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="@if($time = $weddingSchedule->ceremony->ceremony_start_time){{ Illuminate\Support\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}@endif">
      </div> 
    </div>
    <div class="row align-items-center py-1">
      <div class="col-4">
        <label for="Bride" class="m-0"> Ceremony End time:</label>
      </div>
      <div class="col-8">
        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="@if($time = $weddingSchedule->ceremony->ceremony_end_time){{ Illuminate\Support\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}@endif">
      </div> 
    </div>
    <div class="row align-items-center">
      <div class="col-4">
        <label for="Bride" class="m-0"> Rehearsal Start & End Time:</label>
      </div>
      <div class="col-8">
        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
      </div> 
    </div>
    <small>(Only note if same day as wedding)</small>
  </div>
  <div class="col-6">
    <div class="row">
      <div class="col-4">
        <h6>Ceremony Setting :</h6>
        <div class="d-flex align-items-center">
          <input type="checkbox" id="Indoor" name="Indoor" value="ceremony" @if($weddingSchedule->ceremony->settings_label == "Indoor") checked @endif>
          <label for="Indoor" class="m-0 pl-2"> Indoor </label>
        </div>
        <div class="d-flex align-items-center">
          <input type="checkbox" id="Outdoor" name="Outdoor" value="ceremony" @if($weddingSchedule->ceremony->settings_label == "Outdoor") checked @endif>
          <label for="Outdoor" class="m-0 pl-2"> Outdoor </label>
        </div>
        <div class="d-flex align-items-center">
          <input type="checkbox" id="Tent" name="Tent" value="ceremony" @if($weddingSchedule->ceremony->settings_label == "Tent") checked @endif>
          <label for="Tent" class="m-0 pl-2"> Tent </label>
        </div>
        <div class="d-flex align-items-center">
          <input type="checkbox" id="Other" name="Other" value="ceremony" @if($weddingSchedule->ceremony->settings_label != "Tent" && $weddingSchedule->ceremony->settings_label != "Outdoor" && $weddingSchedule->ceremony->settings_label != "Indoor") checked @endif>
          <label for="Other" class="m-0 pl-2"> Other: </label>
        </div>
        <input type="text" class="form-control mt-1" id="exampleInputEmail1" aria-describedby="emailHelp" value="@if($weddingSchedule->ceremony->settings_label != "Tent" && $weddingSchedule->ceremony->settings_label != "Outdoor" && $weddingSchedule->ceremony->settings_label != "Indoor") {{$weddingSchedule->ceremony->settings_label}} @endif">

        <h6 class="mt-4">Details :</h6>
        <div class="d-flex align-items-center">
          <input type="checkbox" id="Only Ceremony" name="Only Ceremony" value="ceremony" @if(in_array("Only Ceremony",$details)) checked @endif>
          <label for="Only Ceremony" class="m-0 pl-2"> Only Ceremony </label>
        </div>
        <div class="d-flex align-items-center">
          <input type="checkbox" id="Full Mass" name="Full Mass" value="ceremony" @if(in_array("Full Mass",$details)) checked @endif>
          <label for="Full Mass" class="m-0 pl-2"> Full Mass </label>
        </div>
        <div class="d-flex align-items-center">
          <input type="checkbox" id="Receiving Line" name="Receiving Line" value="ceremony" @if(in_array("Receiving Line",$details)) checked @endif>
          <label for="Receiving Line" class="m-0 pl-2"> Receiving Line </label>
        </div>
        <div class="d-flex align-items-center">
          <input type="checkbox" id="Other1" name="Other1" value="ceremony" @if(array_key_exists("other",$details)) checked @endif>
          <label for="Other1" class="m-0 pl-2"> Other: </label>
        </div>
        <input type="text" class="form-control mt-1" id="exampleInputEmail1" aria-describedby="emailHelp" value="@if(array_key_exists("other",$details)) {{$details['other']}} @endif">
      </div>
      <div class="col-8">
        <h6>Ceremony Traditions & Rituals :</h6>
        <small>* Please list details</small>
        <div class="row align-items-center py-1">
          <div class="col-4 pr-0">
            <input type="checkbox" id="Catholic" name="Catholic" value="ceremony" @if(in_array("Catholic",$traditions)) checked @endif >
          <label for="Catholic" class="m-0 pl-2"> Catholic: </label>
          </div>
          <div class="col-8">
            <input type="text" class="form-control ml-2" id="exampleInputEmail1" aria-describedby="emailHelp">
          </div>
        </div>
        <div class="row align-items-center py-1">
          <div class="col-4 pr-0">
            <input type="checkbox" id="Christian" name="Christian" value="ceremony" @if(in_array("Christian",$traditions)) checked @endif>
          <label for="Christian" class="m-0 pl-2"> Christian: </label>
          </div>
          <div class="col-8">
            <input type="text" class="form-control ml-2" id="exampleInputEmail1" aria-describedby="emailHelp">
          </div>
        </div>
        <div class="row align-items-center py-1">
          <div class="col-4 pr-0">
            <input type="checkbox" id="Hindu" name="Hindu" value="ceremony" @if(in_array("Hindu",$traditions)) checked @endif>
          <label for="Hindu" class="m-0 pl-2"> Hindu: </label>
          </div>
          <div class="col-8">
            <input type="text" class="form-control ml-2" id="exampleInputEmail1" aria-describedby="emailHelp">
          </div>
        </div>
        <div class="row align-items-center py-1">
          <div class="col-4 pr-0">
            <input type="checkbox" id="Jewish" name="Jewish" value="ceremony" @if(in_array("Jewish",$traditions)) checked @endif>
          <label for="Jewish" class="m-0 pl-2"> Jewish: </label>
          </div>
          <div class="col-8">
            <input type="text" class="form-control ml-2" id="exampleInputEmail1" aria-describedby="emailHelp">
          </div>
        </div>
        <div class="row align-items-center py-1">
          <div class="col-4 pr-0">
            <input type="checkbox" id="Muslim" name="Muslim" value="ceremony" @if(in_array("Muslim",$traditions)) checked @endif>
          <label for="Muslim" class="m-0 pl-2"> Muslim: </label>
          </div>
          <div class="col-8">
            <input type="text" class="form-control ml-2" id="exampleInputEmail1" aria-describedby="emailHelp">
          </div>
        </div>
        <div class="row align-items-center py-1">
          <div class="col-4 pr-0">
            <input type="checkbox" id="East Asian" name="East Asian" value="ceremony" @if(in_array("East Asian",$traditions)) checked @endif>
            <label for="East Asian" class="m-0 pl-2"> East Asian: </label>
          </div>
          <div class="col-8">
            <input type="text" class="form-control ml-2" id="exampleInputEmail1" aria-describedby="emailHelp">
          </div>
        </div>
        <div class="row align-items-center py-1">
          <div class="col-4">
            <input type="checkbox" id="Other3" name="Other3" value="ceremony" @if(array_key_exists("other",$traditions)) checked @endif>
            <label for="Other3" class="m-0 pl-2"> Other: </label>
          </div>
          <div class="col-8">
            <input type="text" class="form-control ml-2" id="exampleInputEmail1" aria-describedby="emailHelp" value="@if(array_key_exists("other",$traditions)) {{$traditions['other']}} @endif">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<hr>
<?php 
    $reception_address = optional($weddingSchedule->reception->address)->address_line_1.(!empty($weddingSchedule->reception->address->address_line_2) ? ",".optional($weddingSchedule->reception->address)->address_line_2 : '').",".optional($weddingSchedule->reception->address)->state.",".optional($weddingSchedule->reception->address)->city."-".optional($weddingSchedule->reception->address)->zip;
    // dd($weddingSchedule->reception);
    ?>
<div class="row">
  <div class="col-6">
    <h5> Reception</h5>
    <p class="m-0">Reception Name & Address :</p>
    <textarea class="form-control my-3" id="exampleFormControlTextarea1" rows="3">{{optional($weddingSchedule->ceremony)->name_of_reception}}&#13;&#10;{{$reception_address}}</textarea>
    <div class="row align-items-center py-1">
      <div class="col-4">
        <label for="Bride" class="m-0"> Venue Coordinator:</label>
      </div>
      <div class="col-8">
        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$weddingSchedule->reception->venue_coordinator_name}}">
      </div> 
    </div>
    <div class="row align-items-center py-1">
      <div class="col-4">
        <label for="Bride" class="m-0"> Email:</label>
      </div>
      <div class="col-8">
        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$weddingSchedule->reception->venue_coordinator_email}}">
      </div> 
    </div>
    <div class="row align-items-center py-1">
      <div class="col-4">
        <label for="Bride" class="m-0"> Phone #:</label>
      </div>
      <div class="col-8">
        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$weddingSchedule->reception->venue_coordinator_phone}}">
      </div> 
    </div>
  </div>
  <div class="col-6">
    <div class="row align-items-center py-1">
      <div class="col-5">
      <label for="Catholic" class="m-0"> Cocktail Start & End Time: </label>
      </div>
      <div class="col-7">
        <input type="text" class="form-control ml-2" id="exampleInputEmail1" aria-describedby="emailHelp" value="@if($time = $weddingSchedule->reception->cocktails_start_time){{ Illuminate\Support\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}@endif - @if($time = $weddingSchedule->reception->cocktails_end_time){{ Illuminate\Support\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}@endif">
      </div>
    </div> 
    <div class="row align-items-center py-1">
      <div class="col-5">
      <label for="Catholic" class="m-0"> Reception Start & End Time: </label>
      </div>
      <div class="col-7">
        <input type="text" class="form-control ml-2" id="exampleInputEmail1" aria-describedby="emailHelp" value="@if($time = $weddingSchedule->reception->reception_start_time){{ Illuminate\Support\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}@endif @if($time = $weddingSchedule->reception->reception_end_time) - {{ Illuminate\Support\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}@endif">
      </div>
    </div> 
    <div class="row align-items-center py-1">
      <div class="col-5">
      <label for="Catholic" class="m-0"> Cake Cutting Time: </label>
      </div>
      <div class="col-7">
        <input type="text" class="form-control ml-2" id="exampleInputEmail1" aria-describedby="emailHelp" value="@if($time = $weddingSchedule->reception->cake_cutting_time){{ Illuminate\Support\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}@endif">
      </div>
    </div> 
  </div>
</div>
<hr>
<h5> Portrait Session: Couple, Family & Bridal party</h5>
@foreach($weddingSchedule->portrait_session->portrait_session_locations as $number => $location)
    <?php
        $portrait_session_address = optional($location->address)->address_line_1.(!empty($location->address->address_line_2) ? ",".optional($location->address)->address_line_2 : '').",".optional($location->address)->state.",".optional($location->address)->city."-".optional($location->address)->zip;
        // dd($portrait_session_address);
    ?>
    <div class="row mt-3">
      <div class="col-6">
        <p class="m-0"><b>#{{$number+1}} Location:</b> Name & Address</p>
        <textarea class="form-control my-3" id="exampleFormControlTextarea1" rows="3">{{ $location->name_of_ceremony_portrait }}&#13;&#10;{{$portrait_session_address}}</textarea>
        <div class="row align-items-center py-1">
          <div class="col-4">
            <label for="Bride" class="m-0"> Start & End Time:</label>
          </div>
          <div class="col-8">
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="@if($time = $location->portrait_start_time){{ Illuminate\Support\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}@endif @if($time = $location->portrait_end_time) - {{ Illuminate\Support\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}@endif">
          </div> 
        </div>
        <small>(Feel free to leave blank & JLS will discuss with you)</small>
      </div>
      <div class="col-6"></div>
    </div>
@endforeach
<hr>
<div class="row">
  <div class="col-6">
    <h5> Phone Meeting</h5>
    <p>List your availabities to connect to our studio coordinator
      to confirm your wedding details :</p>
      <div class="row align-items-center py-1">
        <div class="col-4 text-center">
          <p>Day</p>
        </div>
        <div class="col-8 text-center">
          <p>Time</p>
        </div>
      </div>
    <div class="row align-items-center py-1">
      <div class="col-4 pr-0">
        <input type="checkbox" id="Monday" name="Monday" value="ceremony">
      <label for="Monday" class="m-0 pl-2"> Monday: </label>
      </div>
      <div class="col-8">
        <input type="text" class="form-control ml-2" id="exampleInputEmail1" aria-describedby="emailHelp">
      </div>
    </div>
    <div class="row align-items-center py-1">
      <div class="col-4 pr-0">
        <input type="checkbox" id="Tuesday" name="Tuesday" value="ceremony">
      <label for="Tuesday" class="m-0 pl-2"> Tuesday: </label>
      </div>
      <div class="col-8">
        <input type="text" class="form-control ml-2" id="exampleInputEmail1" aria-describedby="emailHelp">
      </div>
    </div>
    <div class="row align-items-center py-1">
      <div class="col-4 pr-0">
        <input type="checkbox" id="Wednesday" name="Wednesday" value="ceremony">
      <label for="Wednesday" class="m-0 pl-2"> Wednesday: </label>
      </div>
      <div class="col-8">
        <input type="text" class="form-control ml-2" id="exampleInputEmail1" aria-describedby="emailHelp">
      </div>
    </div>
    <div class="row align-items-center py-1">
      <div class="col-4 pr-0">
        <input type="checkbox" id="Thursday" name="Thursday" value="ceremony">
      <label for="Thursday" class="m-0 pl-2"> Thursday: </label>
      </div>
      <div class="col-8">
        <input type="text" class="form-control ml-2" id="exampleInputEmail1" aria-describedby="emailHelp">
      </div>
    </div>
    <div class="row align-items-center py-1">
      <div class="col-4 pr-0">
        <input type="checkbox" id="Friday" name="Friday" value="ceremony">
      <label for="Friday" class="m-0 pl-2"> Friday: </label>
      </div>
      <div class="col-8">
        <input type="text" class="form-control ml-2" id="exampleInputEmail1" aria-describedby="emailHelp">
      </div>
    </div>
      
  </div>
  <div class="col-6"></div>
</div>
<hr>
<div class="row mb-5">
  <div class="col-12">
    <h5> Comments</h5>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="8">{{ $customer->wedding_schedule->comment }}</textarea>
  </div>
</div>
@endsection
