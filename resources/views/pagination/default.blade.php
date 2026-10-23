@if ($paginator->hasPages())
<nav class="pager">
    @if ($paginator->onFirstPage())
        <span class="is-disabled">Önceki</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}">Önceki</a>
    @endif
    <span>{{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}</span>
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}">Sonraki</a>
    @else
        <span class="is-disabled">Sonraki</span>
    @endif
</nav>
@endif
