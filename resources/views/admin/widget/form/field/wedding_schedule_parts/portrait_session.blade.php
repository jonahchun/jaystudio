@if($weddingSchedule->portrait_session)
<table class="table table-bordered">
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('When is your first look and portrait session with your family and bridal party?') }}</strong></td>
        <td style="white-space:normal;width:50%;">
            @switch($weddingSchedule->portrait_session->when)
                @case(1)
                    {{ __('Before Ceremony') }}
                    @break
                @case(2)
                    {{ __('After Ceremony') }}
                    @break
                @case(3)
                    {{ __('Not Sure') }}
                    @break
            @endswitch
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