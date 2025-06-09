@props([
    'fields' => [],
    'type' => 'error', // 'success' or 'error'
    'message' => null, // Custom message from outside
])

@php
    // Check if there are validation errors for specified fields
    $hasValidationErrors = collect($fields)->some(fn($field) => $errors->has($field));

    // Check if there's a session error message
$hasSessionError = session('error');

// Check if there's a session success message
    $hasSessionSuccess = session('success');

    // Determine if toast should be shown
    $shouldShow = false;
    $displayMessage = '';
    $displayType = $type;

    if ($type === 'error') {
        if ($hasValidationErrors) {
            $shouldShow = true;
            // Get first validation error message
            foreach ($fields as $field) {
                if ($errors->has($field)) {
                    $displayMessage = $errors->first($field);
                    break;
                }
            }
        } elseif ($hasSessionError) {
            $shouldShow = true;
            $displayMessage = session('error');
        } elseif ($message) {
            $shouldShow = true;
            $displayMessage = $message;
        }
    } elseif ($type === 'success') {
        if ($hasSessionSuccess) {
            $shouldShow = true;
            $displayMessage = session('success');
        } elseif ($message) {
            $shouldShow = true;
            $displayMessage = $message;
        }
    }

    // If we have both success and error, prioritize error
    if ($hasValidationErrors || $hasSessionError) {
        $displayType = 'error';
        if ($hasValidationErrors) {
            foreach ($fields as $field) {
                if ($errors->has($field)) {
                    $displayMessage = $errors->first($field);
                    break;
                }
            }
        } elseif ($hasSessionError) {
            $displayMessage = session('error');
        }
    } elseif ($hasSessionSuccess && !$hasValidationErrors && !$hasSessionError) {
        $displayType = 'success';
        $displayMessage = session('success');
    }

    // Generate unique ID for this toast
    $toastId = 'toast-' . $displayType . '-' . time() . '-' . rand(1000, 9999);

    $toastConfig = [
        'success' => [
            'bg' => 'bg-green-100 border-green-200',
            'textColor' => 'text-green-800',
            'iconBg' => 'bg-green-200 text-green-500',
            'iconPath' =>
                'M16.707 5.293a1 1 0 0 0-1.414 0L9 11.586 6.707 9.293a1 1 0 0 0-1.414 1.414L9 14.414l8-8a1 1 0 0 0-1.414-1.414Z',
            'viewBox' => '0 0 20 20',
        ],
        'error' => [
            'bg' => 'bg-red-100 border-red-200',
            'textColor' => 'text-red-800',
            'iconBg' => 'bg-red-200 text-red-500',
            'iconPath' =>
                'M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z',
            'viewBox' => '0 0 20 20',
        ],
    ];
@endphp

@if ($shouldShow && $displayMessage)
    <div id="{{ $toastId }}"
        class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-sm px-4 py-3 border rounded-xl shadow-xl flex items-center gap-3 transition-all duration-300 {{ $toastConfig[$displayType]['bg'] }} {{ $toastConfig[$displayType]['textColor'] }}"
        role="alert" style="opacity: 1;">

        <!-- Icon -->
        <div class="flex items-center justify-center w-10 h-10 rounded-full {{ $toastConfig[$displayType]['iconBg'] }}">
            <svg class="w-5 h-5" fill="currentColor" viewBox="{{ $toastConfig[$displayType]['viewBox'] }}">
                <path d="{{ $toastConfig[$displayType]['iconPath'] }}" />
            </svg>
        </div>

        <!-- Message -->
        <div class="flex-1 flex items-center">
            <p class="text-sm font-medium leading-5">
                {{ $displayMessage }}
            </p>
        </div>

        <!-- Close Button -->
        <button type="button"
            class="flex items-center justify-center w-8 h-8 rounded-full transition 
                {{ $displayType === 'error' ? 'hover:bg-red-200/50 text-red-600' : 'hover:bg-green-200/50 text-green-600' }}"
            onclick="hideToast('{{ $toastId }}')" aria-label="Close">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <script>
        function hideToast(toastId) {
            const toast = document.getElementById(toastId);
            if (toast) {
                toast.style.opacity = '0';
                toast.style.transform = 'translate(-50%, -20%) scale(0.95)';
                setTimeout(() => {
                    if (toast && toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 300);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const toastElement = document.getElementById('{{ $toastId }}');
            if (toastElement) {
                setTimeout(() => {
                    toastElement.style.opacity = '1';
                    toastElement.style.transform = 'translate(-50%, 0) scale(1)';
                }, 100);
                setTimeout(() => {
                    hideToast('{{ $toastId }}');
                }, 5000);
            }
        });

        if (typeof window.hideToast === 'undefined') {
            window.hideToast = hideToast;
        }
    </script>
@endif
