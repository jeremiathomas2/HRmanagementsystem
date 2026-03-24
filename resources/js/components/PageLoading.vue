<template>
  <transition name="loading-fade">
    <div v-if="isLoading" class="page-loading-overlay">
      <div class="loading-backdrop" @click="forceStop">
        <div class="loading-container" @click.stop>
          <div class="loading-spinner">
            <div class="spinner-ring"></div>
            <div class="spinner-ring"></div>
            <div class="spinner-ring"></div>
            <div class="spinner-ring"></div>
          </div>
          <div class="loading-text">
            <h3>{{ loadingTitle }}</h3>
            <p>{{ loadingMessage || 'Please wait while we prepare your page' }}</p>
            <button @click="forceStop" class="cancel-loading-btn">
              Cancel Loading
            </button>
          </div>
          <div class="loading-progress">
            <div class="progress-bar">
              <div class="progress-fill" :style="{ width: loadingProgress + '%' }"></div>
            </div>
            <div class="progress-text">{{ Math.round(loadingProgress) }}%</div>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  name: 'PageLoading',
  data() {
    return {
      isLoading: false,
      loadingMessage: '',
      loadingTitle: 'Loading...',
      loadingProgress: 0,
      loadingInterval: null,
      minLoadingTime: 200, // Ultra-fast minimum time
      startTime: null,
      maxLoadingTime: 3000, // Reduced maximum time
      timeoutId: null
    }
  },
  methods: {
    start(message = '', title = 'Loading...', minTime = 200, maxTime = 3000) {
      // Clear any existing loading
      this.forceStop()
      
      this.isLoading = true
      this.loadingMessage = message
      this.loadingTitle = title
      this.loadingProgress = 0
      this.minLoadingTime = minTime
      this.maxLoadingTime = maxTime
      this.startTime = Date.now()
      
      // Ultra-fast progress simulation
      this.loadingInterval = setInterval(() => {
        if (this.loadingProgress < 90) {
          // Much faster progress increments
          this.loadingProgress += Math.random() * 35 + 15
          if (this.loadingProgress > 90) {
            this.loadingProgress = 90
          }
        }
      }, 50) // Faster interval (was 100ms)
      
      // Set maximum loading time timeout
      this.timeoutId = setTimeout(() => {
        console.warn('Loading timeout reached, forcing completion')
        this.complete()
      }, maxTime)
    },
    
    complete() {
      const elapsed = Date.now() - this.startTime
      
      // Ensure minimum loading time but don't block too long
      if (elapsed < this.minLoadingTime) {
        setTimeout(() => {
          this.completeInternal()
        }, this.minLoadingTime - elapsed)
      } else {
        this.completeInternal()
      }
    },
    
    completeInternal() {
      // Clear all intervals and timeouts
      clearInterval(this.loadingInterval)
      clearTimeout(this.timeoutId)
      
      this.loadingProgress = 100
      
      // Ultra-fast fade out
      setTimeout(() => {
        this.isLoading = false
        this.loadingMessage = ''
        this.loadingTitle = 'Loading...'
        this.loadingProgress = 0
      }, 100) // Ultra-fast fade out (was 150ms)
    },
    
    forceStop() {
      // Immediate stop without animation
      clearInterval(this.loadingInterval)
      clearTimeout(this.timeoutId)
      this.isLoading = false
      this.loadingMessage = ''
      this.loadingTitle = 'Loading...'
      this.loadingProgress = 0
    }
  },
  
  // Global exposure with improved API
  mounted() {
    window.pageLoading = {
      start: this.start,
      finish: this.finish,
      forceStop: this.forceStop,
      isLoading: () => this.isLoading,
      getProgress: () => this.loadingProgress
    }
  },
  
  beforeUnmount() {
    // Clean up all timers
    clearInterval(this.loadingInterval)
    clearTimeout(this.timeoutId)
  }
}
</script>

<style scoped>
.page-loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 9999;
  pointer-events: auto; /* Allow interaction */
}

.loading-backdrop {
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.6); /* Reduced opacity */
  backdrop-filter: blur(1px); /* Reduced blur */
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer; /* Indicate clickable */
}

.loading-container {
  background: rgba(255, 255, 255, 0.95);
  border-radius: 12px; /* Smaller radius */
  padding: 1.5rem; /* Reduced padding */
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
  text-align: center;
  max-width: 350px; /* Smaller max width */
  animation: loadingEntrance 0.3s ease-out; /* Faster animation */
  cursor: default; /* Override backdrop cursor */
  position: relative;
}

.loading-spinner {
  margin-bottom: 1rem;
}

.spinner-ring {
  display: inline-block;
  width: 10px; /* Smaller size */
  height: 10px;
  border: 2px solid rgba(99, 102, 241, 0.2);
  border-radius: 50%;
  border-top-color: #6366f1;
  animation: spin 1s linear infinite; /* Faster animation */
  margin: 0 3px;
}

.spinner-ring:nth-child(2) {
  animation-delay: -0.25s;
}

.spinner-ring:nth-child(3) {
  animation-delay: -0.5s;
}

.spinner-ring:nth-child(4) {
  animation-delay: -0.75s;
}

.loading-text h3 {
  color: #1f2937;
  font-size: 1.1rem; /* Smaller text */
  font-weight: 600;
  margin-bottom: 0.5rem;
}

.loading-text p {
  color: #6b7280;
  font-size: 0.8rem;
  margin: 0 0 1rem 0;
}

.cancel-loading-btn {
  background: #ef4444;
  color: white;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 6px;
  font-size: 0.75rem;
  cursor: pointer;
  transition: all 0.2s ease;
}

.cancel-loading-btn:hover {
  background: #dc2626;
  transform: translateY(-1px);
}

.loading-progress {
  margin-top: 1rem;
}

.progress-bar {
  width: 100%;
  height: 4px; /* Smaller height */
  background: #e5e7eb;
  border-radius: 2px;
  overflow: hidden;
  margin-bottom: 0.5rem;
}

.progress-fill {
  height: 100%;
  background: linear-gradient(90deg, #6366f1, #8b5cf6);
  border-radius: 2px;
  transition: width 0.2s ease; /* Faster transition */
}

.progress-text {
  color: #6b7280;
  font-size: 0.7rem; /* Smaller text */
  font-weight: 500;
}

/* Loading entrance animation - ultra-fast */
@keyframes loadingEntrance {
  0% {
    opacity: 0;
    transform: scale(0.95) translateY(5px); /* Minimal movement */
  }
  100% {
    opacity: 1;
    transform: scale(1) translateY(0);
  }
}

/* Loading fade transition - ultra-fast */
.loading-fade-enter-active,
.loading-fade-leave-active {
  transition: all 0.1s ease; /* Ultra-fast transition */
}

.loading-fade-enter-from {
  opacity: 0;
  transform: scale(0.98);
}

.loading-fade-leave-to {
  opacity: 0;
  transform: scale(1.02);
}

/* Spinner animation - ultra-fast */
@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Responsive design */
@media (max-width: 640px) {
  .loading-container {
    margin: 1rem;
    padding: 1rem;
    max-width: calc(100% - 2rem);
  }
  
  .loading-spinner {
    margin-bottom: 0.75rem;
  }
}

/* Reduce motion for accessibility */
@media (prefers-reduced-motion: reduce) {
  .spinner-ring {
    animation: none;
    border-top-color: #6366f1;
  }
  
  .loading-fade-enter-active,
  .loading-fade-leave-active {
    transition: none;
  }
  
  @keyframes loadingEntrance {
    0% { opacity: 0; }
    100% { opacity: 1; }
  }
}

/* Ensure loading doesn't block page interaction */
.page-loading-overlay * {
  pointer-events: auto;
}

/* Allow clicking through to cancel */
.loading-backdrop {
  pointer-events: auto;
}

.loading-container {
  pointer-events: auto;
}
</style>
