@if($weddingSchedule->first_newlywed_preparation)
<table class="table table-bordered">
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('General Details') }}</strong></td>
        <td style="white-space:normal;width:50%;">{{ optional($weddingSchedule->first_newlywed_preparation->preparation)->title }}</td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('Name of Venue / Hotel') }}</strong></td>
        <td style="white-space:normal;width:50%;">{{ optional($weddingSchedule->first_newlywed_preparation->address)->name }}</td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('Address Line 1') }}</strong></td>
        <td style="white-space:normal;width:50%;">{{ optional($weddingSchedule->first_newlywed_preparation->address)->address_line_1 }}</td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('Address Line 2') }}</strong></td>
        <td style="white-space:normal;width:50%;">{{ optional($weddingSchedule->first_newlywed_preparation->address)->address_line_2 }}</td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('State / Province') }}</strong></td>
        <td style="white-space:normal;width:50%;">{{ optional($weddingSchedule->first_newlywed_preparation->address)->state }}</td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('City') }}</strong></td>
        <td style="white-space:normal;width:50%;">{{ optional($weddingSchedule->first_newlywed_preparation->address)->city }}</td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('ZIP / Postcode') }}</strong></td>
        <td style="white-space:normal;width:50%;">{{ optional($weddingSchedule->first_newlywed_preparation->address)->zip }}</td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('Preparation start time') }}</strong></td>
        <td style="white-space:normal;width:50%;">
            @if(($time = $weddingSchedule->first_newlywed_preparation->preparation_start_time) && strpos($time, ':') !== false)
                {{ Illuminate\Support\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}
            @endif
        </td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('Transportation start time') }}</strong></td>
        <td style="white-space:normal;width:50%;">
            @if(($time = $weddingSchedule->first_newlywed_preparation->transportation_start_time) && strpos($time, ':') !== false)
                {{ Illuminate\Support\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}
            @endif
        </td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('Emergency Contact') }}</strong></td>
        <td style="white-space:normal;width:50%;">
        @if($weddingSchedule->second_newlywed_preparation->contact)
            {{ optional($weddingSchedule->first_newlywed_preparation->contact)->first_name }} 
            {{ optional($weddingSchedule->first_newlywed_preparation->contact)->last_name }} 
            ({{ optional($weddingSchedule->first_newlywed_preparation->contact)->telephone }})
        @else
            {{ $weddingSchedule->first_newlywed_preparation->contact_name }} 
            ({{ $weddingSchedule->first_newlywed_preparation->contact_phone }})
        @endif
        </td>
    </tr>
</table>
@endif