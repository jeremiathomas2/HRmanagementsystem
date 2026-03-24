// Global Notification Service
class NotificationService {
  constructor() {
    this.listeners = []
  }

  // Subscribe to notification events
  subscribe(listener) {
    this.listeners.push(listener)
  }

  // Unsubscribe from notification events
  unsubscribe(listener) {
    const index = this.listeners.indexOf(listener)
    if (index > -1) {
      this.listeners.splice(index, 1)
    }
  }

  // Emit notification event
  emit(notification) {
    this.listeners.forEach(listener => {
      if (typeof listener === 'function') {
        listener(notification)
      } else if (listener.handleNotification) {
        listener.handleNotification(notification)
      }
    })

    // Also emit to window event for components
    window.dispatchEvent(new CustomEvent('notification', {
      detail: notification
    }))
  }

  // Show success notification
  success(title, message) {
    this.emit({
      type: 'success',
      title,
      message,
      timestamp: Date.now()
    })
  }

  // Show error notification
  error(title, message) {
    this.emit({
      type: 'error',
      title,
      message,
      timestamp: Date.now()
    })
  }

  // Show warning notification
  warning(title, message) {
    this.emit({
      type: 'warning',
      title,
      message,
      timestamp: Date.now()
    })
  }

  // Show info notification
  info(title, message) {
    this.emit({
      type: 'info',
      title,
      message,
      timestamp: Date.now()
    })
  }

  // Show default notification
  show(title, message, type = 'default') {
    this.emit({
      type,
      title,
      message,
      timestamp: Date.now()
    })
  }
}

// Create global instance
const notificationService = new NotificationService()

// Export for use in components
export default notificationService

// Also attach to window for global access
if (typeof window !== 'undefined') {
  window.notification = notificationService
}
