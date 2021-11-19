<div class="info-block__head">
    <h3 class="info-block__title">{{ __('Edit Requests') }}</h3>
    @if($service->canCreateEditRequest())
    <a class="link-primary" href="{{ route('service.edit-request.new', ['service' => $service]) }}">
        {{ __('Create New') }}
    </a>
    @endif
</div>
<div class="info-block__table-wrap">
    <table class="info-block__table">
        <colgroup>
            <col style="width: 25%;">
            <col style="width: 27%;">
            <col style="width: 30%;">
            <col style="width: 18%;">
        </colgroup>
        <thead>
            <tr>
                <th class="date">{{ __('Date') }}</th>
                <th class="version">{{ __('Version #') }}</th>
                <th class="status">{{ __('Status') }}</th>
                <th class="action">{{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody>
        @if(!$service->edit_requests()->count())
            <tr>
                <td class="date"></td><td class="version"></td><td class="status"></td><td class="action"></td>
            </tr>
        @else
            @foreach($service->edit_requests as $iterator => $request)
            <tr>
                <td class="date">{{ $request->created_at->format('d M Y') }}</td>
                <td class="version">{{ $iterator + 1 }}</td>
                <td class="status {{ strtolower(str_replace(' ', '-', $request->status_label)) }}">{{ $request->status_label }}</td>
                <td class="action">
                    <a class="btn-default--alt" href="{{ route('service.edit-request.view', ['edit_request' => $request, 'service' => $service])}}">
                        {{ __('View') }}
                    </a>
                </td>
            </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>
<div class="info-block__note">
    @include('service.parts.status.edit_requests')    
</div>
