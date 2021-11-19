<div class="row">
    @foreach(NewlywedType::getInstance()->getOptions() as $type => $label)
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-header-title">{{ NewlywedPosition::getInstance()->getOptionLabel($customer->getNewlywedAttribute($type, 'bridegroom')) }}</h4>
            </div>
            <div class="card-body">
                <div class="user-ava mb-5"><img src="{{ $customer->{$type . '_newlywed'}->getAttributeUrl('avatar') }}" /></div>
                <div class="card-details">
                    <span class="card-detail">{{ $customer->getNewlywedAttribute($type, 'first_name') }} {{ $customer->getNewlywedAttribute($type, 'last_name') }}</span>
                    <span class="card-detail">{{ $customer->getNewlywedAttribute($type, 'email') }}</span>
                    <span class="card-detail">{{ $customer->getNewlywedAttribute($type, 'phone') }}</span>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
