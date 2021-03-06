@if($weddingSchedule->reception)
<table class="table table-bordered">
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('Name of Ceremony Location') }}</strong></td>
        <td style="white-space:normal;width:50%;">{{ $weddingSchedule->reception->name_of_reception }}</td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('Address Line 1') }}</strong></td>
        <td style="white-space:normal;width:50%;">{{ optional($weddingSchedule->reception->address)->address_line_1 }}</td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('Address Line 2') }}</strong></td>
        <td style="white-space:normal;width:50%;">{{ optional($weddingSchedule->reception->address)->address_line_2 }}</td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('State / Province') }}</strong></td>
        <td style="white-space:normal;width:50%;">{{ optional($weddingSchedule->reception->address)->state }}</td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('City') }}</strong></td>
        <td style="white-space:normal;width:50%;">{{ optional($weddingSchedule->reception->address)->city }}</td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('ZIP / Postcode') }}</strong></td>
        <td style="white-space:normal;width:50%;">{{ optional($weddingSchedule->reception->address)->zip }}</td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('Coctails Start Time') }}</strong></td>
        <td style="white-space:normal;width:50%;">
            @if($time = $weddingSchedule->reception->cocktails_start_time)
                {{ Illuminate\Support\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}
            @endif
        </td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('Coctails End Time') }}</strong></td>
        <td style="white-space:normal;width:50%;">
            @if($time = $weddingSchedule->reception->cocktails_end_time)
                {{ Illuminate\Support\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}
            @endif
        </td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('Reception Start Time') }}</strong></td>
        <td style="white-space:normal;width:50%;">
            @if($time = $weddingSchedule->reception->reception_start_time)
                {{ Illuminate\Support\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}
            @endif
        </td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('Reception End Time') }}</strong></td>
        <td style="white-space:normal;width:50%;">
            @if($time = $weddingSchedule->reception->reception_end_time)
                {{ Illuminate\Support\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}
            @endif
        </td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('Viennese Start Time') }}</strong></td>
        <td style="white-space:normal;width:50%;">
            @if($time = $weddingSchedule->reception->viennese_start_time)
                {{ Illuminate\Support\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}
            @endif
        </td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('Viennese End Time') }}</strong></td>
        <td style="white-space:normal;width:50%;">
            @if($time = $weddingSchedule->reception->viennese_end_time)
                {{ Illuminate\Support\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}
            @endif
        </td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('Afterparty Start Time') }}</strong></td>
        <td style="white-space:normal;width:50%;">
            @if($time = $weddingSchedule->reception->afterparty_start_time)
                {{ Illuminate\Support\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}
            @endif
        </td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('# of Speeches/Toasts') }}</strong></td>
        <td style="white-space:normal;width:50%;">{{ $weddingSchedule->reception->number_of_toasts }}</td>
    </tr>
    <tr>
        <td style="white-space:normal;width:50%;"><strong>{{ __('Who Will Give Speech/Toast') }}</strong></td>
        <td style="white-space:normal;width:50%;">{{ $weddingSchedule->reception->toast_givers }}</td>
    </tr>
</table>
@endif