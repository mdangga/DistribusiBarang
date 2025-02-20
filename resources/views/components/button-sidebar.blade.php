@props(['route', 'icon'])

<li>
    <a href="{{ $route }}" {{ $attributes->merge(['class' => 'flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100']) }}>
        <svg 
            class="w-5 h-5 text-gray-500 transition duration-75" 
            aria-hidden="true" 
            xmlns="http://www.w3.org/2000/svg" 
            fill="currentColor" 
            viewBox="0 0 24 24"
        >
            {!! $icon !!}
        </svg>
        <span class="ms-3">{{ $slot }}</span>
    </a>
</li>