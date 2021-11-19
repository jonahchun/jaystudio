@if($label = \App\Services\Model\Source\Status::getInstance()->getOptionLabel($service->status))
    <div class="warning-panel mb-0 {{ strtolower(str_replace(' ', '-', $label)) }}">
        <svg class="icon icon-warning"><use xlink:href="#icon-warning"></use></svg>
        <p>{!! \App\Services\Helper\Status::getShortStatus($service) !!}</p>                
    </div>
@endif