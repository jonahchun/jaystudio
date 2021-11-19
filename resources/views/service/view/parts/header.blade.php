<div class="d-flex justify-content-between flex-wrap">
    <div class="d-flex align-items-baseline">
        <h2 class="mr-4">{{ $title }}</h2>
        @include('service.parts.status')
    </div>
    <span class="date">
        {{ __('Completion: :completion', ['completion' => optional($service->detail)->completion ? $service->detail->completion->format('F dS, Y') : __('TBD')]) }}
    </span>
</div>

<div class="col-xl-5 mt-2 mb-4 pl-0">
    @include('service.parts.status.short')    
</div>

<div class="col-9 pl-0">
    <h2>{{ __('Information') }}</h2>
    @include('service.parts.status.long')
</div>
