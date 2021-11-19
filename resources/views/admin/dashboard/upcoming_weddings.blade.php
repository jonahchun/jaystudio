<div class="row">
    <div class="col-lg-12">
        <div class="card bg-dark">
            <div class="card-header bg-transparent text-white border-0">
                {{ __('Upcoming Weddings') }}
                <div class="card-action">
                    <a class="btn btn-light mb-2" href="{{ route('admin.customer') }}">{{ __('View All') }}</a>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead>
                            <tr>
                                <th>{{ __('First Newlywed') }}</th>
                                <th>{{ __('Second Newlywed') }}</th>
                                <th>{{ __('Wedding Date') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach(\App\Customer\Helper\Data::getCustomersWithUpcomingWedding() as $customer)
                            <tr>
                                <td>
                                    <span class="badge bg-secondary text-white">
                                        {{ \App\Customer\Model\Source\NewlywedPosition::getInstance()->getOptionLabel($customer->first_newlywed->bridegroom) }}
                                    </span>
                                    <p>{{ $customer->first_newlywed->first_name . ' ' . $customer->first_newlywed->last_name }}</p>
                                </td>
                                <td>
                                    <span class="badge bg-secondary text-white">
                                        {{ \App\Customer\Model\Source\NewlywedPosition::getInstance()->getOptionLabel($customer->second_newlywed->bridegroom) }}
                                    </span>
                                    <p>{{ $customer->second_newlywed->first_name . ' ' . $customer->second_newlywed->last_name }}</p>
                                </td>
                                <td>{{ $customer->wedding_date->format(config('app.date_format')) }}</td>
                                <td><a class="btn btn-light btn-sm" href="{{ route('admin.customer.edit', ['id' => $customer->id]) }}">{{ __('Edit') }}</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>