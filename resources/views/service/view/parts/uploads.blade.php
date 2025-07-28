<div class="info-block__head">
    <h3 class="info-block__title">{{ $title }}</h3>
</div>
<div class="info-block__table-wrap">
    <table class="info-block__table">
        <colgroup>
            <col style="width: 25%;">
            <col style="width: 30%;">
            <col style="width: 30%;">
            <col style="width: 15%;">
        </colgroup>
        <thead>
            <tr>
                <th class="file">{{ __('File Name') }}</th>
                <th class="date">{{ __('Date Uploaded') }}</th>
                <th class="status">{{ __('Status') }}</th>
                <th class="action">{{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody>
        @if(!$service->uploads()->count())
            <tr>
                <td class="file">
                    <span class="label">{{ __('File Name') }}</span>
                </td>
                <td class="date">
                    <span class="label">{{ __('Date Uploaded') }}</span>
                </td>
                <td class="status">
                    <span class="label">{{ __('Status') }}</span>
                </td>
                <td class="action">
                    <span class="label">{{ __('Action') }}</span>
                </td>
            </tr>
        @else
            @foreach($service->uploads as $upload)
            <tr>
                <td class="file">
                    <span class="label">{{ __('File Name') }}</span>
                    {{ $upload->file_title }}
                </td>
                <td class="date">
                    <span class="label">{{ __('Date Uploaded') }}</span>
                    {{ $upload->created_at->format('d M Y') }}
                </td>
                <td class="status {{ strtolower(str_replace(' ', '-', $upload->status_label )) }}">
                    <span class="label">{{ __('Status') }}</span>
                    {{ $upload->status_label }}
                </td>
                <td class="action">
                    <span class="label">{{ __('Action') }}</span>
                    <div class="row">
                        <a class="action-download" href="{{ $upload->file_url }}" target="_blank">
                            <svg class="action-download-icon">
                                <use xlink:href="#icon-download"></use>
                            </svg>
                            <span class="action-download-title">{{ __('Download') }}</span>
                        </a>
                        @if($upload->status != \App\Services\Model\Source\Upload\Status::REJECTED)
                        <a href="{{ route('service.upload.approve', ['upload' => $upload, 'service' => $service]) }}"
                            class="action-approve @if($upload->status != \App\Services\Model\Source\Upload\Status::PENDING_APPROVAL) disabled @endif">
                            <svg class="action-approve-icon">
                                <use xlink:href="#icon-thumb_up"></use>
                            </svg>
                            <span class="action-approve-title">{{ __('Approve') }}</span>
                        </a>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>
<div class="info-block__note">
    @include('service.parts.status.uploads')
</div>
