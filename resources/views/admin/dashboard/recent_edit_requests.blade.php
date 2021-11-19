<div class="row">
    <div class="col-lg-12">
        <div class="card bg-dark">
            <div class="card-header bg-transparent text-white border-0">
                {{ __('Recent Edit Requests') }}
                <div class="card-action">
                    <a class="btn btn-light mb-2" href="{{ route('admin.customer.service.edit_request') }}">{{ __('View All') }}</a>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead>
                            <tr>
                                <th>{{ __('Account ID / Email') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Initiated') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach(\App\Services\Model\Service\EditRequest::orderBy('created_at', 'desc')->limit(5)->get() as $editRequest)
                            <tr>
                                <td>
                                    <span class="badge bg-secondary text-white">{{ $editRequest->service->customer->account_id }}</span>
                                    <p>{{ $editRequest->service->customer->email }}</p>
                                </td>
                                <td>
                                    {{ $editRequest->service->customer->first_newlywed->first_name }} &
                                    {{ $editRequest->service->customer->second_newlywed->first_name }}
                                </td>
                                <td>{{ \App\Services\Model\Source\EditRequest\Status::getInstance()->getOptionLabel($editRequest->status) }}</td>
                                <td>{{ $editRequest->created_at->format('d F Y') }}</td>
                                <td><a class="btn btn-light btn-sm" href="{{ route('admin.customer.service.edit_request.edit', ['id' => $editRequest->id]) }}">{{ __('Edit') }}</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>