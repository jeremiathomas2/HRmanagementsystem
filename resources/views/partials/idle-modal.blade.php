<!-- Idle Warning Modal -->
<div id="idle-warning-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm hidden">
    <div class="bg-white rounded-lg shadow-2xl p-6 max-w-md mx-4 transform transition-all duration-300 scale-100">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 mb-4">
                <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Session Expiring</h3>
            <p class="text-sm text-gray-600 mb-4">
                Your session will expire in <span id="idle-countdown" class="font-bold text-yellow-600">30</span> seconds due to inactivity.
            </p>
            <p class="text-sm text-gray-500 mb-6">
                Click "Continue Session" to extend your session, or you will be automatically logged out.
            </p>
            <div class="flex gap-3">
                <button onclick="extendSession()" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                    Continue Session
                </button>
                <button onclick="performIdleLogout()" class="flex-1 bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                    Logout Now
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Idle Detection Configuration
const idleConfig = {
    idleWarningTime: 4.5, // 4.5 minutes
    idleLogoutTime: 5, // 5 minutes
    warningDuration: 30, // 30 seconds
    enabled: true,
    activityEvents: [
        'mousedown', 'mousemove', 'keypress', 'scroll', 
        'touchstart', 'click', 'keydown', 'wheel'
    ],
    excludedPages: [
        '/login',
        '/splash'
    ],
    debug: false
};

// Idle detection variables
let idleTimer = null;
let warningTimer = null;
let lastActivity = Date.now();
const idleTimeout = idleConfig.idleWarningTime * 60 * 1000;
const logoutTimeout = idleConfig.idleLogoutTime * 60 * 1000;
const warningTimeout = idleConfig.warningDuration * 1000;

// Activity tracking
function updateLastActivity() {
    lastActivity = Date.now();
    hideIdleWarning();
    resetIdleTimer();
}

function resetIdleTimer() {
    clearTimeout(idleTimer);
    clearTimeout(warningTimer);
    
    idleTimer = setTimeout(() => {
        showIdleWarning();
    }, idleTimeout - warningTimeout);
}

function showIdleWarning() {
    const modal = document.getElementById('idle-warning-modal');
    const countdown = document.getElementById('idle-countdown');
    
    if (modal && countdown) {
        modal.classList.remove('hidden');
        countdown.textContent = idleConfig.warningDuration;
        
        // Start countdown
        warningTimer = setInterval(() => {
            let currentCountdown = parseInt(countdown.textContent);
            currentCountdown--;
            countdown.textContent = currentCountdown;
            
            if (currentCountdown <= 0) {
                clearInterval(warningTimer);
                performIdleLogout();
            }
        }, 1000);
        
        // Show warning notification
        showWarning('Session Expiring', `Your session will expire in ${idleConfig.warningDuration} seconds due to inactivity.`);
    }
}

function hideIdleWarning() {
    const modal = document.getElementById('idle-warning-modal');
    if (modal) {
        modal.classList.add('hidden');
    }
    clearTimeout(warningTimer);
}

function extendSession() {
    updateLastActivity();
    showSuccess('Session Extended', 'Your session has been extended for another 5 minutes.');
}

function performIdleLogout() {
    hideIdleWarning();
    showInfo('Session Expired', 'You have been logged out due to inactivity.');
    
    // Redirect to login after a short delay
    setTimeout(() => {
        window.location.href = '/login?logout=true&reason=idle';
    }, 2000);
}

function shouldExcludeIdleDetection() {
    const currentPath = window.location.pathname;
    return idleConfig.excludedPages.some(page => currentPath.includes(page));
}

// Initialize idle detection
document.addEventListener('DOMContentLoaded', function() {
    if (idleConfig.enabled && !shouldExcludeIdleDetection()) {
        // Set up activity event listeners
        const handleActivity = () => {
            updateLastActivity();
        };
        
        idleConfig.activityEvents.forEach(event => {
            document.addEventListener(event, handleActivity, true);
        });
        
        // Initialize idle timer
        resetIdleTimer();
        
        if (idleConfig.debug) {
            console.log('Idle detection enabled on:', window.location.pathname);
        }
        
        // Store references for cleanup
        window._activityEvents = idleConfig.activityEvents;
        window._handleActivity = handleActivity;
    }
});

// Cleanup on page unload
window.addEventListener('beforeunload', function() {
    if (window._activityEvents && window._handleActivity) {
        window._activityEvents.forEach(event => {
            document.removeEventListener(event, window._handleActivity, true);
        });
        delete window._activityEvents;
        delete window._handleActivity;
    }
    
    clearTimeout(idleTimer);
    clearTimeout(warningTimer);
});
</script>
