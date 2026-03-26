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
    
    // Add dedicated event listeners for profile dropdown
    const profileButton = document.querySelector('[data-profile-btn="true"]');
    const profileDropdown = document.getElementById('profile-dropdown');
    
    if (profileButton && profileDropdown) {
        // Remove onclick attribute and add proper event listener
        profileButton.removeAttribute('onclick');
        profileButton.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Profile button clicked'); // Debug log
            toggleProfileDropdown();
        });
    }
    
    // Add dedicated event listeners for notifications dropdown
    const notificationsButton = document.querySelector('[data-notifications-btn="true"]');
    const notificationsDropdown = document.getElementById('notifications-dropdown');
    
    if (notificationsButton && notificationsDropdown) {
        // Remove onclick attribute and add proper event listener
        notificationsButton.removeAttribute('onclick');
        notificationsButton.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleNotifications();
        });
    }
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

// Toggle header company switcher
window.toggleHeaderCompanySwitcher = function() {
    const dropdown = document.getElementById('header-company-dropdown');
    if (dropdown) {
        dropdown.classList.toggle('hidden');
        
        // Close other dropdowns
        const allDropdowns = document.querySelectorAll('[id$="-dropdown"]');
        allDropdowns.forEach(d => {
            if (d.id !== 'header-company-dropdown' && !d.classList.contains('hidden')) {
                d.classList.add('hidden');
            }
        });
    }
};

// Switch company from header
window.switchHeaderCompany = function(companyId, companyName) {
    // Show loading state
    const button = event.target.closest('button');
    if (button) {
        button.disabled = true;
        button.classList.add('opacity-50');
    }
    
    // Simulate company switching
    setTimeout(() => {
        // Update company name in header
        const companyNameElement = document.getElementById('current-company-name');
        if (companyNameElement) {
            companyNameElement.textContent = companyName;
        }
        
        // Update profile dropdown company switcher
        const profileSelect = document.querySelector('select[onchange*="switchCompany"]');
        if (profileSelect) {
            profileSelect.value = companyId;
        }
        
        // Show success notification
        showNotification('success', 'Company Switched', `Successfully switched to ${companyName}`);
        
        // Re-enable button
        if (button) {
            button.disabled = false;
            button.classList.remove('opacity-50');
        }
        
        // Close dropdown
        const dropdown = document.getElementById('header-company-dropdown');
        if (dropdown) {
            dropdown.classList.add('hidden');
        }
        
        // Store company preference
        localStorage.setItem('activeCompany', companyId);
        localStorage.setItem('activeCompanyName', companyName);
        
        // Optional: Reload page to apply company-specific changes
        // window.location.reload();
    }, 1000);
};

// Initialize company state on page load
function initializeCompanyState() {
    const activeCompany = localStorage.getItem('activeCompany') || 'hr-system';
    const activeCompanyData = localStorage.getItem('activeCompanyData');
    
    // Update profile dropdown company switcher
    const profileSelect = document.querySelector('select[onchange*="switchCompany"]');
    if (profileSelect) {
        profileSelect.value = activeCompany;
    }
    
    // If we have company data, update the UI
    if (activeCompanyData) {
        try {
            const company = JSON.parse(activeCompanyData);
            updateCompanyUI(company);
            
            // Update page title
            document.title = `${company.name} - HR Management System`;
            
            // Update theme if different
            if (company.theme !== 'default') {
                updateCompanyTheme(company.theme);
            }
            
            // Update statistics
            updateCompanyStatistics(company);
        } catch (e) {
            console.log('Could not parse company data:', e);
        }
    }
}

// Toggle dropdown
window.toggleDropdown = function(dropdownId) {
    const dropdown = document.getElementById(dropdownId + '-dropdown');
    if (dropdown) {
        dropdown.classList.toggle('hidden');
        
        // Close other dropdowns
        const allDropdowns = document.querySelectorAll('[id$="-dropdown"]');
        allDropdowns.forEach(d => {
            if (d.id !== dropdownId + '-dropdown' && !d.classList.contains('hidden')) {
                d.classList.add('hidden');
            }
        });
    }
};

// Set active menu item
window.setActiveMenuItem = function(element) {
    // Remove active classes from all menu items
    const allMenuItems = document.querySelectorAll('nav a');
    allMenuItems.forEach(item => {
        item.classList.remove('bg-gray-100', 'text-gray-900');
        item.classList.add('text-white');
    });
    
    // Add active classes to clicked item
    element.classList.remove('text-white');
    element.classList.add('bg-gray-100', 'text-gray-900');
    
    // Store active state
    localStorage.setItem('activeMenuItem', element.getAttribute('href'));
};

// Initialize menu active state
function initializeMenuState() {
    const currentPath = window.location.pathname;
    const allMenuItems = document.querySelectorAll('nav a');
    
    allMenuItems.forEach(item => {
        const href = item.getAttribute('href');
        if (href && currentPath.includes(href.replace(/^\//, ''))) {
            setMenuItemActive(item);
        }
    });
    
    // Restore from localStorage if no match
    if (!document.querySelector('nav a.bg-gray-100')) {
        const storedActive = localStorage.getItem('activeMenuItem');
        if (storedActive) {
            const storedItem = document.querySelector(`nav a[href="${storedActive}"]`);
            if (storedItem) {
                setMenuItemActive(storedItem);
            }
        }
    }
}

function setMenuItemActive(element) {
    element.classList.remove('text-white');
    element.classList.add('bg-gray-100', 'text-gray-900');
}

function toggleProfileDropdown() {
    console.log('toggleProfileDropdown called'); // Debug log
    const dropdown = document.getElementById('profile-dropdown');
    const button = document.querySelector('[data-profile-btn="true"]');
    
    console.log('Dropdown element:', dropdown); // Debug log
    console.log('Button element:', button); // Debug log
    
    if (dropdown) {
        const isHidden = dropdown.classList.contains('hidden');
        console.log('Is hidden:', isHidden); // Debug log
        
        if (isHidden) {
            // Show dropdown
            dropdown.classList.remove('hidden');
            dropdown.classList.add('animate-fade-in');
            
            // Add active state to button
            if (button) {
                button.classList.add('bg-gray-100');
            }
            
            console.log('Dropdown shown'); // Debug log
        } else {
            // Hide dropdown
            dropdown.classList.add('hidden');
            dropdown.classList.remove('animate-fade-in');
            
            // Remove active state from button
            if (button) {
                button.classList.remove('bg-gray-100');
            }
            
            console.log('Dropdown hidden'); // Debug log
        }
    } else {
        console.error('Profile dropdown not found'); // Debug log
    }
}

function toggleNotifications() {
    const dropdown = document.getElementById('notifications-dropdown');
    
    // Close all other dropdowns first
    const allDropdowns = document.querySelectorAll('[id$="-dropdown"]');
    allDropdowns.forEach(d => {
        if (d.id !== 'notifications-dropdown' && !d.classList.contains('hidden')) {
            d.classList.add('hidden');
        }
    });
    
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

// Update current time
function updateCurrentTime() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('en-US', { 
        hour: 'numeric', 
        minute: '2-digit',
        hour12: true 
    });
    const timeElement = document.getElementById('current-time');
    if (timeElement) {
        timeElement.textContent = timeString;
    }
}

// Initialize time updates
document.addEventListener('DOMContentLoaded', function() {
    updateCurrentTime();
    setInterval(updateCurrentTime, 60000); // Update every minute
    
    // Initialize company state
    initializeCompanyState();
    
    // Initialize menu state
    initializeMenuState();
    
    // Add click handlers to menu items
    const menuItems = document.querySelectorAll('nav a[href]');
    menuItems.forEach(item => {
        item.addEventListener('click', function(e) {
            // Skip if it's a dropdown toggle or external link
            if (this.getAttribute('onclick') || this.hostname !== window.location.hostname) {
                return;
            }
            
            // Set active state with smooth transition
            setActiveMenuItem(this);
        });
    });
    
    // Handle submenu items
    const submenuItems = document.querySelectorAll('[id$="-dropdown"] a');
    submenuItems.forEach(item => {
        item.addEventListener('click', function(e) {
            // Set parent menu as active
            const parentDropdown = this.closest('[id$="-dropdown"]');
            if (parentDropdown) {
                const dropdownId = parentDropdown.id.replace('-dropdown', '');
                const parentButton = document.querySelector(`[onclick*="toggleDropdown('${dropdownId}')"]`);
                if (parentButton) {
                    setMenuItemActive(parentButton);
                }
            }
            
            // Set this submenu item as active
            setActiveMenuItem(this);
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        const profileDropdown = document.getElementById('profile-dropdown');
        const profileButton = document.querySelector('[data-profile-btn="true"]');
        
        if (profileDropdown && !profileDropdown.classList.contains('hidden')) {
            if (!profileDropdown.contains(event.target) && (!profileButton || !profileButton.contains(event.target))) {
                profileDropdown.classList.add('hidden');
                profileDropdown.classList.remove('animate-fade-in');
                
                // Remove active state from button
                if (profileButton) {
                    profileButton.classList.remove('bg-gray-100');
                }
            }
        }
        
        const notificationsDropdown = document.getElementById('notifications-dropdown');
        const notificationsButton = document.querySelector('[data-notifications-btn="true"]');
        
        if (notificationsDropdown && !notificationsDropdown.classList.contains('hidden')) {
            if (!notificationsDropdown.contains(event.target) && (!notificationsButton || !notificationsButton.contains(event.target))) {
                notificationsDropdown.classList.add('hidden');
            }
        }
    });
    
    // Keyboard navigation support
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const profileDropdown = document.getElementById('profile-dropdown');
            const profileButton = document.querySelector('[data-profile-btn="true"]');
            
            if (profileDropdown && !profileDropdown.classList.contains('hidden')) {
                profileDropdown.classList.add('hidden');
                profileDropdown.classList.remove('animate-fade-in');
                
                if (profileButton) {
                    profileButton.classList.remove('bg-gray-100');
                    profileButton.focus();
                }
            }
            
            const notificationsDropdown = document.getElementById('notifications-dropdown');
            if (notificationsDropdown && !notificationsDropdown.classList.contains('hidden')) {
                notificationsDropdown.classList.add('hidden');
            }
        }
    });
});

// Company switcher functionality
window.switchCompany = function(companyId) {
    // Prevent event if no company selected
    if (!companyId) return;
    
    // Show loading state
    const select = event.target;
    const originalValue = select.value;
    
    // Add loading indicator
    select.disabled = true;
    select.classList.add('opacity-50', 'cursor-wait');
    
    // Add loading spinner
    const loadingSpinner = document.createElement('div');
    loadingSpinner.className = 'absolute inset-0 flex items-center justify-center bg-white bg-opacity-75 rounded-md';
    loadingSpinner.innerHTML = `
        <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-indigo-600"></div>
    `;
    select.parentElement.style.position = 'relative';
    select.parentElement.appendChild(loadingSpinner);
    
    // Simulate company switching with realistic delay
    setTimeout(() => {
        // Company data with additional information
        const companyData = {
            'hr-system': {
                name: 'HR Management System',
                logo: '/images/logos/hr-system.png',
                theme: 'default',
                employees: 156,
                description: 'Main HR Management Portal'
            },
            'tcc': {
                name: 'Tanzania Cigarette Company (TCC)',
                logo: '/images/logos/tcc.png',
                theme: 'blue',
                employees: 1200,
                description: 'Leading tobacco manufacturing company'
            },
            'tcl': {
                name: 'Tanzania Breweries Limited (TBL)',
                logo: '/images/logos/tbl.png',
                theme: 'yellow',
                employees: 850,
                description: 'Premier beverage and brewing company'
            },
            'nmb': {
                name: 'NMB Bank Plc',
                logo: '/images/logos/nmb.png',
                theme: 'green',
                employees: 3200,
                description: 'Largest commercial bank in Tanzania'
            },
            'crdb': {
                name: 'CRDB Bank Plc',
                logo: '/images/logos/crdb.png',
                theme: 'purple',
                employees: 2800,
                description: 'Leading financial services provider'
            },
            'tigo': {
                name: 'Tigo Tanzania',
                logo: '/images/logos/tigo.png',
                theme: 'cyan',
                employees: 650,
                description: 'Telecommunications services provider'
            },
            'vodacom': {
                name: 'Vodacom Tanzania',
                logo: '/images/logos/vodacom.png',
                theme: 'red',
                employees: 750,
                description: 'Largest mobile network operator'
            },
            'airtel': {
                name: 'Airtel Tanzania',
                logo: '/images/logos/airtel.png',
                theme: 'blue',
                employees: 580,
                description: 'Fastest growing telecom company'
            },
            'tanesco': {
                name: 'TANESCO',
                logo: '/images/logos/tanesco.png',
                theme: 'orange',
                employees: 4500,
                description: 'National electricity supply company'
            },
            'twiga': {
                name: 'Twiga Cement',
                logo: '/images/logos/twiga.png',
                theme: 'gray',
                employees: 320,
                description: 'Leading cement manufacturer'
            },
            'azam': {
                name: 'Azam Tanzania',
                logo: '/images/logos/azam.png',
                theme: 'indigo',
                employees: 2100,
                description: 'Diverse industrial conglomerate'
            },
            'yara': {
                name: 'Yara Tanzania',
                logo: '/images/logos/yara.png',
                theme: 'green',
                employees: 180,
                description: 'Agricultural solutions provider'
            }
        };
        
        const company = companyData[companyId];
        
        if (company) {
            // Update UI elements
            updateCompanyUI(company);
            
            // Store company preference
            localStorage.setItem('activeCompany', companyId);
            localStorage.setItem('activeCompanyName', company.name);
            localStorage.setItem('activeCompanyData', JSON.stringify(company));
            
            // Update page title
            document.title = `${company.name} - HR Management System`;
            
            // Update theme if different
            if (company.theme !== 'default') {
                updateCompanyTheme(company.theme);
            }
            
            // Show detailed success notification
            showNotification('success', 'Company Switched', 
                `Successfully switched to ${company.name}\nEmployees: ${company.employees}\n${company.description}`);
            
            // Log the switch for analytics
            console.log(`Company switched to: ${company.name} (${companyId})`);
            
            // Trigger custom event for other components
            window.dispatchEvent(new CustomEvent('companyChanged', {
                detail: { companyId, company }
            }));
        }
        
        // Remove loading spinner and re-enable select
        if (loadingSpinner && loadingSpinner.parentElement) {
            loadingSpinner.parentElement.removeChild(loadingSpinner);
        }
        select.disabled = false;
        select.classList.remove('opacity-50', 'cursor-wait');
        
        // Close profile dropdown
        const profileDropdown = document.getElementById('profile-dropdown');
        if (profileDropdown) {
            profileDropdown.classList.add('hidden');
            profileDropdown.classList.remove('animate-fade-in');
            
            // Remove active state from button
            const profileButton = document.querySelector('[data-profile-btn="true"]');
            if (profileButton) {
                profileButton.classList.remove('bg-gray-100');
            }
        }
        
        // Update any other company-related UI elements
        updateCompanyRelatedElements(companyId, company);
        
    }, 1500); // Realistic loading time
};

// Helper function to update company UI
function updateCompanyUI(company) {
    // Update header company name if exists
    const headerCompanyName = document.getElementById('header-company-name');
    if (headerCompanyName) {
        headerCompanyName.textContent = company.name;
    }
    
    // Update dashboard title if exists
    const dashboardTitle = document.querySelector('h1');
    if (dashboardTitle && dashboardTitle.textContent.includes('Dashboard')) {
        dashboardTitle.textContent = `${company.name} Dashboard`;
    }
    
    // Update any company logos
    const companyLogos = document.querySelectorAll('[data-company-logo]');
    companyLogos.forEach(logo => {
        logo.src = company.logo;
        logo.alt = company.name;
    });
}

// Helper function to update company theme
function updateCompanyTheme(theme) {
    const body = document.body;
    
    // Remove existing theme classes
    body.classList.remove('theme-blue', 'theme-yellow', 'theme-green', 'theme-purple', 'theme-cyan', 'theme-red', 'theme-orange', 'theme-gray', 'theme-indigo');
    
    // Add new theme class
    if (theme !== 'default') {
        body.classList.add(`theme-${theme}`);
        
        // Update primary color CSS variables
        const themeColors = {
            blue: '#3B82F6',
            yellow: '#F59E0B',
            green: '#10B981',
            purple: '#8B5CF6',
            cyan: '#06B6D4',
            red: '#EF4444',
            orange: '#F97316',
            gray: '#6B7280',
            indigo: '#6366F1'
        };
        
        if (themeColors[theme]) {
            document.documentElement.style.setProperty('--primary-color', themeColors[theme]);
        }
    }
}

// Helper function to update company-related elements
function updateCompanyRelatedElements(companyId, company) {
    // Update any elements that depend on company
    const companyElements = document.querySelectorAll('[data-company-dependent]');
    companyElements.forEach(element => {
        element.setAttribute('data-current-company', companyId);
    });
    
    // Update statistics if they exist
    updateCompanyStatistics(company);
    
    // Update recent activities if they exist
    if (window.activityManager) {
        window.activityManager.filterActivities('all');
    }
}

// Helper function to update company statistics
function updateCompanyStatistics(company) {
    // Update employee count
    const employeeCount = document.querySelector('[data-stat="employees"]');
    if (employeeCount) {
        employeeCount.textContent = company.employees.toLocaleString();
    }
    
    // Update other statistics based on company size
    const employeeMultiplier = company.employees / 156; // Base is HR System with 156 employees
    
    // Update contracts proportionally
    const contractsElement = document.querySelector('[data-stat="contracts"]');
    if (contractsElement) {
        const baseContracts = 142;
        contractsElement.textContent = Math.round(baseContracts * employeeMultiplier).toLocaleString();
    }
    
    // Update payroll proportionally
    const payrollElement = document.querySelector('[data-stat="payroll"]');
    if (payrollElement) {
        const basePayroll = 45.2;
        const newPayroll = (basePayroll * employeeMultiplier).toFixed(1);
        payrollElement.textContent = `TZS ${newPayroll}M`;
    }
}

// Show notification
window.showNotification = function(type, title, message) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-20 right-4 z-50 p-4 rounded-md shadow-lg transform transition-all duration-300 translate-x-full`;
    
    // Set color based on type
    const colors = {
        'success': 'bg-green-50 border-green-200 text-green-800',
        'error': 'bg-red-50 border-red-200 text-red-800',
        'warning': 'bg-yellow-50 border-yellow-200 text-yellow-800',
        'info': 'bg-blue-50 border-blue-200 text-blue-800'
    };
    
    notification.classList.add(...colors[type].split(' '));
    
    notification.innerHTML = `
        <div class="flex">
            <div class="flex-shrink-0">
                ${type === 'success' ? 
                    '<svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>' :
                    type === 'error' ?
                    '<svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2 2m2 2l2 2m7-5a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>' :
                    '<svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
                }
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium">${title}</h3>
                <p class="text-sm">${message}</p>
            </div>
            <div class="ml-auto pl-3">
                <button onclick="this.parentElement.parentElement.parentElement.remove()" class="inline-flex text-gray-400 hover:text-gray-500">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
        notification.classList.add('translate-x-0');
    }, 100);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => notification.remove(), 300);
    }, 5000);
};

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
window.closeAllDropdowns = closeAllDropdowns;
window.toggleNotifications = toggleNotifications;
window.toggleProfileDropdown = toggleProfileDropdown;
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

// Export essential functions for global access
window.toggleProfileDropdown = toggleProfileDropdown;
window.toggleNotifications = toggleNotifications;
window.switchCompany = switchCompany;
window.showNotification = showNotification;
