@props([
    'records'
])

@if($records->hasMorePages() || $records->currentPage() > 1)
    <div {{ $attributes }}>
        {!! $records->links() !!}
    </div>
@endif
