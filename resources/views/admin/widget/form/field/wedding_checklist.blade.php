@if($form->getInstance()->wedding_checklist && !empty($form->getInstance()->wedding_checklist->current_step))
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                @includeIf('admin::widget.button', [
                    'jsaction' => 'window.open("' . route('admin.customer.print.wedding-checklist', ['customer' => $form->getInstance()->id]) . '")', 
                    'label'    => 'Print',
                    'route'    => 'admin.customer.print.wedding-checklist',
                ])        
            </div>
            <div class="card-body"> 
                <ul class="nav nav-tabs nav-tabs-info nav-justified">
                    @php
                        $active = 1;
                    @endphp
                    @foreach(\App\WeddingChecklist\Model\Source\Steps::getInstance()->getOptions() as $_value => $label)
                    <li class="nav-item {{ $active++ == 1 ? 'active' : '' }}">
                        <a class="nav-link" data-toggle="tab" href="#checklist_{{ $_value }}">{{ $label }}</a>
                    </li>
                    @endforeach
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#checklist_other_information">Other Information</a>
                    </li>
                </ul>
                <div class="tab-content">
                    @php
                        $entities = \App\WeddingChecklist\Model\ChecklistEntities::getEntities();
                        $active = 1;
                    @endphp
                    @foreach(\App\WeddingChecklist\Model\Source\Steps::getInstance()->getOptions() as $_value => $label)
                    <div id="checklist_{{ $_value }}" class="container tab-pane {{ $active++ == 1 ? 'active' : '' }}">
                        @if($_value == \App\WeddingChecklist\Model\Source\Steps::CINEMATOGRAPHY)
                            <table class="table table-bordered">
                                <tr>
                                    <td style="white-space:normal;width:50%;"><strong>{{ __('I want to have music picked by') }}</strong></td>
                                    <td style="white-space:normal;width:50%;">
                                        @switch($form->getInstance()->music)
                                            @case(1)
                                                {{ __('JAYlim Studio') }}
                                                @break
                                            @case(2)
                                                {{ __('Myself') }}
                                                @break
                                            @case(3)
                                                {{ __('No Cinematography Service') }}
                                                @break
                                        @endswitch
                                    </td>
                                </tr>
                                @if($form->getInstance()->music != 3)
                                    <tr>
                                        <td style="white-space:normal;width:50%;"><strong>{{ __('Song List') }}</strong></td>
                                        <td style="white-space:normal;width:50%;"></td>
                                    </tr>
                                    @if($form->getInstance()->music_songs)
                                        @foreach($form->getInstance()->music_songs as $song)
                                        <tr>
                                            <td style="white-space:normal;width:50%;"><strong>{{ $song->song_name }}</strong></td>
                                            <td style="white-space:normal;width:50%;">
                                                @switch($song->type)
                                                    @case(1)
                                                        {{ __('Highlight Reel') }}
                                                        @break
                                                    @case(2)
                                                        {{ __('Full Video') }}
                                                        @break
                                                @endswitch
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
                                @endif
                            </table>
                        @elseif($_value !== \App\WeddingChecklist\Model\Source\Steps::VENDORS)
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Yes / No</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($entities[$_value] as $entity)
                                    <tr>
                                        <td style="white-space:normal;width:50%;"><strong>{{ $entity->title }}</strong></td>
                                        <td style="white-space:normal;width:50%;">
                                            @if(!empty($value[$_value][$entity->id]['value']))
                                                <h6 class="text-success">Yes</h6>
                                            @else
                                                <h6 class="text-danger">No</h6>
                                            @endif
                                        </td>
                                        <td style="white-space:normal;width:50%;">
                                            {{ !empty($value[$_value][$entity->id]['details']) ? $value[$_value][$entity->id]['details'] : '' }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="form-group">
                                <label for="basic-textarea">Other Comments</label>
                                <textarea rows="4" class="form-control" readonly="" disabled="">{{ !empty($value[$_value]['comment']) ? $value[$_value]['comment'] : '' }}</textarea>
                            </div>
                        @else
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Name / Company</th>
                                        <th>Social Media Handle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($entities['vendors'] as $vendor)
                                    <tr>
                                        <td style="white-space:normal;width:50%;"><strong>{{ $vendor->title }}</strong></td>
                                        <td style="white-space:normal;width:50%;">
                                            {{ !empty($value->vendors[$vendor->id]['company']) ? $value->vendors[$vendor->id]['company'] : '---' }}
                                        </td>
                                        <td style="white-space:normal;width:50%;">
                                            {{ !empty($value->vendors[$vendor->id]['socials']) ? $value->vendors[$vendor->id]['socials'] : '---' }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                    @endforeach
                    <div id="checklist_other_information" class="container tab-pane">
                        <div class="form-group">
                            <label for="basic-textarea">Comment</label>
                            <textarea rows="4" class="form-control" readonly="" disabled="">{{ !empty($value->comment) ? $value->comment : '' }}</textarea>
                        </div>
                        @include('admin::widget.form.field.file', [
                            'value'       => $form->getInstance()->wedding_checklist->file,
                            'readonly'    => true,
                            'publicValue' => $form->getInstance()->wedding_checklist->file ? $form->getInstance()->wedding_checklist->getAttributeUrl('file') : false
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif