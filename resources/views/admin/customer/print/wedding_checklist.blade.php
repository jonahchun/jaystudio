@extends('admin.layouts.print')

@section('content')
@php
    $entities = \App\WeddingChecklist\Model\ChecklistEntities::getEntities();
    $value = $customer->wedding_checklist;
@endphp
<div class="row">
    <div class="col-12">
        <div class="text-center p-4 table-warning" style="background-color: #f8ebed;">
            <a class="logo" href="{{ route('dashboard') }}">
                <img src="{{ \Settings::getConfigValueUrl('app/logo') ?: asset('images/logo-big.svg') }}" alt="">
            </a>
        </div>
        <div class="text-center p-3 table-info" style="background-color: #fcf6f7;">
          <h5 class="m-0">Wedding Checklist</h5>
        </div>
        <div class="text-center p-2">
          <p class="font-italic">You’ll want to remember all the special moments of your day. Check off those that you wish us to capture.
            *Please remember to save all written information before submitting. Once completed, please send via email as an attachment to support@jaylimstudio.com
            We require your forms no later than 1 month prior to your wedding date.</p>
        </div>
    </div>
</div>
<hr>
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
            <div class="d-flex flex-wrap">
               <div class="d-flex align-items-center">
                  <label for="Bride" class="m-0"> Wedding Date :</label>
               </div>
            </div>
         </div>
         <div class="col-8">
          <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="(MM/DD/YYYY)" value="{{date('m/d/Y',strtotime($customer->wedding_date))}}">
         </div> 
      </div>
   </div>
</div>

<hr>
@foreach(\App\WeddingChecklist\Model\Source\Steps::getInstance()->getOptions() as $_value => $label)
   @if($_value == \App\WeddingChecklist\Model\Source\Steps::CINEMATOGRAPHY)
      <div class="row">
          <div class="col-12">
            <h5> Cinematography</h5> 
          </div>
          <div class="col-6">
            <p>I want to have music picked by:</p>
            <div class="row align-items-center py-1">
              <div class="col-12 pr-0">
                <div class="d-flex align-items-baseline">
                  <input type="radio" name="music_by" value="studio" @if($value->music == 1) checked @endif>
                  <label for="cg1" class="m-0 pl-2"> JAYLim Studio </label>
                </div>
              </div> 
            </div>
            <div class="row align-items-center py-1">
              <div class="col-12 pr-0">
                <div class="d-flex align-items-baseline">
                  <input type="radio" name="music_by" value="myself" @if($value->music == 2) checked @endif>
                  <label for="cg2" class="m-0 pl-2"> Myself </label>
                </div>
              </div> 
            </div>
            <br>
            @if(count($value->music_songs) > 0)
               <p><b>Song List:</b></p>
               <table class="table table-bordered">
                  <thead>
                     <tr>
                         <th>Song Name</th>
                         <th>Type</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($value->music_songs as $song)
                        <tr>
                           <td style="white-space:normal;width:50%;"><strong>{{ $song->song_name }}</strong></td>
                           <td style="white-space:normal;width:50%;">
                               @switch($song->type)
                                   @case(1)
                                       {{ __('Highlight Reel') }}
                                       @break
                                   @case(2)
                                       {{ __('Full Video') }}
                                       @break
                               @endswitch
                           </td>
                        </tr>
                     @endforeach
                  </tbody>
               </table>
            @endif
          </div>
        </div>
   @elseif($_value !== \App\WeddingChecklist\Model\Source\Steps::VENDORS)
      <div class="row">
        <div class="col-12">
          <h5> {{ $label }}</h5> 
        </div>
         
         <div class="col-4">
            @foreach($entities[$_value] as $entity)
               <div class="row align-items-center py-1">
                  <div class="col-12 pr-0">
                    <input type="checkbox" id="Monday" name="Monday" value="ceremony" @if(!empty($value[$_value][$entity->id]['value'])) checked @endif>
                  <label for="Monday" class="m-0 pl-2"> {{ $entity->title }} </label>
                  </div> 
               </div>
            @endforeach
         </div>
      </div>
   @else
      <div class="row">
       <div class="col-12">
         <h5> {{ $label }}</h5>
       </div>
      </div>
      @foreach($entities['vendors'] as $vendor)
         <div class="row align-items-center py-1">
           <div class="col-4">
             <label for="Bride" class="m-0"> {{ $vendor->title }}:</label>
           </div>
           <div class="col-4">
             <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Name / Company" value="{{ !empty($value->vendors[$vendor->id]['company']) ? $value->vendors[$vendor->id]['company'] : '' }}">
           </div> 
           <div class="col-4">
             <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Instagram / SNS Handle" value="{{ !empty($value->vendors[$vendor->id]['socials']) ? $value->vendors[$vendor->id]['socials'] : '' }}">
           </div> 
         </div>
      @endforeach
   @endif
<hr>
@endforeach
<hr>


<p class="mt-5">*Please remember to save all written information before submitting. Once completed, please send via email as an attachment to support@jaylimstudio.com</p>
@endsection
