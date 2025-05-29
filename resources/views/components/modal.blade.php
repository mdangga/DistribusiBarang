@props(['id', 'header', 'button', 'actionRoute', 'methodOverride' => 'POST'])
<div id="{{ $id }}" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-16 md:top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 md:p-6 border-b rounded-t border-gray-200">
                {{ $iconheader ?? '' }}
                <h3 class="text-lg font-semibold text-gray-900 w-72 truncate">{{ $header }}</h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 active:text-red-400 transition rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-toggle="{{ $id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <!-- Form -->
            <form class="p-4 md:p-5" action="{{ $actionRoute }}" method="POST">
                @csrf

                @if (strtoupper($methodOverride) === 'PUT' ||
                        strtoupper($methodOverride) === 'PATCH' ||
                        strtoupper($methodOverride) === 'DELETE')
                    @method($methodOverride)
                @endif
                {!! $slot !!}
                <button type="submit"
                    class="text-white inline-flex items-center bg-[#ff9f1c] hover:bg-[#ffbf69] transition focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    {{ $iconbtn ?? '' }}
                    </svg>
                    {{ $button }}
                </button>
            </form>
        </div>
    </div>
</div>
