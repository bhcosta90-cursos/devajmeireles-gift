@php use Illuminate\Contracts\Pagination\Paginator; @endphp
@props([
    'records'
])
<div class="overflow-auto rounded-lg shadow ring-1 ring-black ring-opacity-5 custom-scrollbar">
    <table class="min-w-full divide-y divide-gray-300">
        {{ $slot }}
    </table>
    @if($records instanceof Paginator)
        <div class="p-3 bg-gray-50 border-t border-t-gray-300">
            {!! $records->links() !!}
        </div>
    @endif
</div>
