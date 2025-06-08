@props(['route', 'icon'])

@php
    // Tandai aktif jika URL saat ini cocok dengan route atau path-nya
    $isActive = request()->url() === $route || request()->is(parse_url($route, PHP_URL_PATH) . '*');
@endphp

<li>
    <a href="{{ $route }}"
        class="flex items-center p-2 rounded-lg group transition
            {{ $isActive ? 'bg-white text-black font-semibold' : 'text-gray-700 hover:bg-hvrsb hover:text-black' }}">
        <svg xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5 overflow-visible transition duration-75
                {{ $isActive ? 'text-black' : 'text-gray-700 group-hover:text-gray-900' }}"
            width="576" height="512" viewBox="0 0 576 512">
            {!! $icon !!}
        </svg>
        <span class="ms-3">{{ $slot }}</span>
    </a>
</li>
