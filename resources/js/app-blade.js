// Main JavaScript for Blade Templates
import './bootstrap';
import './icons';

// DOM Elements
let sidebarOpen = true;
let dropdowns = {
    dashboard: false,
    employees: false,
    payroll: false,
    discipline: false,
    leave: false,
    recruitment: false,
    performance: false,
    training: false,
    attendance: false,
    compliance: false,
    reports: false,
    settings: false
};

// Initialize app when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
});

function initializeApp() {
    // Set initial sidebar state
    const mainContent = document.getElementById('main-content');
    if (mainContent) {
        if (sidebarOpen) {
            mainContent.classList.add('lg:ml-64');
            mainContent.classList.remove('lg:ml-0');
        } else {
            mainContent.classList.remove('lg:ml-64');
            mainContent.classList.add('lg:ml-0');
        }
    }
    
    // Set active route highlighting
    setActiveRoute();
    
    // Initialize dropdowns
    initializeDropdowns();
    
    // Setup click outside handler
    setupClickOutsideHandler();
}

function toggleSidebar() {
    sidebarOpen = !sidebarOpen;
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    
    if (sidebar && mainContent) {
        if (sidebarOpen) {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            mainContent.classList.add('lg:ml-64');
            mainContent.classList.remove('lg:ml-0');
        } else {
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('translate-x-0');
            mainContent.classList.remove('lg:ml-64');
            mainContent.classList.add('lg:ml-0');
        }
    }
}

function toggleDropdown(menu) {
    // Close all other dropdowns
    Object.keys(dropdowns).forEach(key => {
        if (key !== menu) {
            dropdowns[key] = false;
            const dropdown = document.getElementById(`${key}-dropdown`);
            if (dropdown) {
                dropdown.classList.add('hidden');
            }
        }
    });
    
    // Toggle current dropdown
    dropdowns[menu] = !dropdowns[menu];
    const dropdown = document.getElementById(`${menu}-dropdown`);
    if (dropdown) {
        if (dropdowns[menu]) {
            dropdown.classList.remove('hidden');
        } else {
            dropdown.classList.add('hidden');
        }
    }
}

function closeAllDropdowns() {
    Object.keys(dropdowns).forEach(key => {
        dropdowns[key] = false;
        const dropdown = document.getElementById(`${key}-dropdown`);
        if (dropdown) {
            dropdown.classList.add('hidden');
        }
    });
}

function initializeDropdowns() {
    // Close dropdowns when clicking outside
    document.addEventListener('click', handleClickOutside);
}

function handleClickOutside(event) {
    const isDropdown = event.target.closest('.relative');
    if (!isDropdown) {
        closeAllDropdowns();
    }
}

function setActiveRoute() {
    const currentPath = window.location.pathname;
    
    // Remove active classes from all menu items
    document.querySelectorAll('[class*="text-gray-600"]').forEach(element => {
        element.classList.remove('bg-gray-100', 'text-gray-900');
        element.classList.add('text-gray-600', 'hover:bg-gray-50', 'hover:text-gray-900');
    });
    
    // Add active class to current route
    const routeMappings = {
        '/dashboard': 'dashboard',
        '/employees': 'employees',
        '/discipline': 'discipline',
        '/payroll': 'payroll',
        '/compliance': 'compliance',
        '/attendance': 'attendance',
        '/leave': 'leave',
        '/recruitment': 'recruitment',
        '/performance': 'performance',
        '/training': 'training',
        '/system': 'system'
    };
    
    const activeRoute = Object.keys(routeMappings).find(route => currentPath.includes(route));
    if (activeRoute) {
        const activeElement = document.querySelector(`[onclick*="toggleDropdown('${routeMappings[activeRoute]}')"]`);
        if (activeElement) {
            activeElement.classList.remove('text-gray-600', 'hover:bg-gray-50', 'hover:text-gray-900');
            activeElement.classList.add('bg-gray-100', 'text-gray-900');
        }
    }
}

function toggleNotifications() {
    const dropdown = document.getElementById('notifications-dropdown');
    if (dropdown) {
        dropdown.classList.toggle('hidden');
    }
}

// Utility functions
function formatCurrency(value) {
    return new Intl.NumberFormat('en-TZ', {
        style: 'currency',
        currency: 'TZS'
    }).format(value);
}

function formatDate(value) {
    return new Date(value).toLocaleDateString('en-TZ', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

function formatDateTime(value) {
    return new Date(value).toLocaleString('en-TZ', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

// Export functions for global access
window.toggleSidebar = toggleSidebar;
window.toggleDropdown = toggleDropdown;
window.closeAllDropdowns = closeAllDropdown;
window.toggleNotifications = toggleNotifications;
window.formatCurrency = formatCurrency;
window.formatDate = formatDate;
window.formatDateTime = formatDateTime;

// Make functions available globally
window.showSuccess = window.showSuccess || function(title, message) {
    if (window.notificationService) {
        window.notificationService.show({
            type: 'success',
            title: title,
            message: message,
            timestamp: Date.now()
        });
    }
};

window.showError = window.showError || function(title, message) {
    if (window.notificationService) {
        window.notificationService.show({
            type: 'error',
            title: title,
            message: message,
            timestamp: Date.now()
        });
    }
};

window.showWarning = window.showWarning || function(title, message) {
    if (window.notificationService) {
        window.notificationService.show({
            type: 'warning',
            title: title,
            message: message,
            timestamp: Date.now()
        });
    }
};

window.showInfo = window.showInfo || function(title, message) {
    if (window.notificationService) {
        window.notificationService.show({
            type: 'info',
            title: title,
            message: message,
            timestamp: Date.now()
        });
    }
};
