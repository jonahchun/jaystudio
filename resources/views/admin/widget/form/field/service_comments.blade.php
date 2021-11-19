<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover white-space">
                    <thead>
                        <tr>
                            <th class="align-top"><strong>Date</strong></th>
                            <th class="align-top"><strong>Status</strong></th>
                            <th class="align-top"><strong>Comment</strong></th>
                            <th class="align-top"><strong>Is Customer Notified</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($form->getInstance()->status_history as $history)
                        <tr>
                            <td style="white-space:nowrap;">{{ $history->created_at->format('d M Y  H:i:s') }}</td>
                            <td>{{ \App\Services\Model\Source\Status::getInstance()->getOptionLabel($history->status) }}</td>
                            <td>{{ $history->comment }}</td>
                            <td>
                                @if($history->is_customer_notified)
                                    <h6 class="text-success">Yes</h6>    
                                @else
                                    <h6 class="text-danger">No</h6>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

