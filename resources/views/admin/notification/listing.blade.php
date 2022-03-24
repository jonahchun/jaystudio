@extends('admin::layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-header-title">{{ __('Notifications') }}</h4>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="align-top"><strong>ID</strong></th>
                            <th class="align-top"><strong>Names</strong></th>
                            <th class="align-top"><strong>Field Name</strong></th>
                            <th class="align-top"><strong>Notification</strong></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
