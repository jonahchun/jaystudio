<div class="row mt-3">
    <div class="col-12 col-lg-6 col-xl-3">
        <div class="card bg-pattern-primary">
            <div class="card-body">
                <div class="media">
                    <div class="media-body text-left">
                        <h4 class="text-white">{{ \App\Services\Model\Service::count() }}</h4>
                        <span class="text-white">{{ __('Total Services') }}</span>
                    </div>
                    <div class="align-self-center w-circle-icon rounded-circle bg-contrast">
                        <i class="icon-basket-loaded text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6 col-xl-3">
        <div class="card bg-pattern-danger">
            <div class="card-body">
                <div class="media">
                    <div class="media-body text-left">
                        <h4 class="text-white">${{ \App\Payments\Helper\Data::getUnpaidTotalAmount() }}</h4>
                        <span class="text-white">{{ __('Total Unpaid') }}</span>
                    </div>
                    <div class="align-self-center w-circle-icon rounded-circle bg-contrast">
                        <i class="icon-wallet text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6 col-xl-3">
        <div class="card bg-pattern-success">
            <div class="card-body">
                <div class="media">
                    <div class="media-body text-left">
                        <h4 class="text-white">${{ \App\Payments\Helper\Data::getPaidTotalAmount() }}</h4>
                        <span class="text-white">{{ __('Total Paid') }}</span>
                    </div>
                    <div class="align-self-center w-circle-icon rounded-circle bg-contrast">
                        <i class="icon-pie-chart text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6 col-xl-3">
        <div class="card bg-pattern-warning">
            <div class="card-body">
                <div class="media">
                    <div class="media-body text-left">
                        <h4 class="text-white">{{ \Customer::count() }}</h4>
                        <span class="text-white">{{ __('Total Users') }}</span>
                    </div>
                    <div class="align-self-center w-circle-icon rounded-circle bg-contrast">
                        <i class="icon-user text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>