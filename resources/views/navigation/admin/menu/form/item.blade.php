<li class="dd-item" data-id="{{ $item->id }}">
    <div class="btn-group" style="float: right;">
        <i class="btn btn-danger fa fa-trash-o" data-type="remove-menu-item" style="padding: 5px;"></i>
        <i class="btn btn-primary fa fa-pencil" data-type="edit-menu-item" style="padding: 5px;"></i>
    </div>
    <div class="dd-handle">{{ $item->title }}</div>
    @if(count($item->childrens))
        <ol class="dd-list">
        @foreach($item->childrens as $children)
            @includeIf('navigation::admin.menu.form.item', ['item' => $children])
        @endforeach
        </ol>
    @endif
    @include('navigation::admin.menu.form.item.form', ['item' => $item, 'id' => $item->id])
</li>