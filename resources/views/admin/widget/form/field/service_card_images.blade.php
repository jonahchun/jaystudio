@for($i = 1; $i <= $images_count; $i++)
<div class="row pb-2">
    <div class="col-sm-1">
        <strong>{{ $i }}</strong>
    </div>
    <div class="col-sm-11">
        <input 
            type="text" 
            name="{{ $side }}_side_images[{{ $i }}]" 
            class="form-control" 
            value="{{ optional($form->getInstance()->$name)[$i] }}" />
    </div>
</div>
@endfor