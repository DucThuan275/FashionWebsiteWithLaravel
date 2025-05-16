{{-- Toast Container --}}
<div id="toast-container" class="fixed top-4 right-72 z-50 flex flex-col gap-3"></div>

{{-- Session Messages Handler --}}
<script>
    class ToastNotification {
        constructor() {
            this.container = document.getElementById('toast-container');
        }

        show(message, type, title) {
            const toast = this.createToastElement(message, type, title);
            this.container.appendChild(toast);

            // Add appear animation
            requestAnimationFrame(() => {
                toast.classList.add('translate-x-0', 'opacity-100');
            });

            // Auto dismiss after 3 seconds if not clicked
            this.autoDissmissTimeout = setTimeout(() => {
                this.removeToast(toast);
            }, 3000);

            // Click anywhere on toast to dismiss
            toast.addEventListener('click', () => {
                clearTimeout(this.autoDissmissTimeout);
                this.removeToast(toast);
            });
        }

        removeToast(toast) {
            toast.classList.remove('translate-x-0', 'opacity-100');
            toast.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => toast.remove(), 300);
        }

        createToastElement(message, type, title) {
            const configs = {
                success: {
                    bgColor: 'bg-gradient-to-r from-green-500/90 to-emerald-500/90',
                    icon: `<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>`
                },
                error: {
                    bgColor: 'bg-gradient-to-r from-red-500/90 to-rose-500/90',
                    icon: `<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>`
                },
                warning: {
                    bgColor: 'bg-gradient-to-r from-yellow-500/90 to-orange-500/90',
                    icon: `<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>`
                },
                info: {
                    bgColor: 'bg-gradient-to-r from-blue-500/90 to-indigo-500/90',
                    icon: `<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>`
                }
            };

            const config = configs[type];
            const toast = document.createElement('div');

            // Base classes for positioning and transition
            const baseClasses = `
            transform translate-x-full opacity-0 transition-all duration-300 ease-out
            cursor-pointer select-none hover:scale-[0.98] active:scale-[0.97]
        `;

            // Design classes
            const designClasses = `
            flex items-center gap-3 p-4 pr-6 rounded-xl
            ${config.bgColor} backdrop-blur-sm shadow-lg
            hover:shadow-xl hover:brightness-105
        `;

            toast.className = `${baseClasses} ${designClasses}`;

            toast.innerHTML = `
            <div class="flex-shrink-0">
                ${config.icon}
            </div>
            <div class="flex flex-col text-white">
                <h3 class="font-semibold tracking-wide">${title}</h3>
                <p class="text-sm text-white/90">${message}</p>
            </div>
        `;

            return toast;
        }
    }

    // Initialize toast notification
    const toast = new ToastNotification();

    // Handle session messages
    document.addEventListener('DOMContentLoaded', () => {
        @if (session('success'))
            toast.show("{{ session('success') }}", 'success', 'Thành công');
        @endif

        @if (session('error'))
            toast.show("{{ session('error') }}", 'error', 'Lỗi');
        @endif

        @if (session('warning'))
            toast.show("{{ session('warning') }}", 'warning', 'Cảnh báo');
        @endif

        @if (session('info'))
            toast.show("{{ session('info') }}", 'info', 'Thông tin');
        @endif
    });
</script>
