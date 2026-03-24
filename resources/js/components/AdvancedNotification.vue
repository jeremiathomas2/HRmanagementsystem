<template>
  <div v-if="notifications.length > 0" class="fixed inset-0 z-50 pointer-events-none flex items-center justify-center notification-container">
    <transition-group name="notification" tag="div" class="relative">
      <div
        v-for="notification in notifications"
        :key="notification.id"
        :class="[
          'pointer-events-auto',
          'max-w-md',
          'mx-4',
          'transform',
          'transition-all',
          'duration-300',
          'ease-out',
          getNotificationClasses(notification.type)
        ]"
        class="bg-white rounded-lg shadow-2xl border p-4 mb-4 border-gray-200"
      >
        <div class="flex items-start">
          <div class="flex-shrink-0">
            <div v-html="getIcon(notification.type)"></div>
          </div>
          <div class="ml-3 flex-1">
            <h3 class="text-sm font-medium text-gray-900">
              {{ notification.title }}
            </h3>
            <p class="mt-1 text-sm text-gray-600">
              {{ notification.message }}
            </p>
            <div class="mt-2 flex items-center">
              <div class="flex-shrink-0">
                <span class="text-xs text-gray-500">
                  {{ formatTime(notification.timestamp) }}
                </span>
              </div>
              <div class="ml-auto flex-shrink-0">
                <button
                  @click="removeNotification(notification.id)"
                  class="inline-flex text-gray-400 hover:text-gray-600 focus:outline-none focus:text-gray-600 transition-colors"
                >
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="mt-3">
          <div class="w-full bg-gray-200 rounded-full h-1">
            <div 
              :style="{ width: notification.progress + '%' }"
              :class="getProgressClass(notification.type)"
              class="h-1 rounded-full transition-all duration-100 linear"
            ></div>
          </div>
        </div>
      </div>
    </transition-group>
  </div>
</template>

<script>
export default {
  name: 'AdvancedNotification',
  data() {
    return {
      notifications: [],
      notificationId: 0
    }
  },
  mounted() {
    // Listen for global notification events
    window.addEventListener('notification', this.handleNotification)
  },
  beforeUnmount() {
    window.removeEventListener('notification', this.handleNotification)
  },
  methods: {
    handleNotification(event) {
      this.showNotification(event.detail)
    },
    showNotification(notification) {
      const id = ++this.notificationId
      const newNotification = {
        id,
        ...notification,
        timestamp: Date.now(),
        progress: 100
      }
      
      this.notifications.push(newNotification)
      
      // Auto remove after 3 seconds
      setTimeout(() => {
        this.removeNotification(id)
      }, 3000)
      
      // Progress bar animation
      this.animateProgress(id)
    },
    removeNotification(id) {
      const index = this.notifications.findIndex(n => n.id === id)
      if (index > -1) {
        this.notifications.splice(index, 1)
      }
    },
    animateProgress(id) {
      const duration = 3000 // 3 seconds
      const interval = 50 // Update every 50ms
      const decrement = 100 / (duration / interval)
      
      const timer = setInterval(() => {
        const notification = this.notifications.find(n => n.id === id)
        if (notification) {
          notification.progress = Math.max(0, notification.progress - decrement)
          if (notification.progress <= 0) {
            clearInterval(timer)
          }
        } else {
          clearInterval(timer)
        }
      }, interval)
    },
    getNotificationClasses(type) {
      const classes = {
        success: 'border-green-500 bg-green-50',
        error: 'border-red-500 bg-red-50',
        warning: 'border-yellow-500 bg-yellow-50',
        info: 'border-blue-500 bg-blue-50',
        default: 'border-gray-500 bg-gray-50'
      }
      return classes[type] || classes.default
    },
    getProgressClass(type) {
      const classes = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        warning: 'bg-yellow-500',
        info: 'bg-blue-500',
        default: 'bg-gray-500'
      }
      return classes[type] || classes.default
    },
    getIcon(type) {
      const icons = {
        success: '<svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
        error: '<svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
        warning: '<svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" /></svg>',
        info: '<svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
        default: '<svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>'
      }
      return icons[type] || icons.default
    },
    formatTime(timestamp) {
      const date = new Date(timestamp)
      return date.toLocaleTimeString()
    }
  }
}
</script>

<style scoped>
/* Ensure notifications are always visible */
.notification-enter-active,
.notification-leave-active {
  transition: all 0.3s ease;
}

.notification-enter-from {
  opacity: 0;
  transform: translateX(100%) scale(0.8);
}

.notification-leave-to {
  opacity: 0;
  transform: translateX(-100%) scale(0.8);
}

.notification-move {
  transition: transform 0.3s ease;
}

/* Force notification visibility */
.notification-container {
  position: fixed !important;
  top: 20px !important;
  right: 20px !important;
  z-index: 9999 !important;
  pointer-events: none !important;
}

.notification-container > * {
  pointer-events: auto !important;
}

/* White theme notification styling */
.notification-container .bg-white {
  background: white !important;
  backdrop-filter: none !important;
  -webkit-backdrop-filter: none !important;
}

.notification-container .text-gray-900 {
  color: rgb(17, 24, 39) !important;
}

.notification-container .text-gray-600 {
  color: rgb(75, 85, 99) !important;
}

.notification-container .text-gray-500 {
  color: rgb(107, 114, 128) !important;
}

.notification-container .hover\:text-gray-600:hover {
  color: rgb(55, 65, 81) !important;
}

.notification-container .focus\:text-gray-600:focus {
  color: rgb(55, 65, 81) !important;
}

/* Icon visibility */
.notification-container .text-green-600 {
  color: rgb(22, 163, 74) !important;
}

.notification-container .text-red-600 {
  color: rgb(220, 38, 38) !important;
}

.notification-container .text-yellow-600 {
  color: rgb(202, 138, 4) !important;
}

.notification-container .text-blue-600 {
  color: rgb(37, 99, 235) !important;
}

.notification-container .text-gray-600 {
  color: rgb(107, 114, 128) !important;
}

/* Progress bar styling */
.notification-container .bg-gray-200 {
  background-color: rgb(229, 231, 235) !important;
}

/* Border styling */
.notification-container .border-gray-200 {
  border-color: rgb(229, 231, 235) !important;
}

.notification-container .border-green-500 {
  border-color: rgb(34, 197, 94) !important;
}

.notification-container .border-red-500 {
  border-color: rgb(239, 68, 68) !important;
}

.notification-container .border-yellow-500 {
  border-color: rgb(245, 158, 11) !important;
}

.notification-container .border-blue-500 {
  border-color: rgb(59, 130, 246) !important;
}

.notification-container .border-gray-500 {
  border-color: rgb(107, 114, 128) !important;
}

/* Background colors */
.notification-container .bg-green-50 {
  background-color: rgb(240, 253, 244) !important;
}

.notification-container .bg-red-50 {
  background-color: rgb(254, 242, 242) !important;
}

.notification-container .bg-yellow-50 {
  background-color: rgb(254, 252, 220) !important;
}

.notification-container .bg-blue-50 {
  background-color: rgb(239, 246, 255) !important;
}

.notification-container .bg-gray-50 {
  background-color: rgb(249, 250, 251) !important;
}
</style>
