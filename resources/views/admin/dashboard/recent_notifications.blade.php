<div class="row">
    <div class="col-lg-12">
        <div class="card bg-dark">
            <div class="card-header bg-transparent text-white border-0">
                {{ __('Recent Notifications') }}
                <div class="card-action">
                    <a class="btn btn-light mb-2" href="{{ route('admin.notification') }}">
                        {{ __('View All') }}
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead>
                            <tr>
                                <th>{{ __('Account ID')}}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Form Name') }}</th>
                                <th>{{ __('Notification Details') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach(\App\Notification\Model\Notification::orderBy('created_at', 'desc')->limit(5)->get() as $notification)
                        <?php
                            $notifDetail = '';
                            if($notification->customer_type == \App\Notification\Model\Notification::NEW_CUSTOMER_TYPE){
                                $notifDetail = \App\Notification\Model\Notification::NOTIF_MSG_1;
                            }else{
                                $stepForType1 = \App\Notification\Model\Notification::STEP_FOR_TYPE_1;
                                $stepForType2 = \App\Notification\Model\Notification::STEP_FOR_TYPE_2;
                                $stepForType3 = \App\Notification\Model\Notification::STEP_FOR_TYPE_3;

                                $step = [];
                                if($notification->form_type == \App\Notification\Model\Notification::FORM_TYPE_1){
                                    $step =  $stepForType1;
                                }else if($notification->form_type == \App\Notification\Model\Notification::FORM_TYPE_2){
                                    $step =  $stepForType2;
                                }else if($notification->form_type == \App\Notification\Model\Notification::FORM_TYPE_3){
                                    $step =  $stepForType3;
                                }
                                $fieldName = json_decode($notification->field_name,true);

                                if($fieldName == ''){
                                    $fieldName = $notification->field_name;
                                }else{
                                    $fieldName = (is_array($fieldName)?implode(",",$fieldName):$fieldName);
                                }
                                $notifDetail = $step[$notification->form_steps - 1].' | '.(is_array($fieldName)?implode(",",$fieldName):$fieldName);
                                //dd($step);
                            }
                        ?>
                            <tr>
                                <td>
                                    <span class="badge bg-secondary text-white">{{ $notification->customer->account_id }}</span>
                                </td>
                                <td>
                                    {{ $notification->customer->first_newlywed->first_name }} &
                                    {{ $notification->customer->second_newlywed->first_name }}
                                </td>
                                <td>{{ ($notification->form_types) }}</td>
                                <td>
                                {{$notifDetail}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
