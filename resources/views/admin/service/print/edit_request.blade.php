@extends('admin.layouts.print')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-header-title">{{ __('Edit Request') }}</h2>
            </div>
            <br />
            <div class="card-body">
                @include('admin.widget.form.field.edit_request.' . $edit_request->service->type . '_details')
                <br /><br />
                <h3>{{ __('Other') }}</h3>
                <table class="table">
                    <tbody>
                        <tr>
                            <td>{{ __('Comment') }}</td>
                            <td>{{ $edit_request->comment }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection