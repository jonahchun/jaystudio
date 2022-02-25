@if($form->getInstance()->wedding_schedule && !empty($form->getInstance()->wedding_schedule->current_step))
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                @includeIf('admin::widget.button', [
                    'jsaction' => 'window.open("' . route('admin.customer.print.wedding-schedule', ['customer' => $form->getInstance()->id]) . '")', 
                    'label'    => 'Print',
                    'route'    => 'admin.customer.print.wedding-schedule',
                ])        
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs nav-tabs-info nav-justified">
                    @php
                        $active = 1;
                    @endphp
                    @foreach(\App\WeddingSchedule\Model\Source\Steps::getInstance()->getOptions() as $_value => $label)
                        @if($_value == 'preparation')
                        <li class="nav-item {{ $active++ == 1 ? 'active' : '' }}">
                            <a class="nav-link" data-toggle="tab" href="#schedule_first_newlywed_{{ $_value }}">{{ optional($form->getInstance()->first_newlywed)->first_name . '\'s Preparation' }}</a>
                        </li>
                        <li class="nav-item {{ $active++ == 1 ? 'active' : '' }}">
                            <a class="nav-link" data-toggle="tab" href="#schedule_second_newlywed_{{ $_value }}">{{ optional($form->getInstance()->second_newlywed)->first_name . '\'s Preparation' }}</a>
                        </li>
                        @else
                        <li class="nav-item {{ $active++ == 1 ? 'active' : '' }}">
                            <a class="nav-link" data-toggle="tab" href="#schedule_{{ $_value }}">{{ $label }}</a>
                        </li>
                        @endif
                    @endforeach
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#schedule_other_information">Other Information</a>
                    </li>
                </ul>
                <div class="tab-content">
                    @php
                        $active = 1;
                    @endphp
                    @if($weddingSchedule = $form->getInstance()->wedding_schedule)
                        @foreach(\App\WeddingSchedule\Model\Source\Steps::getInstance()->getOptions() as $_value => $label)
                            @if($_value == 'preparation')
                                <div id="schedule_first_newlywed_{{ $_value }}" class="container tab-pane {{ $active++ == 1 ? 'active' : '' }}">
                                    @include('admin.widget.form.field.wedding_schedule_parts.first_newlywed_' . $_value)
                                </div>
                                <div id="schedule_second_newlywed_{{ $_value }}" class="container tab-pane {{ $active++ == 1 ? 'active' : '' }}">
                                    @include('admin.widget.form.field.wedding_schedule_parts.second_newlywed_' . $_value)
                                </div>
                            @else
                                <div id="schedule_{{ $_value }}" class="container tab-pane {{ $active++ == 1 ? 'active' : '' }}">
                                    @include('admin.widget.form.field.wedding_schedule_parts.' . $_value)
                                </div>
                            @endif
                        @endforeach
                    @endif
                    <div id="schedule_other_information" class="container tab-pane">
                        <label for="basic-textarea">Availability</label>
                        <table class="table table-bordered">
                            <tr>
                                <td style="white-space:normal;width:50%;"><strong>{{ __('Option 1') }}</strong></td>
                                <td style="white-space:normal;width:50%;">{{ ucfirst($weddingSchedule->first_week) }}<br>{{config('availability.'.$weddingSchedule->first_time) }}</td>
                            </tr>
                            <tr>
                                <td style="white-space:normal;width:50%;"><strong>{{ __('Option 2') }}</strong></td>
                                <td style="white-space:normal;width:50%;">{{ ucfirst($weddingSchedule->second_week) }}<br>{{config('availability.'.$weddingSchedule->second_time) }}</td>
                            </tr>
                            <tr>
                                <td style="white-space:normal;width:50%;"><strong>{{ __('Option 3') }}</strong></td>
                                <td style="white-space:normal;width:50%;">{{ ucfirst($weddingSchedule->third_week) }}<br>{{config('availability.'.$weddingSchedule->third_time) }}</td>
                            </tr>
                        </table>
                        <div class="form-group">
                            <label for="basic-textarea">Comment</label>
                            <textarea rows="4" class="form-control" readonly="" disabled="">{{ !empty($value->comment) ? $value->comment : '' }}</textarea>
                        </div>
                        @include('admin::widget.form.field.file', [
                            'value'       => $form->getInstance()->wedding_schedule->file,
                            'readonly'    => true,
                            'publicValue' => $form->getInstance()->wedding_schedule->file ? $form->getInstance()->wedding_schedule->getAttributeUrl('file') : false
                        ])
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif