<!-- Advanced Notification Component -->
<div id="notification-container" class="fixed inset-0 z-50 pointer-events-none flex items-center justify-center notification-container">
    <div id="notification-list" class="relative">
        <!-- Notifications will be dynamically added here -->
    </div>
</div>

<script>
// Notification System
class NotificationService {
    constructor() {
        this.notifications = [];
        this.notificationId = 0;
    }

    show(notification) {
        const id = ++this.notificationId;
        const notificationElement = this.createNotificationElement(notification, id);
        
        document.getElementById('notification-list').appendChild(notificationElement);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            this.removeNotification(id);
        }, 3000);
        
        // Animate progress bar
        this.animateProgress(id);
    }

    createNotificationElement(notification, id) {
        const div = document.createElement('div');
        div.className = 'pointer-events-auto max-w-md mx-4 transform transition-all duration-300 ease-out bg-white rounded-lg shadow-2xl border p-4 mb-4 border-gray-200';
        div.dataset.notificationId = id;
        
        const typeClasses = this.getNotificationClasses(notification.type);
        div.className += ' ' + typeClasses;
        
        div.innerHTML = `
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    ${this.getIcon(notification.type)}
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-sm font-medium text-gray-900">${notification.title}</h3>
                    <p class="mt-1 text-sm text-gray-600">${notification.message}</p>
                    <div class="mt-2 flex items-center">
                        <div class="flex-shrink-0">
                            <span class="text-xs text-gray-500">${this.formatTime(notification.timestamp)}</span>
                        </div>
                        <div class="ml-auto flex-shrink-0">
                            <button onclick="notificationService.removeNotification(${id})" class="inline-flex text-gray-400 hover:text-gray-600 focus:outline-none focus:text-gray-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <div class="w-full bg-gray-200 rounded-full h-1">
                    <div id="progress-${id}" class="h-1 rounded-full transition-all duration-100 linear ${this.getProgressClass(notification.type)}" style="width: 100%"></div>
                </div>
            </div>
        `;
        
        return div;
    }

    getNotificationClasses(type) {
        const classes = {
            success: 'border-green-500 bg-green-50',
            error: 'border-red-500 bg-red-50',
            warning: 'border-yellow-500 bg-yellow-50',
            info: 'border-blue-500 bg-blue-50',
            default: 'border-gray-500 bg-gray-50'
        };
        return classes[type] || classes.default;
    }

    getProgressClass(type) {
        const classes = {
            success: 'bg-green-500',
            error: 'bg-red-500',
            warning: 'bg-yellow-500',
            info: 'bg-blue-500',
            default: 'bg-gray-500'
        };
        return classes[type] || classes.default;
    }

    getIcon(type) {
        const icons = {
            success: '<svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 118 0z" /></svg>',
            error: '<svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 118 0z" /></svg>',
            warning: '<svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" /></svg>',
            info: '<svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 118 0z" /></svg>',
            default: '<svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0v1a3 3 0 00-6 0v-1m6 0H9" /></svg>'
        };
        return icons[type] || icons.default;
    }

    animateProgress(id) {
        const duration = 3000; // 3 seconds
        const interval = 50; // Update every 50ms
        const decrement = 100 / (duration / interval);
        
        const timer = setInterval(() => {
            const progressBar = document.getElementById(`progress-${id}`);
            if (progressBar) {
                const currentWidth = parseFloat(progressBar.style.width);
                const newWidth = Math.max(0, currentWidth - decrement);
                progressBar.style.width = newWidth + '%';
                
                if (newWidth <= 0) {
                    clearInterval(timer);
                }
            }
        }, interval);
    }

    removeNotification(id) {
        const notification = document.querySelector(`[data-notification-id="${id}"]`);
        if (notification) {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(-100%) scale(0.8)';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }
    }

    formatTime(timestamp) {
        const date = new Date(timestamp);
        return date.toLocaleTimeString();
    }
}

// Global notification service
window.notificationService = new NotificationService();

// Helper functions for global access
window.showNotification = function(type, title, message) {
    window.notificationService.show({
        type: type,
        title: title,
        message: message,
        timestamp: Date.now()
    });
};

window.showSuccess = function(title, message) {
    window.showNotification('success', title, message);
};

window.showError = function(title, message) {
    window.showNotification('error', title, message);
};

window.showWarning = function(title, message) {
    window.showNotification('warning', title, message);
};

window.showInfo = function(title, message) {
    window.showNotification('info', title, message);
};
</script>
