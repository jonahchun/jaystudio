<table class="info-table info-table--rounded">
    <colgroup>
        <col style="width: 16%;">
        <col style="width: 17%;">
        <col style="width: 27%;">
        <col style="width: 16%;">
        <col>
    </colgroup>

    @if(Auth::user()->services()->count())
        <thead>
            <tr>
                <td class="text-center">{{ __('Service Name') }}</td>
                <td class="text-center">{{ __('Due Date') }}</td>
                <td class="text-center">{{ __('Comment') }}</td>
                <td class="text-center">{{ __('Status') }}</td>
                <td class="text-center">{{ __('Actions') }}</td>
            </tr>
        </thead>

        <tbody>
        @foreach(Auth::user()->services as $service)
            <tr>
                <td>{{ \App\Services\Model\Source\Type::getInstance()->getOptionLabel($service->type) }}</td>
                <td class="text-center">{{ optional($service->detail)->completion ? $service->detail->completion->format('F dS, Y') : __('TBD') }}</td>
                <td>
                    @include('service.parts.status.short')
                </td>
                <td class="text-center">
                    @include('service.parts.status')
                </td>
                <td class="text-center">
                    @if(in_array($service->type, [\App\Services\Model\Source\Type::PHOTO, \App\Services\Model\Source\Type::VIDEO,\App\Services\Model\Source\Type::ENGAGEMENT_SESSION]))
                    <a class="btn-default--alt mb-2 mb-xl-0 mr-xl-2" href="{{ route('customer.wedding.info') }}">{{ __('Wedding Info') }}</a>
                    @else
                    <a class="btn-default--alt mb-2 mb-xl-0 mr-xl-2" href="{{ route('service.order-form.view', ['service' => $service]) }}">{{ __('Order Form') }}</a>
                    @endif
                    <a class="btn-default--alt" href="{{ route('service.view', ['service' => $service]) }}">{{ __('View') }}</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    @else
        <tbody>
            <tr>
                <td colspan="5">No active services are found under your account</td>
            </tr>
        </tbody>
    @endif
</table>