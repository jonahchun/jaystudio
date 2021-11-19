@if($crumbs = \WFN\CMS\Block\Breadcrumbs::getCrumbs($page))
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        @foreach($crumbs as $crumb)
            <li  class="breadcrumb-item"><a href="{{ $crumb['url'] }}">{{ $crumb['title'] }}</a></li>
        @endforeach
        <li class="breadcrumb-item active" aria-current="page">{{ $page->title }}</li>
    </ol>
</nav>
@endif
