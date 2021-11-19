@extends('admin::layouts.app')

@section('content')
<div class="container-fluid">
    @include('admin.dashboard.statistics')
    @include('admin.dashboard.recent_order_forms')
    @include('admin.dashboard.recent_edit_requests')
    @include('admin.dashboard.recent_approved_layouts')
    @include('admin.dashboard.upcoming_weddings')
    <div class="row">
        @include('admin.dashboard.recent_invoices')
        @include('admin.dashboard.invoices_stat')
    </div>
</div>
@endsection
