<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                @include('admin.widget.form.field.edit_request.' . $form->getInstance()->service->type . '_details', ['edit_request' => $form->getInstance()])
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row pt-4">
                    <div class="col-md-3">
                        <strong>{{ __('Comment') }}</strong>
                    </div>
                    <div class="col-md-9">
                        {{ $form->getInstance()->comment }}
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-md-3">
                        <strong>File</strong>
                    </div>
                    <div class="col-md-9">
                        @if($form->getInstance()->file)
                            <a href="{{ $form->getInstance()->getAttributeUrl('file') }}" target="_blank">{{ __('Open') }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>