<nav class="additional-nav">
    <ul class="additional-nav__list">
    @foreach($menu->items as $item)
        @include($itemViewName, ['item' => $item, 'itemViewName' => $itemViewName])
    @endforeach
    </ul>
</nav>
