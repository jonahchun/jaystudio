@if($weddingSchedule->ceremony)
<table class="table table-bordered">
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('Name of Ceremony Location') }}</strong></td>
        <td style="white-space:normal;width:50%;">{{ optional($weddingSchedule->ceremony)->name_of_ceremony }}</td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('Address Line 1') }}</strong></td>
        <td style="white-space:normal;width:50%;">{{ optional($weddingSchedule->ceremony->address)->address_line_1 }}</td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('Address Line 2') }}</strong></td>
        <td style="white-space:normal;width:50%;">{{ optional($weddingSchedule->ceremony->address)->address_line_2 }}</td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('State / Province') }}</strong></td>
        <td style="white-space:normal;width:50%;">{{ optional($weddingSchedule->ceremony->address)->state }}</td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('City') }}</strong></td>
        <td style="white-space:normal;width:50%;">{{ optional($weddingSchedule->ceremony->address)->city }}</td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('ZIP / Postcode') }}</strong></td>
        <td style="white-space:normal;width:50%;">{{ optional($weddingSchedule->ceremony->address)->zip }}</td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('Invitation Start Time') }}</strong></td>
        <td style="white-space:normal;width:50%;">
            @if($time = $weddingSchedule->ceremony->invitation_start_time)
                {{ Illuminate\Support\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}
            @endif
        </td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('Ceremony Start Time') }}</strong></td>
        <td style="white-space:normal;width:50%;">
            @if($time = $weddingSchedule->ceremony->ceremony_start_time)
                {{ Illuminate\Support\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}
            @endif
        </td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('Ceremony End Time') }}</strong></td>
        <td style="white-space:normal;width:50%;">
            @if($time = $weddingSchedule->ceremony->ceremony_end_time)
                {{ Illuminate\Support\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}
            @endif
        </td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('Ceremony Settings') }}</strong></td>
        <td style="white-space:normal;width:50%;">{{ $weddingSchedule->ceremony->settings_label }}</td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('Ceremony Details') }}</strong></td>
        <td style="white-space:normal;width:50%;">
        @if(is_array($weddingSchedule->ceremony->detail_labels))
            @foreach($weddingSchedule->ceremony->detail_labels as $detail)
                <p>{{ $detail }}</p>
            @endforeach
        @endif
        </td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('Ceremony Traditions') }}</strong></td>
        <td style="white-space:normal;width:50%;">
        @if(is_array($weddingSchedule->ceremony->ceremony_tradition_labels))
            @foreach($weddingSchedule->ceremony->ceremony_tradition_labels as $tradition)
                <p>{{ $tradition }}</p>
            @endforeach
        @endif
        </td>
    </tr>
</table>
@endif