@if($form->getInstance()->wedding_schedule)
    @php
        $customer = $form->getInstance();
        $weddingSchedule = $customer->wedding_schedule;
        $steps = \App\WeddingSchedule\Model\Source\Steps::getInstance()->getOptions();
        $printRoute = route('admin.customer.print.wedding-schedule', ['customer' => $customer->id]);
    @endphp

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    @includeIf('admin::widget.button', [
                        'jsaction' => 'window.open("' . $printRoute . '")',
                        'label'    => 'Print',
                        'route'    => 'admin.customer.print.wedding-schedule',
                    ])
                </div>
                <div class="card-body">
                    <!-- Tabs Navigation -->
                    <ul class="nav nav-tabs nav-tabs-info nav-justified">
                        @php $active = 1; @endphp
                        @foreach($steps as $value => $label)
                            @if($value == 'preparation')
                                <li class="nav-item {{ $active++ == 1 ? 'active' : '' }}">
                                    <a class="nav-link" data-toggle="tab" href="#schedule_first_newlywed_{{ $value }}">
                                        {{ optional($customer->first_newlywed)->first_name }}'s Preparation
                                    </a>
                                </li>
                                <li class="nav-item {{ $active++ == 1 ? 'active' : '' }}">
                                    <a class="nav-link" data-toggle="tab" href="#schedule_second_newlywed_{{ $value }}">
                                        {{ optional($customer->second_newlywed)->first_name }}'s Preparation
                                    </a>
                                </li>
                            @else
                                <li class="nav-item {{ $active++ == 1 ? 'active' : '' }}">
                                    <a class="nav-link" data-toggle="tab" href="#schedule_{{ $value }}">{{ $label }}</a>
                                </li>
                            @endif
                        @endforeach
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#schedule_other_information">Other
                                Information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#wedding_schedule">Wedding schedule</a>
                        </li>
                    </ul>

                    <!-- Tabs Content -->
                    <div class="tab-content">
                        @php $active = 1; @endphp
                        @foreach($steps as $value => $label)
                            @if($value == 'preparation')
                                <div id="schedule_first_newlywed_{{ $value }}"
                                     class="container tab-pane {{ $active++ == 1 ? 'active' : '' }}">
                                    @include('admin.widget.form.field.wedding_schedule_parts.first_newlywed_' . $value)
                                </div>
                                <div id="schedule_second_newlywed_{{ $value }}"
                                     class="container tab-pane {{ $active++ == 1 ? 'active' : '' }}">
                                    @include('admin.widget.form.field.wedding_schedule_parts.second_newlywed_' . $value)
                                </div>
                            @else
                                <div id="schedule_{{ $value }}"
                                     class="container tab-pane {{ $active++ == 1 ? 'active' : '' }}">
                                    @include('admin.widget.form.field.wedding_schedule_parts.' . $value)
                                </div>
                            @endif
                        @endforeach

                        <!-- Other Information Tab -->
                        <div id="schedule_other_information" class="container tab-pane">
                            <label for="basic-textarea">Availability</label>
                            <table class="table table-bordered">
                                @foreach(['first', 'second', 'third'] as $option)
                                    <tr>
                                        <td style="white-space:normal;width:50%;">
                                            <strong>{{ __("Option " . ($loop->iteration)) }}</strong>
                                        </td>
                                        <td style="white-space:normal;width:50%;">
                                            {{ ucfirst($weddingSchedule->{"{$option}_week"}) }}<br>
                                            {{ config('availability.' . $weddingSchedule->{"{$option}_time"}) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>

                            <div class="form-group">
                                <label for="basic-textarea">Comment</label>
                                <textarea rows="4" class="form-control" readonly disabled>
                                {{ $weddingSchedule->comment ?? '' }}
                            </textarea>
                            </div>

                            @include('admin::widget.form.field.file', [
                                'value'       => $weddingSchedule->file,
                                'readonly'    => true,
                                'publicValue' => $weddingSchedule->file ? $weddingSchedule->getAttributeUrl('file') : false
                            ])
                        </div>
                        <div id="wedding_schedule" class="container tab-pane">
                            @php
                                $readonly = $id = false;
                                $name = 'wedding_schedule';
                                $value = $weddingSchedule->ws_file;
                                $publicValue = $weddingSchedule->ws_file ? $weddingSchedule->getAttributeUrl('file') : false;
                            @endphp
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="hidden" @if(!empty($readonly)) disabled="disabled" @endif class="{{$name}}" name="{{ $name }}" value="{{ $value }}" />
                                    <input type="file" @if(!empty($readonly)) disabled="disabled" @endif name="{{ $name }}[ws-file]" class="custom-file-input" id="{{ !empty($id) ? $id : $name }}FileInput" value="{{ $value }}" />
                                    <label class="custom-file-label" for="{{ !empty($id) ? $id : $name }}FileInput">{{ $value ?: 'Choose file' }}</label>
                                </div>
                                @if(!empty($publicValue) || (!empty($form) && is_callable([$form->getInstance(), 'getAttributeUrl']) && $publicValue = $form->getInstance()->getAttributeUrl($name)))
                                    <div class="input-group-append">
                                        @if(($field['name'] == 'wedding_schedule' || $field['name'] == 'wedding_checklist' || $field['name'] =="file"))
                                            @if($value != '')
                                                <a href="/storage/customer-wedding-schedule/{{ $value }}" class="download_files" id="{{$name}}" data-attr="{{$field['name']}}">View</a>
                                            @endif
                                        @else
                                            <a href="{{ $publicValue }}" target="_blank" class="download_files">View</a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
