<div class="popup-add-holder js-popup-add">
    <button class="btn-primary-inverted" type="button">
        {{ __('Add Service') }}
    </button>
        <div class="js-popup popup-overlay">
        <div class="popup-services">
            <button class="js-popup-close btn-close" type="button" aria-label="Close popup"></button>

            <div class="popup-services__txt text-center">
                <h2 class="popup-services__title">{{ __('Select Services to Add') }}</h2>
                <p class="popup-services__description">{!! \Settings::getConfigValue('services/popup_content') !!}</p>
            </div>

            <div class="add-cards">
            @foreach(\App\Core\Model\PickupLocation::orderBy('sort_order', 'asc')->get() as $location)
                <div class="location">
                    <h3 class="location-title">{{ $location->title }}</h3>
                    <p>{!! nl2br($location->address) !!}</p>
                    <a class="location-link" href="tel:{{ $location->getTelephoneAsNumber() }}">{{ $location->telephone }}</a>
                    <p class="location-info">{!! nl2br($location->working_hours) !!}</p>
                </div>
            @endforeach
            </div>

            <div class="text-center">
                <button class="btn-primary js-popup-close">{{ __('Got it') }}</button>
            </div>
        </div>
    </div>
</div>
