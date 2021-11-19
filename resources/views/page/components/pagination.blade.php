@if ($paginator->lastPage() > 1)
@php
$currentState = $paginator->perPage();
if($paginator->currentPage() != 1) {
    $currentState = ($paginator->perPage() * ($paginator->currentPage() - 1) + 1) . ' - ';
    if($paginator->perPage() * $paginator->currentPage() > $paginator->total()) {
        $currentState .= $paginator->total();
    } else {
        $currentState .= $paginator->perPage() * $paginator->currentPage();
    }
}
@endphp
<div class="paging">
    <div class="paging__status">Contacts: {{  $currentState  }} from {{ $paginator->total() }}</div>

    <ul class="paging__list">
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <li class="{{ ($paginator->currentPage() == $i) ? 'is-active' : '' }}">
                <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
            </li>
        @endfor    
    </ul>
</div>
@endif