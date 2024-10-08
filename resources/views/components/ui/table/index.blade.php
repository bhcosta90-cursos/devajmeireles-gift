@php use Illuminate\Contracts\Pagination\Paginator; @endphp
@props([
    'records'
])
<div class="overflow-auto rounded-lg shadow ring-1 ring-black ring-opacity-5 custom-scrollbar">
    <table class="min-w-full divide-y divide-gray-300">
        {{ $slot }}

        @if($records->count() === 0)
            <tfoot>
                <x-ui.table.tr>
                    <x-ui.table.td colspan="30" class="text-center text-xl">
                        @lang('No results found.')
                    </x-ui.table.td>
                </x-ui.table.tr>
            </tfoot>
        @endif
    </table>
    @if($records instanceof Paginator && ($records->hasMorePages() || $records->currentPage() > 1))
        <div class="p-3 bg-gray-50 border-t border-t-gray-300">
            <x-ui.pagination :$records/>
        </div>
    @endif
</div>
