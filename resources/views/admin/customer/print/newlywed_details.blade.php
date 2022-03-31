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
              <h5 class="m-0">Details About You</h5>
            </div>
            <div class="text-center p-2">
              <p class="font-italic">*Please remember to save all written information before submitting. Once completed, please send via email as an attachment to support@jaylimstudio.com</p>
            </div>
        </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="form-group">
          <div class="row justify-content-center align-items-center">
            <div class="col-3 text-right"><label for="exampleInputEmail1" class="m-0">Wedding Date</label></div>
            <div class="col-3"><input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="(MM/DD/YYYY)" value="{{date('m/d/Y',strtotime($customer->wedding_date))}}"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="row py-2">
      <div class="col-12">
        <div class="d-flex justify-content-between">
            @foreach(NewlywedType::getInstance()->getOptions() as $type => $label)
            <?php
                $customer_data = $customer->{$type . '_newlywed'};
            ?>

              <div class="d-flex align-items-center">
                <input type="checkbox" id="Bride" name="Bride" value="Bride" @if($customer_data->bridegroom == 'bride') checked @endif>
                <label for="Bride" class="m-0 pl-2"> Bride</label>
              </div>
              <div class="d-flex align-items-center ml-4">
                <input type="checkbox" id="Groom" name="Groom" value="Groom" @if($customer_data->bridegroom == 'groom') checked @endif>
                <label for="Groom" class="m-0 pl-2"> Groom</label>
              </div>
              <div class="mx-4">
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="First & Last Name" value="{{$customer_data->first_name .' '. $customer_data->last_name}}">
              </div>
            @endforeach
        </div>
      </div>
    </div>
    <hr>

    <form>
        <?php $c=0;?>
        @foreach($customer->newlywed_detail->question_answers as $questionId => $answer)
            @if($question = \App\Core\Model\Question::find($questionId))
                <?php $c = $c+1;?>
                <div class="form-group">
                    <label for="exampleInputEmail1">{{$c}}. {{ $question->question }}</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3">{{ $answer }}</textarea>
                </div>
            @endif
        @endforeach
    </form>
    <p class="font-italic">*Please remember to save all written information before submitting. Once completed, please send via email as an attachment to support@jaylimstudio.com</p>
@endsection
