import './bootstrap';
import { createApp } from 'vue'
import { createStore } from 'vuex'
import LoginPage from './components/LoginPage.vue'

// Import styles
import './styles/app.css'

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
        window.location.href = '/login'
      }
    }
  }
})

// Create and mount the Vue app
const app = createApp(LoginPage)
app.use(store)
app.mount('#app')
