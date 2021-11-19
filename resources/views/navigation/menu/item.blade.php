<li class="additional-nav__list-item">
    <a href="{{ $item->link }}" {{ $item->link_target == \WFN\Navigation\Model\Source\LinkTarget::BLANK ? 'target="_blank"' : '' }} >
        {{ $item->title }}
    </a>
</li>
