<div class="info-block__head">
    <h3 class="info-block__title">{{ __('Edit Requests') }}</h3>
    @if($service->canCreateEditRequest())
        @if(in_array($service->type, [\App\Services\Model\Source\Type::PHOTO, \App\Services\Model\Source\Type::VIDEO]))
            <a href="javascript::void(0)" class="link-primary" data-toggle="modal" data-target="#photography_cinematography_edit_request">
                {{ __('Create New') }}
            </a>
        @else
            <a class="link-primary" href="{{ route('service.edit-request.new', ['service' => $service]) }}">
                {{ __('Create New') }}
            </a>
        @endif
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
<div id="photography_cinematography_edit_request" class="modal fade p-0" style="background: #0000006b;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pb-4 px-4 pt-0">
                Please contact us at <a class="text-primary cursor-pointer " href = "mailto:support@jaylimstudio.com"><b style="cursor: pointer">support@jaylimstudio.com</b></a> for edit requests.
            </div>
        </div>
    </div>
</div>

<div class="info-block__note">
    @include('service.parts.status.edit_requests')
</div>
