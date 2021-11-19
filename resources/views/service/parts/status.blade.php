@if($label = \App\Services\Model\Source\Status::getInstance()->getOptionLabel($service->status))
    <span class="label-status {{ strtolower(str_replace(' ', '-', $label)) }}">{{ $label }}</span>
@endif
