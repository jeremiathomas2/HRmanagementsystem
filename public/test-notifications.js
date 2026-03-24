// Test script to demonstrate advanced notifications
// Run this in browser console to test notifications

// Test different notification types
window.notification.success('Success!', 'This is a success notification that will disappear in 3 seconds.')

setTimeout(() => {
  window.notification.error('Error!', 'This is an error notification.')
}, 1000)

setTimeout(() => {
  window.notification.warning('Warning!', 'This is a warning notification.')
}, 2000)

setTimeout(() => {
  window.notification.info('Info!', 'This is an info notification.')
}, 3000)

setTimeout(() => {
  window.notification.show('Default', 'This is a default notification.')
}, 4000)

// Test multiple notifications at once
setTimeout(() => {
  window.notification.success('Backup Started', 'System backup has been initiated successfully.')
  window.notification.info('Processing', 'Your request is being processed...')
}, 5000)
