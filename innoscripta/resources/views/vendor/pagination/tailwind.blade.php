{{--@if ($paginator->hasPages())--}}
{{--    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">--}}
{{--        <div class="flex justify-between flex-1 sm:hidden">--}}
{{--            @if ($paginator->onFirstPage())--}}
{{--                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">--}}
{{--                    {!! __('pagination.previous') !!}--}}
{{--                </span>--}}
{{--            @else--}}
{{--                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">--}}
{{--                    {!! __('pagination.previous') !!}--}}
{{--                </a>--}}
{{--            @endif--}}

{{--            @if ($paginator->hasMorePages())--}}
{{--                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">--}}
{{--                    {!! __('pagination.next') !!}--}}
{{--                </a>--}}
{{--            @else--}}
{{--                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">--}}
{{--                    {!! __('pagination.next') !!}--}}
{{--                </span>--}}
{{--            @endif--}}
{{--        </div>--}}

{{--        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">--}}
{{--            <div>--}}
{{--                <p class="text-sm text-gray-700 leading-5">--}}
{{--                    {!! __('Showing') !!}--}}
{{--                    <span class="font-medium">{{ $paginator->firstItem() }}</span>--}}
{{--                    {!! __('to') !!}--}}
{{--                    <span class="font-medium">{{ $paginator->lastItem() }}</span>--}}
{{--                    {!! __('of') !!}--}}
{{--                    <span class="font-medium">{{ $paginator->total() }}</span>--}}
{{--                    {!! __('results') !!}--}}
{{--                </p>--}}
{{--            </div>--}}

{{--            <div>--}}
{{--                <span class="relative z-0 inline-flex shadow-sm rounded-md">--}}
{{--                     Previous Page Link--}}
{{--                    @if ($paginator->onFirstPage())--}}
{{--                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">--}}
{{--                            <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5" aria-hidden="true">--}}
{{--                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">--}}
{{--                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />--}}
{{--                                </svg>--}}
{{--                            </span>--}}
{{--                        </span>--}}
{{--                    @else--}}
{{--                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="{{ __('pagination.previous') }}">--}}
{{--                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">--}}
{{--                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />--}}
{{--                            </svg>--}}
{{--                        </a>--}}
{{--                    @endif--}}

{{--                     Pagination Elements--}}
{{--                    @foreach ($elements as $element)--}}
{{--                         "Three Dots" Separator--}}
{{--                        @if (is_string($element))--}}
{{--                            <span aria-disabled="true">--}}
{{--                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5">{{ $element }}</span>--}}
{{--                            </span>--}}
{{--                        @endif--}}

{{--                         Array Of Links--}}
{{--                        @if (is_array($element))--}}
{{--                            @foreach ($element as $page => $url)--}}
{{--                                @if ($page == $paginator->currentPage())--}}
{{--                                    <span aria-current="page">--}}
{{--                                        <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">{{ $page }}</span>--}}
{{--                                    </span>--}}
{{--                                @else--}}
{{--                                    <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">--}}
{{--                                        {{ $page }}--}}
{{--                                    </a>--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                        @endif--}}
{{--                    @endforeach--}}

{{--                     Next Page Link--}}
{{--                    @if ($paginator->hasMorePages())--}}
{{--                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="{{ __('pagination.next') }}">--}}
{{--                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">--}}
{{--                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />--}}
{{--                            </svg>--}}
{{--                        </a>--}}
{{--                    @else--}}
{{--                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">--}}
{{--                            <span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md leading-5" aria-hidden="true">--}}
{{--                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">--}}
{{--                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />--}}
{{--                                </svg>--}}
{{--                            </span>--}}
{{--                        </span>--}}
{{--                    @endif--}}
{{--                </span>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </nav>--}}
{{--@endif--}}
@if ($paginator->hasPages())
    <div class="col-sm-12 col-md-5">
        <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">
            Showing {{ $start = $paginator->perPage() * ($paginator->currentPage() - 1)+ 1 }} to {{ $start + $paginator->perPage() }} of {{ $paginator->total() }} entries</div>
    </div>
    <div class="col-sm-12 col-md-7">
        <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
            <ul class="pagination">
                <li class="paginate_button page-item previous" id="example2_previous">
                    <a href="{{ $paginator->previousPageUrl() }}" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">
                        Previous
                    </a>
                </li>
                @foreach($elements[0] as $page => $url)

                    @if ($page == $paginator->currentPage())
                        <li class="paginate_button page-item active">
                            <a href="{{ $url }}" aria-controls="example2" data-dt-idx="1" tabindex="0" class="page-link">
                                {{ $page }}
                            </a>
                        </li>
                    @else
                        <li class="paginate_button page-item ">
                            <a href="{{ $url }}" aria-controls="example2" data-dt-idx="1" tabindex="0" class="page-link">
                                {{ $page }}
                            </a>
                        </li>
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <li class="paginate_button page-item next" id="example2_next">
                        <a href="{{ $paginator->nextPageUrl() }}" aria-controls="example2" data-dt-idx="7" tabindex="0" class="page-link">
                            Next
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
@endif
