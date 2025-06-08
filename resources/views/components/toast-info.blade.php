@props([
    'fields' => [],
    'type' => 'error', // 'success' atau 'error'
    'message' => null, // Pesan bisa dikustom dari luar
])

@php
    $hasAnyError = collect($fields)->some(fn($field) => $errors->has($field));
    $shouldShow = $type === 'error' ? $hasAnyError : session('success') || $message;

    $toastConfig = [
        'success' => [
            'bg' => 'bg-green-100 text-green-700',
            'iconBg' => 'bg-green-200 text-green-600',
            'iconPath' =>
                'M16.707 5.293a1 1 0 0 0-1.414 0L9 11.586 6.707 9.293a1 1 0 0 0-1.414 1.414L9 14.414l8-8a1 1 0 0 0-1.414-1.414Z',
            'defaultMessage' => 'Data berhasil disimpan.',
        ],
        'error' => [
            'bg' => 'bg-red-100 text-red-700',
            'iconBg' => 'bg-red-200 text-red-600',
            'iconPath' =>
                'M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z',
            'defaultMessage' => 'Harap isi semua kolom yang diperlukan.',
        ],
    ];

    $toastMessage =
        $message ??
        ($type === 'error' ? ($hasAnyError ? $toastConfig[$type]['defaultMessage'] : null) : session('success'));
@endphp

@if ($shouldShow && $toastMessage)
    <div id="toast-{{ $type }}"
        class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-xs p-4 {{ $toastConfig[$type]['bg'] }} rounded-lg shadow flex items-center space-x-3"
        role="alert">

        <!-- Icon -->
        <div class="flex items-center justify-center w-8 h-8 {{ $toastConfig[$type]['iconBg'] }} rounded-full">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="{{ $toastConfig[$type]['iconPath'] }}" />
            </svg>
        </div>

        <!-- Text -->
        <div class="flex-1 text-sm font-medium">
            {{ $toastMessage }}
        </div>

        <!-- Close Button -->
        <button type="button"
            class="text-gray-400 hover:text-gray-600 focus:outline-none flex items-center justify-center h-6 w-6"
            data-dismiss-target="#toast-{{ $type }}" aria-label="Close">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
@endif
