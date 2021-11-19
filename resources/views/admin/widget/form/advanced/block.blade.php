<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                {{ $blockData['title'] }}
                <div class="btn-group float-sm-right">
                    <a href="javascript:void(0);" class="m-2" data-type="remove">Remove</a>
                    <a href="javascript:void(0);" class="m-2" data-type="up"><i class="icon-arrow-up icons"></i></a>
                    <a href="javascript:void(0);" class="m-2" data-type="down"><i class="icon-arrow-down icons"></i></a>
                    <a href="javascript:void(0);" class="m-2" data-type="hide"><i class="icon-minus icons"></i></a>
                    <a href="javascript:void(0);" class="m-2" data-type="show" style="display:none;"><i class="icon-plus icons"></i></a>
                </div>
            </div>
            <div class="card-body">
                @php
                    $iterator = \Illuminate\Support\Str::random(16);
                @endphp
                @foreach($blockData['fields'] as $field)
                    @php
                        $field['value'] = !empty($values[$blockData['key']][$field['name']]) ? $values[$blockData['key']][$field['name']] : ($field['type'] == 'rows' ? [] : false);
                        $field['name'] = 'content[' . $iterator . '][' . $blockData['key'] . '][' . $field['name'] . ']';
                    @endphp
                    <div class="form-group">
                        <label for="basic-{{ $field['type'] }}">
                            {{ $field['label'] }}
                            @if(!empty($field['required']))
                            <em class="text-danger">*</em>
                            @endif
                        </label>
                        @if(View::exists('admin.widget.form.field.' . $field['type']))
                            @include('admin.widget.form.field.' . $field['type'], $field)
                        @else
                            @includeIf('admin::widget.form.field.' . $field['type'], $field)
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>