<div class="mb-5">
    <label class="block mb-2 text-sm font-medium text-gray-900">
        {{ $slot }}
    </label>
    <input type="{{ $type }}" name="{{ $name }}" class="bg-gray-50 border border-gray-300 text-black text-sm rounded-lg focus:ring-[#2ec4b6] focus:border-blue-500 block w-full p-2.5 " placeholder="{{ $placeholder }}" required />
</div>