<template>
  <transition 
    :name="transitionName" 
    mode="out-in" 
    appear
    @before-enter="beforeEnter"
    @enter="enter"
    @after-enter="afterEnter"
    @before-leave="beforeLeave"
    @leave="leave"
    @after-leave="afterLeave"
  >
    <div class="page-transition-container">
      <slot />
    </div>
  </transition>
</template>

<script>
export default {
  name: 'PageTransition',
  data() {
    return {
      transitionName: 'fade',
      previousRoute: null
    }
  },
  watch: {
    '$route'(to, from) {
      this.previousRoute = from
      
      // Only start loading for actual data loading, not just navigation changes
      const shouldLoad = this.shouldShowLoading(to, from)
      
      if (shouldLoad) {
        this.startRouteLoading(to, from)
      }
      
      // Determine transition based on route hierarchy and type
      const transitionType = this.getTransitionType(to, from)
      this.transitionName = transitionType
      
      // Add page entrance animation class only when loading
      if (shouldLoad) {
        document.body.classList.add('page-transitioning')
      }
    }
  },
  methods: {
    getTransitionType(to, from) {
      if (!from) {
        return 'fade-scale' // Initial page load
      }
      
      // Get route depth
      const toDepth = to.path.split('/').filter(Boolean).length
      const fromDepth = from.path.split('/').filter(Boolean).length
      
      // Check for specific route transitions
      if (to.name === 'login' || from.name === 'login') {
        return 'flip'
      }
      
      if (to.path.includes('/system/') || from.path.includes('/system/')) {
        return 'slide-left'
      }
      
      if (to.name === 'dashboard' || from.name === 'dashboard') {
        return 'fade'
      }
      
      // Depth-based transitions
      if (toDepth > fromDepth) {
        return 'slide-left'
      } else if (toDepth < fromDepth) {
        return 'slide-right'
      }
      
      return 'fade'
    },
    
    shouldShowLoading(to, from) {
      // Only show loading for initial page load or when coming from login
      // Don't show for navigation between authenticated pages
      const isInitialLoad = !from
      const isFromLogin = from && (from.name === 'login' || from.path === '/login')
      
      // Don't show loading when navigating between main app pages
      const mainAppRoutes = ['dashboard', 'employees', 'payroll', 'discipline', 'compliance', 'attendance', 'leave', 'recruitment', 'performance', 'training']
      const isToMainApp = mainAppRoutes.includes(to.name)
      
      // Show loading for initial page load or from login to main app
      return isInitialLoad || (isFromLogin && isToMainApp)
    },
    
    beforeEnter(el) {
      // Set initial state
      el.style.opacity = '0'
      el.style.transform = 'translateY(30px) scale(0.95)'
    },
    
    enter(el, done) {
      // Trigger reflow
      el.offsetHeight
      
      // Apply transition
      el.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)'
      el.style.opacity = '1'
      el.style.transform = 'translateY(0) scale(1)'
      
      setTimeout(done, 500)
    },
    
    afterEnter(el) {
      // Clean up
      el.style.transition = ''
      el.style.transform = ''
      document.body.classList.remove('page-transitioning')
      
      // Add entrance animation to content only when loading is active
      if (window.pageLoading && window.pageLoading.isLoading()) {
        this.addContentAnimation(el)
      }
      
      // Finish loading after content is ready
      setTimeout(() => {
        this.finishRouteLoading()
      }, 300)
    },
    
    beforeLeave(el) {
      el.style.opacity = '1'
      el.style.transform = 'translateY(0) scale(1)'
    },
    
    leave(el, done) {
      el.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)'
      el.style.opacity = '0'
      el.style.transform = 'translateY(-30px) scale(1.05)'
      
      setTimeout(done, 400)
    },
    
    afterLeave(el) {
      el.style.transition = ''
      el.style.transform = ''
    },
    
    addContentAnimation(container) {
      // Add stagger animation to child elements
      const children = container.querySelectorAll('.card, .btn, .table, h1, h2, h3')
      children.forEach((child, index) => {
        child.style.opacity = '0'
        child.style.transform = 'translateY(20px)'
        child.style.transition = 'all 0.6s ease'
        
        setTimeout(() => {
          child.style.opacity = '1'
          child.style.transform = 'translateY(0)'
        }, 100 + (index * 50))
      })
    },
    
    startRouteLoading(to, from) {
      // Start loading with contextual message but with shorter time
      const loadingMessages = {
        'dashboard': 'Loading dashboard...',
        'employees': 'Preparing employee data...',
        'payroll': 'Calculating payroll information...',
        'discipline': 'Loading discipline records...',
        'compliance': 'Checking compliance data...',
        'attendance': 'Loading attendance records...',
        'leave': 'Loading leave information...',
        'recruitment': 'Preparing recruitment data...',
        'performance': 'Loading performance reviews...',
        'training': 'Loading training programs...',
        'system': 'Accessing system settings...'
      }
      
      const message = loadingMessages[to.name] || 'Loading page...'
      
      // Use global page loading if available with ultra-fast timing
      if (window.pageLoading) {
        window.pageLoading.start(message, 200) // Ultra-fast minimum time
      }
    },
    
    finishRouteLoading() {
      // Finish loading
      if (window.pageLoading) {
        window.pageLoading.finish()
      }
    }
  }
}
</script>

<style scoped>
.page-transition-container {
  width: 100%;
  height: 100%;
}

/* Fade transition */
.fade-enter-active,
.fade-leave-active {
  transition: all 0.4s ease;
}

.fade-enter-from {
  opacity: 0;
  transform: translateY(20px);
}

.fade-leave-to {
  opacity: 0;
  transform: translateY(-20px);
}

/* Fade + Scale transition */
.fade-scale-enter-active,
.fade-scale-leave-active {
  transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.fade-scale-enter-from {
  opacity: 0;
  transform: translateY(30px) scale(0.9);
}

.fade-scale-leave-to {
  opacity: 0;
  transform: translateY(-30px) scale(1.1);
}

/* Slide left transition */
.slide-left-enter-active,
.slide-left-leave-active {
  transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.slide-left-enter-from {
  opacity: 0;
  transform: translateX(100px);
}

.slide-left-leave-to {
  opacity: 0;
  transform: translateX(-100px);
}

/* Slide right transition */
.slide-right-enter-active,
.slide-right-leave-active {
  transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.slide-right-enter-from {
  opacity: 0;
  transform: translateX(-100px);
}

.slide-right-leave-to {
  opacity: 0;
  transform: translateX(100px);
}

/* Flip transition */
.flip-enter-active,
.flip-leave-active {
  transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
  perspective: 1000px;
}

.flip-enter-from {
  opacity: 0;
  transform: rotateY(-90deg) translateZ(-50px);
}

.flip-leave-to {
  opacity: 0;
  transform: rotateY(90deg) translateZ(50px);
}

/* Slide up transition */
.slide-up-enter-active,
.slide-up-leave-active {
  transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.slide-up-enter-from {
  opacity: 0;
  transform: translateY(50px);
}

.slide-up-leave-to {
  opacity: 0;
  transform: translateY(-50px);
}

/* Slide down transition */
.slide-down-enter-active,
.slide-down-leave-active {
  transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.slide-down-enter-from {
  opacity: 0;
  transform: translateY(-50px);
}

.slide-down-leave-to {
  opacity: 0;
  transform: translateY(50px);
}

/* Scale transition */
.scale-enter-active,
.scale-leave-active {
  transition: all 0.4s ease;
}

.scale-enter-from {
  opacity: 0;
  transform: scale(0.8);
}

.scale-leave-to {
  opacity: 0;
  transform: scale(1.2);
}

/* Global transition styles */
:global(.page-transitioning) {
  pointer-events: none;
}

:global(.page-transitioning *) {
  pointer-events: none;
}

/* Reduce motion for accessibility */
@media (prefers-reduced-motion: reduce) {
  .fade-enter-active,
  .fade-leave-active,
  .fade-scale-enter-active,
  .fade-scale-leave-active,
  .slide-left-enter-active,
  .slide-left-leave-active,
  .slide-right-enter-active,
  .slide-right-leave-active,
  .flip-enter-active,
  .flip-leave-active,
  .slide-up-enter-active,
  .slide-up-leave-active,
  .slide-down-enter-active,
  .slide-down-leave-active,
  .scale-enter-active,
  .scale-leave-active {
    transition: none !important;
  }
  
  .fade-enter-from,
  .fade-leave-to,
  .fade-scale-enter-from,
  .fade-scale-leave-to,
  .slide-left-enter-from,
  .slide-left-leave-to,
  .slide-right-enter-from,
  .slide-right-leave-to,
  .flip-enter-from,
  .flip-leave-to,
  .slide-up-enter-from,
  .slide-up-leave-to,
  .slide-down-enter-from,
  .slide-down-leave-to,
  .scale-enter-from,
  .scale-leave-to {
    transform: none !important;
  }
}
</style>
