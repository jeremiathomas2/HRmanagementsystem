import './bootstrap';

import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import { createStore } from 'vuex'
import App from './App.vue'

// Import components (excluding LoginPage)
import Dashboard from './components/Dashboard.vue'
import EmployeeManagement from './components/EmployeeManagement.vue'
import DisciplineManagement from './components/DisciplineManagement.vue'
import PayrollManagement from './components/PayrollManagement.vue'
import ComplianceManagement from './components/ComplianceManagement.vue'
import AttendanceManagement from './components/AttendanceManagement.vue'
import LeaveManagement from './components/LeaveManagement.vue'
import RecruitmentManagement from './components/RecruitmentManagement.vue'
import PerformanceManagement from './components/PerformanceManagement.vue'
import TrainingManagement from './components/TrainingManagement.vue'

// Import submenu components
import DashboardAnalytics from './components/dashboard/Analytics.vue'
import DashboardReports from './components/dashboard/Reports.vue'
import EmployeeAdd from './components/employees/AddEmployee.vue'
import EmployeeContracts from './components/employees/Contracts.vue'
import EmployeeDepartments from './components/employees/Departments.vue'
import PayrollHistory from './components/payroll/History.vue'
import PayrollStatutory from './components/payroll/Statutory.vue'
import PayrollReports from './components/payroll/Reports.vue'
import DisciplineNew from './components/discipline/NewCase.vue'
import DisciplineHearings from './components/discipline/Hearings.vue'
import DisciplineActions from './components/discipline/Actions.vue'
import ComplianceInspections from './components/compliance/Inspections.vue'
import ComplianceLicenses from './components/compliance/Licenses.vue'
import ComplianceAudits from './components/compliance/Audits.vue'
import AttendanceSchedule from './components/attendance/Schedule.vue'
import AttendanceOvertime from './components/attendance/Overtime.vue'
import AttendanceReports from './components/attendance/Reports.vue'
import LeaveBalances from './components/leave/Balances.vue'
import LeavePolicy from './components/leave/Policy.vue'
import LeaveCalendar from './components/leave/Calendar.vue'
import RecruitmentApplications from './components/recruitment/Applications.vue'
import RecruitmentInterviews from './components/recruitment/Interviews.vue'
import RecruitmentOnboarding from './components/recruitment/Onboarding.vue'
import PerformanceGoals from './components/performance/Goals.vue'
import PerformanceFeedback from './components/performance/Feedback.vue'
import PerformanceAnalytics from './components/performance/Analytics.vue'
import TrainingCourses from './components/training/Courses.vue'
import TrainingEnrollments from './components/training/Enrollments.vue'
import TrainingCertificates from './components/training/Certificates.vue'

// System submenu components
import SystemSettings from './components/system/Settings.vue'
import SystemUsers from './components/system/Users.vue'
import SystemRoles from './components/system/Roles.vue'
import SystemBackup from './components/system/Backup.vue'
import SystemLogs from './components/system/Logs.vue'
import SystemMaintenance from './components/system/Maintenance.vue'
import SystemIntegrations from './components/system/Integrations.vue'
import SystemSecurity from './components/system/Security.vue'

// Import styles
import './styles/app.css'

// Router configuration (dashboard and protected routes only)
const routes = [
  // Main routes
  { path: '/dashboard', name: 'dashboard', component: Dashboard },
  { path: '/employees', name: 'employees', component: EmployeeManagement },
  { path: '/discipline', name: 'discipline', component: DisciplineManagement },
  { path: '/payroll', name: 'payroll', component: PayrollManagement },
  { path: '/compliance', name: 'compliance', component: ComplianceManagement },
  { path: '/attendance', name: 'attendance', component: AttendanceManagement },
  { path: '/leave', name: 'leave', component: LeaveManagement },
  { path: '/recruitment', name: 'recruitment', component: RecruitmentManagement },
  { path: '/performance', name: 'performance', component: PerformanceManagement },
  { path: '/training', name: 'training', component: TrainingManagement },
  
  // Dashboard submenus
  { path: '/dashboard/analytics', name: 'dashboard-analytics', component: DashboardAnalytics },
  { path: '/dashboard/reports', name: 'dashboard-reports', component: DashboardReports },
  
  // Employee submenus
  { path: '/employees/add', name: 'employee-add', component: EmployeeAdd },
  { path: '/employees/contracts', name: 'employee-contracts', component: EmployeeContracts },
  { path: '/employees/departments', name: 'employee-departments', component: EmployeeDepartments },
  
  // Payroll submenus
  { path: '/payroll/history', name: 'payroll-history', component: PayrollHistory },
  { path: '/payroll/statutory', name: 'payroll-statutory', component: PayrollStatutory },
  { path: '/payroll/reports', name: 'payroll-reports', component: PayrollReports },
  
  // Discipline submenus
  { path: '/discipline/new', name: 'discipline-new', component: DisciplineNew },
  { path: '/discipline/hearings', name: 'discipline-hearings', component: DisciplineHearings },
  { path: '/discipline/actions', name: 'discipline-actions', component: DisciplineActions },
  
  // Compliance submenus
  { path: '/compliance/inspections', name: 'compliance-inspections', component: ComplianceInspections },
  { path: '/compliance/licenses', name: 'compliance-licenses', component: ComplianceLicenses },
  { path: '/compliance/audits', name: 'compliance-audits', component: ComplianceAudits },
  
  // Attendance submenus
  { path: '/attendance/schedule', name: 'attendance-schedule', component: AttendanceSchedule },
  { path: '/attendance/overtime', name: 'attendance-overtime', component: AttendanceOvertime },
  { path: '/attendance/reports', name: 'attendance-reports', component: AttendanceReports },
  
  // Leave submenus
  { path: '/leave/balances', name: 'leave-balances', component: LeaveBalances },
  { path: '/leave/policy', name: 'leave-policy', component: LeavePolicy },
  { path: '/leave/calendar', name: 'leave-calendar', component: LeaveCalendar },
  
  // Recruitment submenus
  { path: '/recruitment/applications', name: 'recruitment-applications', component: RecruitmentApplications },
  { path: '/recruitment/interviews', name: 'recruitment-interviews', component: RecruitmentInterviews },
  { path: '/recruitment/onboarding', name: 'recruitment-onboarding', component: RecruitmentOnboarding },
  
  // Performance submenus
  { path: '/performance/goals', name: 'performance-goals', component: PerformanceGoals },
  { path: '/performance/feedback', name: 'performance-feedback', component: PerformanceFeedback },
  { path: '/performance/analytics', name: 'performance-analytics', component: PerformanceAnalytics },
  
  // Training submenus
  { path: '/training/courses', name: 'training-courses', component: TrainingCourses },
  { path: '/training/enrollments', name: 'training-enrollments', component: TrainingEnrollments },
  { path: '/training/certificates', name: 'training-certificates', component: TrainingCertificates },
  
  // System submenus
  { path: '/system/settings', name: 'system-settings', component: SystemSettings },
  { path: '/system/users', name: 'system-users', component: SystemUsers },
  { path: '/system/roles', name: 'system-roles', component: SystemRoles },
  { path: '/system/backup', name: 'system-backup', component: SystemBackup },
  { path: '/system/logs', name: 'system-logs', component: SystemLogs },
  { path: '/system/maintenance', name: 'system-maintenance', component: SystemMaintenance },
  { path: '/system/integrations', name: 'system-integrations', component: SystemIntegrations },
  { path: '/system/security', name: 'system-security', component: SystemSecurity },
  
  // Direct routes for convenience
  { path: '/settings', redirect: '/system/settings' },
  { path: '/users', redirect: '/system/users' },
  { path: '/roles', redirect: '/system/roles' },
  
  { path: '/', redirect: '/dashboard' } // Optional: redirect root to dashboard
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

// Vuex store configuration
const store = createStore({
  state: {
    user: null,
    token: localStorage.getItem('token') || null,
    company: null,
    notifications: [],
    loading: false,
    error: null
  },
  mutations: {
    SET_USER(state, user) {
      state.user = user
    },
    SET_TOKEN(state, token) {
      state.token = token
      localStorage.setItem('token', token)
    },
    SET_COMPANY(state, company) {
      state.company = company
    },
    SET_NOTIFICATIONS(state, notifications) {
      state.notifications = notifications
    },
    SET_LOADING(state, loading) {
      state.loading = loading
    },
    SET_ERROR(state, error) {
      state.error = error
    },
    CLEAR_AUTH(state) {
      state.user = null
      state.token = null
      state.company = null
      localStorage.removeItem('token')
    }
  },
  actions: {
    async login({ commit }, credentials) {
      try {
        commit('SET_LOADING', true)
        const response = await fetch('/api/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
          },
          credentials: 'same-origin',
          body: JSON.stringify(credentials)
        })
        
        if (response.ok) {
          const data = await response.json()
          // For Laravel session authentication, we don't need to store a token
          // The session cookie will be handled automatically
          commit('SET_USER', data.user)
          commit('SET_COMPANY', data.user.company)
          return true
        } else {
          const error = await response.json()
          commit('SET_ERROR', error.message || 'Login failed')
          return false
        }
      } catch (error) {
        commit('SET_ERROR', 'Login failed')
        return false
      } finally {
        commit('SET_LOADING', false)
      }
    },
    
    async logout({ commit }) {
      try {
        await fetch('/api/logout', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
          },
          credentials: 'same-origin',
        })
      } catch (error) {
        console.error('Logout error:', error)
      } finally {
        commit('CLEAR_AUTH')
      }
    },
    
    async fetchUser({ commit }) {
      try {
        const response = await fetch('/api/auth/me', {
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
          },
          credentials: 'same-origin',
        })
        
        if (response.ok) {
          const user = await response.json()
          commit('SET_USER', user)
          commit('SET_COMPANY', user.company)
        }
      } catch (error) {
        console.error('Fetch user error:', error)
        commit('CLEAR_AUTH')
      }
    }
  },
  getters: {
    isAuthenticated: state => !!state.token,
    userRole: state => state.user?.roles?.[0]?.name,
    isHRAdmin: state => state.user?.roles?.some(role => ['hr_admin', 'lead_hr_admin', 'super_admin'].includes(role.name))
  }
})

// Create Vue app
const app = createApp(App)

// Use plugins
app.use(router)
app.use(store)

// Global error handler
app.config.errorHandler = (err, vm, info) => {
  console.error('Global error:', err, info)
}

// Global properties
app.config.globalProperties.$filters = {
  currency(value) {
    return new Intl.NumberFormat('en-TZ', {
      style: 'currency',
      currency: 'TZS'
    }).format(value)
  },
  
  date(value) {
    return new Date(value).toLocaleDateString('en-TZ', {
      year: 'numeric',
      month: 'short',
      day: 'numeric'
    })
  },
  
  dateTime(value) {
    return new Date(value).toLocaleString('en-TZ', {
      year: 'numeric',
      month: 'short',
      day: 'numeric',
      hour: '2-digit',
      minute: '2-digit'
    })
  }
}

// Navigation guard
router.beforeEach(async (to, from, next) => {
  console.log('Navigation guard triggered for:', to.path)
  
  // Skip auth check for login page
  if (to.path === '/login') {
    console.log('Skipping auth check for login page')
    next()
    return
  }
  
  // Temporarily bypass authentication for development
  console.log('Bypassing authentication for development')
  next()
  return
  
  // Check if user is already in store (from login)
  const user = store.state.user
  console.log('User in store:', user)
  
  if (user && user.id) {
    // User is authenticated, proceed
    console.log('User found in store, proceeding')
    next()
    return
  }
  
  console.log('No user in store, checking API')
  // If no user in store, check API
  try {
    const response = await fetch('/api/auth/me', {
      headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json',
      },
      credentials: 'same-origin',
    })
    
    console.log('API response status:', response.status)
    
    if (response.status === 401) {
      // User not authenticated, redirect to login
      console.log('401 response, redirecting to login')
      window.location.href = '/login'
      return
    }
    
    if (response.ok) {
      const userData = await response.json()
      console.log('User data from API:', userData)
      store.commit('SET_USER', userData)
      next()
      return
    }
    
    // Other error, proceed anyway (might be network issue)
    console.log('API error, proceeding anyway')
    next()
    return
  } catch (error) {
    console.log('API fetch error, proceeding anyway:', error)
    // Error checking auth, proceed anyway (might be network issue)
    next()
    return
  }
})

// Mount app
app.mount('#app')
