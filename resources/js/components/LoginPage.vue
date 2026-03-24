<template>
  <!-- Show Splash Screen Initially -->
  <SplashScreen v-if="showSplash" @complete="hideSplash" />
  
  <!-- Login Page (shown after splash) -->
  <div v-else class="min-h-screen bg-gradient-to-br from-indigo-900 via-blue-900 to-purple-900 flex flex-col justify-center py-12 sm:px-6 lg:px-8 login-page">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <!-- Logo -->
      <div class="flex justify-center">
        <div class="w-12 h-12 logo-enhanced rounded-lg flex items-center justify-center">
          <span class="text-white font-bold text-xl">HR</span>
        </div>
      </div>
      
      <!-- Title -->
      <h2 class="mt-6 text-center text-3xl font-extrabold text-white">
        Sign in to your account
      </h2>
      <p class="mt-2 text-center text-sm text-gray-200">
        Welcome to
      </p>
      <p class="mt-2 text-center text-sm text-gray-200">
        HR Management System
      </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="glass-form py-8 px-4 shadow-xl sm:rounded-lg sm:px-10">
        <form @submit.prevent="handleLogin" class="space-y-6">
          <!-- Username -->
          <div>
            <label for="username" class="block text-sm font-medium text-gray-200">
              Username
            </label>
            <div class="mt-1">
              <input
                id="username"
                v-model="form.username"
                name="username"
                type="text"
                autocomplete="username"
                required
                class="appearance-none block w-full px-3 py-2 border border-white/30 rounded-md placeholder-gray-400 text-white bg-white/10 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white/20 sm:text-sm"
                placeholder="Enter your username"
                style="color: white !important; -webkit-text-fill-color: white !important;"
              >
            </div>
          </div>

          <!-- Password -->
          <div>
            <label for="password" class="block text-sm font-medium text-gray-200">
              Password
            </label>
            <div class="mt-1">
              <input
                id="password"
                v-model="form.password"
                name="password"
                type="password"
                autocomplete="current-password"
                required
                class="appearance-none block w-full px-3 py-2 border border-white/30 rounded-md placeholder-gray-400 text-white bg-white/10 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white/20 sm:text-sm"
                placeholder="Enter your password"
                style="color: white !important; -webkit-text-fill-color: white !important;"
              >
            </div>
          </div>

          <!-- Remember me & Forgot password -->
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <input
                id="remember-me"
                v-model="form.remember"
                name="remember-me"
                type="checkbox"
                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-white/30 rounded"
              >
              <label for="remember-me" class="ml-2 block text-sm text-white">
                Remember me
              </label>
            </div>

            <div class="text-sm">
              <a href="#" class="font-medium text-indigo-300 hover:text-indigo-200">
                Forgot password?
              </a>
            </div>
          </div>

          <!-- Error message -->
          <div v-if="error" class="rounded-md error-message p-3">
            <div class="flex">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-300" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
              </div>
              <div class="ml-3">
                <p class="text-sm text-red-200">{{ error }}</p>
              </div>
            </div>
          </div>

          <!-- Sign in button -->
          <div>
            <button
              type="submit"
              :disabled="loading"
              class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white btn-login disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <span v-if="loading" class="flex items-center">
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V8c0 2.168-1.025 4.066-2.719 4.066-2.719 1.647-1.55 3.943-1.55 3.943z"></path>
                </svg>
                Signing in...
              </span>
              <span v-else>Sign in</span>
            </button>
          </div>
        </form>

        <!-- Demo credentials -->
        
      </div>
    </div>
    
    <!-- Advanced Notification System -->
    <AdvancedNotification />
    
    <!-- Footer with Version and Security Info -->
    <footer class="mt-auto py-4 text-center text-xs text-gray-500">
      <div class="space-y-1">
        <p>© 2026 HR Management System v2.1.0</p>
        <div class="flex justify-center items-center space-x-4">
          <span class="flex items-center">
            <svg class="w-3 h-3 mr-1 text-green-600" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            PDPA Compliant
          </span>
          <span class="flex items-center">
            <svg class="w-3 h-3 mr-1 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
            </svg>
            256-bit SSL Encryption
          </span>
          <span class="flex items-center">
            <svg class="w-3 h-3 mr-1 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
              <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
            </svg>
            ISO 27001 Certified
          </span>
        </div>
        <p class="text-gray-400">Secure login protected by multi-factor authentication</p>
      </div>
    </footer>
  </div>
</template>

<script>
import { ref } from 'vue'
import { useStore } from 'vuex'
import notification from '../utils/notification.js'
import AdvancedNotification from './AdvancedNotification.vue'
import SplashScreen from './SplashScreen.vue'

export default {
  name: 'LoginPage',
  components: {
    SplashScreen,
    AdvancedNotification
  },
  setup() {
    const store = useStore()
    const form = ref({
      username: '',
      password: '',
      remember: false
    })

    const loading = ref(false)
    const error = ref('')
    
    // Check if user is logging out (skip splash screen)
    // Method 1: Session storage flag
    const isLoggingOutFromStorage = sessionStorage.getItem('isLoggingOut') === 'true'
    // Method 2: URL parameter
    const urlParams = new URLSearchParams(window.location.search)
    const isLoggingOutFromURL = urlParams.get('logout') === 'true'
    
    const isLoggingOut = isLoggingOutFromStorage || isLoggingOutFromURL
    const showSplash = ref(!isLoggingOut)
    
    // Clear logout flag after checking
    if (isLoggingOutFromStorage) {
      sessionStorage.removeItem('isLoggingOut')
    }
    
    // Clean up URL if logout parameter exists
    if (isLoggingOutFromURL) {
      const cleanUrl = window.location.pathname
      window.history.replaceState({}, '', cleanUrl)
    }

    const hideSplash = () => {
      showSplash.value = false
    }

    const handleLogin = async () => {
      loading.value = true
      error.value = ''

      try {
        // Validate form
        if (!form.value.username || !form.value.password) {
          error.value = 'Please enter both username and password'
          notification.warning('Validation Error', 'Please enter both username and password.')
          loading.value = false
          return
        }

        const success = await store.dispatch('login', {
          username: form.value.username.trim(),
          password: form.value.password,
          remember: form.value.remember
        })
        
        if (success) {
          const username = form.value.username.trim() || 'User'
          notification.success('Login Successful', `Welcome back, ${username}! Redirecting to dashboard...`)
          
          // Clear form
          form.value.username = ''
          form.value.password = ''
          form.value.remember = false
          
          setTimeout(() => {
            window.location.href = '/dashboard'
          }, 2000)
        } else {
          error.value = 'Invalid username or password'
          notification.error('Login Failed', 'Invalid username or password. Please check your credentials and try again.')
        }
      } catch (err) {
        error.value = 'An error occurred during login'
        notification.error('Login Error', 'An error occurred during login. Please try again or contact support.')
        console.error('Login error:', err)
      } finally {
        loading.value = false
      }
    }

    return {
      form,
      loading,
      error,
      showSplash,
      hideSplash,
      handleLogin
    }
  }
}
</script>

<style scoped>
/* Additional styles for login page */
.login-page {
  position: relative;
}

.login-page::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(139, 92, 246, 0.1) 100%);
  pointer-events: none;
}

/* Ensure all text is white */
.login-page * {
  color: white !important;
}

/* Override specific elements */
.login-page .text-white {
  color: white !important;
}

.login-page .text-gray-200 {
  color: rgba(255, 255, 255, 0.9) !important;
}

.login-page .text-indigo-300 {
  color: rgba(199, 210, 254, 0.9) !important;
}

.login-page .text-indigo-200 {
  color: rgba(199, 210, 254, 0.8) !important;
}

.login-page .text-red-200 {
  color: rgba(254, 202, 202, 0.9) !important;
}

.login-page .text-red-300 {
  color: rgba(252, 165, 165, 0.9) !important;
}

/* Input styling */
.login-page input[type="text"],
.login-page input[type="password"] {
  background: rgba(255, 255, 255, 0.1) !important;
  border: 1px solid rgba(255, 255, 255, 0.3) !important;
  color: white !important;
  -webkit-text-fill-color: white !important;
  -webkit-opacity: 1 !important;
  opacity: 1 !important;
}

.login-page input[type="text"]::placeholder,
.login-page input[type="password"]::placeholder {
  color: rgba(255, 255, 255, 0.6) !important;
  -webkit-text-fill-color: rgba(255, 255, 255, 0.6) !important;
}

.login-page input[type="text"]:focus,
.login-page input[type="password"]:focus {
  background: rgba(255, 255, 255, 0.15) !important;
  border-color: rgba(99, 102, 241, 0.8) !important;
  color: white !important;
  -webkit-text-fill-color: white !important;
  -webkit-opacity: 1 !important;
  opacity: 1 !important;
}

/* Ensure autofill styling is white */
.login-page input:-webkit-autofill,
.login-page input:-webkit-autofill:hover,
.login-page input:-webkit-autofill:focus,
.login-page input:-webkit-autofill:active {
  -webkit-box-shadow: 0 0 0 30px rgba(255, 255, 255, 0.1) inset !important;
  -webkit-text-fill-color: white !important;
  color: white !important;
  background-color: rgba(255, 255, 255, 0.1) !important;
}

/* Firefox autofill styling */
.login-page input:-moz-autofill {
  background-color: rgba(255, 255, 255, 0.1) !important;
  color: white !important;
}

/* Input field text selection styling */
.login-page input[type="text"]::selection,
.login-page input[type="password"]::selection {
  background-color: rgba(99, 102, 241, 0.3) !important;
  color: white !important;
  -webkit-text-fill-color: white !important;
}

/* Checkbox styling */
.login-page input[type="checkbox"] {
  border-color: rgba(255, 255, 255, 0.3) !important;
  background-color: rgba(255, 255, 255, 0.1) !important;
}

.login-page input[type="checkbox"]:checked {
  background-color: rgb(99, 102, 241) !important;
  border-color: rgb(99, 102, 241) !important;
}

/* Form container glass effect */
.glass-form {
  background: rgba(255, 255, 255, 0.1) !important;
  backdrop-filter: blur(20px) !important;
  border: 1px solid rgba(255, 255, 255, 0.2) !important;
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
}

/* Button enhancements */
.btn-login {
  background: linear-gradient(135deg, rgb(99, 102, 241) 0%, rgb(139, 92, 246) 100%) !important;
  border: none !important;
  box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.3) !important;
  transition: all 0.3s ease !important;
}

.btn-login:hover {
  transform: translateY(-2px) !important;
  box-shadow: 0 20px 40px -10px rgba(99, 102, 241, 0.4) !important;
}

.btn-login:active {
  transform: translateY(0) !important;
}

/* Error message styling */
.error-message {
  background: rgba(239, 68, 68, 0.2) !important;
  border: 1px solid rgba(239, 68, 68, 0.3) !important;
  backdrop-filter: blur(10px) !important;
}

/* Logo enhancement */
.logo-enhanced {
  background: linear-gradient(135deg, rgb(99, 102, 241) 0%, rgb(139, 92, 246) 100%) !important;
  box-shadow: 0 20px 40px -10px rgba(99, 102, 241, 0.3) !important;
  animation: pulse 2s infinite !important;
}

@keyframes pulse {
  0%, 100% {
    transform: scale(1);
    box-shadow: 0 20px 40px -10px rgba(99, 102, 241, 0.3);
  }
  50% {
    transform: scale(1.05);
    box-shadow: 0 25px 50px -12px rgba(99, 102, 241, 0.4);
  }
}
</style>
