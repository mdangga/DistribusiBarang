@props(['route', 'icon'])

<li>
    <a href="{{ $route }}" class="flex items-center p-2 text-gray-700 rounded-lg  hover:bg-gray-100 group">
        <svg xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5 text-gray-700 transition duration-75  group-hover:text-gray-900" width="576" height="512"
            viewBox="0 0 576 512">
            {!! $icon !!}
        </svg>
        <span class="ms-3">{{ $slot }}</span>
    </a>
</li>
