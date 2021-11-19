<div class="row">
    <div class="col-lg-12">
        <div class="card bg-dark">
            <div class="card-header bg-transparent text-white border-0">
                {{ __('Recent Order Forms') }}
                <div class="card-action">
                    <a class="btn btn-light mb-2" href="{{ route('admin.customer.service') . '?data=' . base64_encode(http_build_query(['status' => \App\Services\Model\Source\Status::ORDER_FORM_SUBMITTED])) }}">
                        {{ __('View All') }}
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead>
                            <tr>
                                <th>{{ __('Account ID / Email') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('Initiated') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach(\App\Services\Model\Service::where('status', \App\Services\Model\Source\Status::ORDER_FORM_SUBMITTED)->orderBy('created_at', 'desc')->limit(5)->get() as $service)
                            <tr>
                                <td>
                                    <span class="badge bg-secondary text-white">{{ $service->customer->account_id }}</span>
                                    <p>{{ $service->customer->email }}</p>
                                </td>
                                <td>
                                    {{ $service->customer->first_newlywed->first_name }} &
                                    {{ $service->customer->second_newlywed->first_name }}
                                </td>
                                <td>{{ \App\Services\Model\Source\Type::getInstance()->getOptionLabel($service->type) }}</td>
                                <td>{{ $service->created_at->format('d F Y') }}</td>
                                <td><a class="btn btn-light btn-sm" href="{{ route('admin.customer.service.edit', ['id' => $service->id]) }}">{{ __('Edit') }}</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>