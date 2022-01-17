@if($weddingSchedule->portrait_session)
<table class="table table-bordered">
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('When is your portrait session (including bride & groom, bridal party, family & etc.) ?') }}</strong></td>
        <td style="white-space:normal;width:50%;">
            <?php $arr = [];?>
            @foreach(json_decode($weddingSchedule->portrait_session->when,true) as $value)
                @if($value == 1)
                    <?php $arr[] = 'Before Ceremony';?>
                @elseif($value == 2)
                    <?php $arr[] = 'After Ceremony';?>
                @elseif($value == 3)
                    <?php $arr[] = 'Not Sure';?>
                @endif
            @endforeach
            {{implode(',',$arr)}}
        </td>
    </tr>
    @foreach($weddingSchedule->portrait_session->portrait_session_locations as $number => $location)
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('Location #:number Name', ['number' => $number + 1]) }}</strong></td>
        <td style="white-space:normal;width:50%;">{{ $location->name_of_ceremony_portrait }}</td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('Address Line 1') }}</strong></td>
        <td style="white-space:normal;width:50%;">{{ optional($location->address)->address_line_1 }}</td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('Address Line 2') }}</strong></td>
        <td style="white-space:normal;width:50%;">{{ optional($location->address)->address_line_2 }}</td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('State / Province') }}</strong></td>
        <td style="white-space:normal;width:50%;">{{ optional($location->address)->state }}</td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('City') }}</strong></td>
        <td style="white-space:normal;width:50%;">{{ optional($location->address)->city }}</td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('ZIP / Postcode') }}</strong></td>
        <td style="white-space:normal;width:50%;">{{ optional($location->address)->zip }}</td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('Portrait session start time') }}</strong></td>
        <td style="white-space:normal;width:50%;">
            @if($time = $location->portrait_start_time)
                {{ Illuminate\Support\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}
            @endif
        </td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('Portrait session end time') }}</strong></td>
        <td style="white-space:normal;width:50%;">
            @if($time = $location->portrait_end_time)
                {{ Illuminate\Support\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}
            @endif
        </td>
    </tr>
    @endforeach
</table>
@endif