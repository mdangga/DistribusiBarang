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
            'bg' => 'bg-green-50 border-green-200',
            'textColor' => 'text-green-800',
            'iconBg' => 'bg-green-100 text-green-500',
            'iconPath' => 'M16.707 5.293a1 1 0 0 0-1.414 0L9 11.586 6.707 9.293a1 1 0 0 0-1.414 1.414L9 14.414l8-8a1 1 0 0 0-1.414-1.414Z',
            'viewBox' => '0 0 20 20',
        ],
        'error' => [
            'bg' => 'bg-red-50 border-red-200',
            'textColor' => 'text-red-800',
            'iconBg' => 'bg-red-100 text-red-500',
            'iconPath' => 'M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z',
            'viewBox' => '0 0 20 20',
        ],
    ];
@endphp

@if ($shouldShow && $displayMessage)
    <div id="{{ $toastId }}"
        class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md p-4 mb-4 border rounded-lg shadow-lg {{ $toastConfig[$displayType]['bg'] }} {{ $toastConfig[$displayType]['textColor'] }} transition-all duration-300 ease-in-out"
        role="alert"
        style="opacity: 1;">
        
        <div class="flex items-start">
            <!-- Icon -->
            <div class="flex items-center justify-center w-8 h-8 {{ $toastConfig[$displayType]['iconBg'] }} rounded-lg flex-shrink-0">
                <svg class="w-4 h-4" fill="currentColor" viewBox="{{ $toastConfig[$displayType]['viewBox'] }}">
                    <path d="{{ $toastConfig[$displayType]['iconPath'] }}" />
                </svg>
            </div>

            <!-- Message -->
            <div class="flex-1 ml-3 text-sm font-medium">
                {{ $displayMessage }}
            </div>

            <!-- Close Button -->
            <button type="button"
                class="ml-auto -mx-1.5 -my-1.5 {{ $toastConfig[$displayType]['textColor'] }} hover:{{ $toastConfig[$displayType]['textColor'] }}/80 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8"
                onclick="hideToast('{{ $toastId }}')"
                aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <script>
        // Function to hide toast with animation
        function hideToast(toastId) {
            const toast = document.getElementById(toastId);
            if (toast) {
                toast.style.opacity = '0';
                toast.style.transform = 'translate(-50%, -100%) scale(0.9)';
                setTimeout(() => {
                    if (toast && toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 300);
            }
        }

        // Auto-hide toast after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const toastElement = document.getElementById('{{ $toastId }}');
            if (toastElement) {
                // Show toast with animation
                setTimeout(() => {
                    toastElement.style.opacity = '1';
                    toastElement.style.transform = 'translate(-50%, 0) scale(1)';
                }, 100);

                // Auto-hide after 5 seconds
                setTimeout(() => {
                    hideToast('{{ $toastId }}');
                }, 5000);
            }
        });

        // Make hideToast function globally available
        if (typeof window.hideToast === 'undefined') {
            window.hideToast = function(toastId) {
                const toast = document.getElementById(toastId);
                if (toast) {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translate(-50%, -100%) scale(0.9)';
                    setTimeout(() => {
                        if (toast && toast.parentNode) {
                            toast.parentNode.removeChild(toast);
                        }
                    }, 300);
                }
            };
        }
    </script>
@endif