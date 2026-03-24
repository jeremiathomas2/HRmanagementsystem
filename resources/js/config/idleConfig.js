// Idle Detection Configuration
export const idleConfig = {
  // Time in minutes before showing idle warning
  idleWarningTime: 4.5, // 4.5 minutes (shows warning at 4.5 minutes)
  
  // Time in minutes before automatic logout
  idleLogoutTime: 5, // 5 minutes total
  
  // Time in seconds to show warning before logout
  warningDuration: 30, // 30 seconds countdown
  
  // Enable/disable idle detection
  enabled: true,
  
  // Activities that reset the idle timer
  activityEvents: [
    'mousedown', 'mousemove', 'keypress', 'scroll', 
    'touchstart', 'click', 'keydown', 'wheel'
  ],
  
  // Pages where idle detection should be disabled
  excludedPages: [
    '/login',
    '/splash',
    '/maintenance'
  ],
  
  // Enable debug logging
  debug: false
}

// Helper function to check if current page should exclude idle detection
export const shouldExcludeIdleDetection = (currentPath) => {
  return idleConfig.excludedPages.some(page => currentPath.includes(page))
}

// Helper function to get idle timeout in milliseconds
export const getIdleTimeoutMs = () => {
  return idleConfig.idleWarningTime * 60 * 1000
}

// Helper function to get logout timeout in milliseconds
export const getLogoutTimeoutMs = () => {
  return idleConfig.idleLogoutTime * 60 * 1000
}

// Helper function to get warning duration in milliseconds
export const getWarningDurationMs = () => {
  return idleConfig.warningDuration * 1000
}
