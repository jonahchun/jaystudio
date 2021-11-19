<div class="info-panels row">
    @foreach(NewlywedType::getInstance()->getOptions() as $type => $label)
    <div class="col-lg-6 col-xl-4">
        <div class="info-panel">
            <div class="info-panel__icon">
                <svg class="icon icon-ring"><use xlink:href="#icon-ring"></use></svg>
            </div>
            <div class="info-panel__content">
                <span class="info-panel__ttl">{{ NewlywedPosition::getInstance()->getOptionLabel(Auth::user()->getNewlywedAttribute($type, 'bridegroom')) }}</span>
                <span class="info-panel__txt">
            {{ sprintf('%s %s', Auth::user()->getNewlywedAttribute($type, 'first_name'), Auth::user()->getNewlywedAttribute($type, 'last_name')) }}
        </span>
            </div>
        </div>
    </div>
    @endforeach

    <div class="col-lg-6 col-xl-4">
        <div class="info-panel">
            <div class="info-panel__icon">
                <svg class="icon icon-calendar"><use xlink:href="#icon-calendar"></use></svg>
            </div>
            <div class="info-panel__content">
                <span class="info-panel__ttl">{{ __('Wedding Date') }}</span>
                <span class="info-panel__txt">{{ Auth::user()->wedding_date->format('l, F d, Y') }}</span>
            </div>
        </div>
    </div>
</div>