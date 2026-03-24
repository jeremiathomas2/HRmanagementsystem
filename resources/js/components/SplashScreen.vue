<template>
  <div class="splash-screen">
    <!-- Background Animation -->
    <div class="absolute inset-0 bg-gradient-to-br from-indigo-900 via-blue-900 to-purple-900">
      <div class="absolute inset-0 bg-black opacity-20"></div>
      
      <!-- Animated Particles -->
      <div class="particles-container">
        <div v-for="particle in particles" :key="particle.id" 
             class="particle"
             :style="{
               left: particle.x + '%',
               animationDelay: particle.delay + 's',
               animationDuration: particle.duration + 's'
             }">
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 flex flex-col items-center justify-center min-h-screen px-4">
      <!-- Logo Container -->
      <div class="logo-container mb-8">
        <div class="logo-wrapper">
          <div class="logo-bg">
            <div class="logo-inner">
              <span class="logo-text">HR</span>
            </div>
          </div>
          <!-- Logo Glow Effect -->
          <div class="logo-glow"></div>
        </div>
      </div>

      <!-- Welcome Text -->
      <div class="text-container mb-12 text-center">
        <h1 class="welcome-title">
          <span class="title-word" v-for="(word, index) in titleWords" :key="index" 
                :style="{ animationDelay: (index * 0.15) + 's' }">
            {{ word }}
          </span>
        </h1>
        <p class="welcome-subtitle" style="animation-delay: 0.6s">
          Tanzania's Premier HR Management Solution
        </p>
        <p class="welcome-description" style="animation-delay: 0.9s">
          Streamlining workforce management with cutting-edge technology
        </p>
      </div>

      <!-- Loading Animation -->
      <div class="loading-container" style="animation-delay: 1.2s">
        <div class="loading-bar">
          <div class="loading-progress" :style="{ width: loadingProgress + '%' }"></div>
        </div>
        <div class="loading-text">
          <span v-if="loadingProgress < 30">Initializing System...</span>
          <span v-else-if="loadingProgress < 60">Loading Resources...</span>
          <span v-else-if="loadingProgress < 90">Preparing Interface...</span>
          <span v-else>Almost Ready...</span>
        </div>
        
        <!-- Loading Dots -->
        <div class="loading-dots">
          <div class="dot" v-for="dot in 3" :key="dot" 
               :style="{ animationDelay: (dot * 0.2) + 's' }"></div>
        </div>
      </div>

      <!-- Feature Icons -->
      <div class="features-grid" style="animation-delay: 1.5s">
        <div class="feature-item" v-for="feature in features" :key="feature.id"
             :style="{ animationDelay: (1.5 + feature.id * 0.1) + 's' }">
          <div class="feature-icon">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    :d="feature.icon"></path>
            </svg>
          </div>
          <span class="feature-text">{{ feature.name }}</span>
        </div>
      </div>

      <!-- Version Info -->
      <div class="version-info" style="animation-delay: 2s">
        <p>Version 2.1.0 • PDPA Compliant • 256-bit SSL</p>
      </div>
    </div>

    <!-- Skip Button -->
    <button @click="skipSplash" 
            class="skip-button"
            style="animation-delay: 2.5s">
      Skip to Login →
    </button>
  </div>
</template>

<script>
export default {
  name: 'SplashScreen',
  data() {
    return {
      loadingProgress: 0,
      titleWords: ['Welcome', 'to', 'HR', 'Management', 'System'],
      particles: [],
      features: [
        { id: 1, name: 'Employee Management', icon: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z' },
        { id: 2, name: 'Payroll System', icon: 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1l3 3m-3-4l-3 3m0 4v2m0-6V4m0 6v2m0-6V4' },
        { id: 3, name: 'Contract Management', icon: 'M9 12h6m-6 0h6m2 6H9m9 6V9m0 6v6m0-6h6m-6 0h6M9 3H5a2 2 0 00-2 2v4a2 2 0 002 2h4a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2z' },
        { id: 4, name: 'Analytics Dashboard', icon: 'M3 3v18h18V3H3zm16 16H5V5h14v14zM7 7h2v2H7V7zm4 0h2v2h-2V7zm4 0h2v2h-2V7zM7 11h2v2H7v-2zm4 0h2v2h-2v-2zm4 0h2v2h-2v-2zM7 15h2v2H7v-2zm4 0h2v2h-2v-2zm4 0h2v2h-2v-2z' }
      ]
    }
  },
  mounted() {
    this.generateParticles()
    this.startLoading()
    
    // Auto-redirect after 5 seconds
    setTimeout(() => {
      this.navigateToLogin()
    }, 5000)
  },
  methods: {
    generateParticles() {
      for (let i = 0; i < 50; i++) {
        this.particles.push({
          id: i,
          x: Math.random() * 100,
          delay: Math.random() * 5,
          duration: 3 + Math.random() * 4
        })
      }
    },
    startLoading() {
      const interval = setInterval(() => {
        if (this.loadingProgress < 100) {
          this.loadingProgress += Math.random() * 15
          if (this.loadingProgress > 100) {
            this.loadingProgress = 100
          }
        } else {
          clearInterval(interval)
        }
      }, 200)
    },
    skipSplash() {
      this.navigateToLogin()
    },
    navigateToLogin() {
      this.$emit('complete')
    }
  }
}
</script>

<style scoped>
/* Ensure all text is white */
.splash-screen * {
  color: white !important;
}

/* Override specific text colors while maintaining white */
.splash-screen .welcome-title,
.splash-screen .welcome-subtitle,
.splash-screen .welcome-description,
.splash-screen .loading-text,
.splash-screen .version-info,
.splash-screen .feature-text,
.splash-screen .logo-text {
  color: white !important;
}

/* Ensure icons and SVG elements are white */
.splash-screen svg,
.splash-screen .feature-icon,
.splash-screen .loading-dots {
  color: white !important;
  fill: white !important;
  stroke: white !important;
}

/* Ensure any input or button text is white */
.splash-screen input,
.splash-screen button,
.splash-screen .get-started-btn {
  color: white !important;
}

.splash-screen {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  overflow: hidden;
  z-index: 9999;
}

/* Particles */
.particles-container {
  position: absolute;
  width: 100%;
  height: 100%;
  overflow: hidden;
}

.particle {
  position: absolute;
  width: 4px;
  height: 4px;
  background: rgba(255, 255, 255, 0.8);
  border-radius: 50%;
  animation: float linear infinite;
}

@keyframes float {
  0% {
    transform: translateY(100vh) rotate(0deg);
    opacity: 0;
  }
  10% {
    opacity: 1;
  }
  90% {
    opacity: 1;
  }
  100% {
    transform: translateY(-100vh) rotate(720deg);
    opacity: 0;
  }
}

/* Logo Animation */
.logo-container {
  animation: slideDown 0.8s ease-out;
}

.logo-wrapper {
  position: relative;
  display: inline-block;
}

.logo-bg {
  width: 80px;
  height: 80px;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
  animation: pulse 2s infinite;
}

.logo-inner {
  width: 70px;
  height: 70px;
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(10px);
  border-radius: 15px;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 1px solid rgba(255, 255, 255, 0.2);
}

.logo-text {
  color: white;
  font-size: 28px;
  font-weight: bold;
  letter-spacing: 2px;
}

.logo-glow {
  position: absolute;
  top: -10px;
  left: -10px;
  right: -10px;
  bottom: -10px;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 30px;
  filter: blur(20px);
  opacity: 0.6;
  z-index: -1;
  animation: glow 2s ease-in-out infinite alternate;
}

@keyframes pulse {
  0%, 100% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.05);
  }
}

@keyframes glow {
  0% {
    opacity: 0.4;
  }
  100% {
    opacity: 0.8;
  }
}

/* Text Animations */
.text-container {
  animation: fadeIn 1s ease-out;
}

.welcome-title {
  font-size: 3.5rem;
  font-weight: 800;
  color: white;
  margin-bottom: 1rem;
  text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 0.5rem;
}

.title-word {
  display: inline-block;
  animation: slideInFromBottom 0.8s ease-out forwards;
  opacity: 0;
}

.welcome-subtitle {
  font-size: 1.5rem;
  color: rgba(255, 255, 255, 0.9);
  margin-bottom: 0.5rem;
  animation: fadeIn 1s ease-out forwards;
  opacity: 0;
}

.welcome-description {
  font-size: 1.1rem;
  color: rgba(255, 255, 255, 0.8);
  animation: fadeIn 1s ease-out forwards;
  opacity: 0;
}

@keyframes slideInFromBottom {
  0% {
    transform: translateY(30px);
    opacity: 0;
  }
  100% {
    transform: translateY(0);
    opacity: 1;
  }
}

@keyframes fadeIn {
  0% {
    opacity: 0;
    transform: translateY(20px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Loading Animation */
.loading-container {
  width: 100%;
  max-width: 400px;
  animation: fadeIn 1s ease-out forwards;
  opacity: 0;
}

.loading-bar {
  width: 100%;
  height: 6px;
  background: rgba(255, 255, 255, 0.2);
  border-radius: 3px;
  overflow: hidden;
  margin-bottom: 1rem;
}

.loading-progress {
  height: 100%;
  background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
  border-radius: 3px;
  transition: width 0.3s ease;
  box-shadow: 0 0 10px rgba(102, 126, 234, 0.5);
}

.loading-text {
  color: white;
  font-size: 1rem;
  text-align: center;
  margin-bottom: 1rem;
  font-weight: 500;
}

.loading-dots {
  display: flex;
  justify-content: center;
  gap: 0.5rem;
}

.dot {
  width: 8px;
  height: 8px;
  background: white;
  border-radius: 50%;
  animation: bounce 1.4s infinite ease-in-out both;
}

@keyframes bounce {
  0%, 80%, 100% {
    transform: scale(0);
  }
  40% {
    transform: scale(1);
  }
}

/* Features Grid */
.features-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1.5rem;
  width: 100%;
  max-width: 800px;
  margin: 3rem 0;
  animation: fadeIn 1s ease-out forwards;
  opacity: 0;
}

.feature-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  padding: 1.5rem;
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(10px);
  border-radius: 15px;
  border: 1px solid rgba(255, 255, 255, 0.2);
  animation: slideUp 0.8s ease-out forwards;
  opacity: 0;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.feature-item:hover {
  transform: translateY(-5px);
  background: rgba(255, 255, 255, 0.15);
  border-color: rgba(255, 255, 255, 0.3);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
}

.feature-item:hover .feature-icon {
  background: rgba(255, 255, 255, 0.25);
  transform: scale(1.1);
}

.feature-item:hover .feature-icon svg {
  stroke-width: 2.5;
  filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.5));
}

.feature-icon {
  width: 50px;
  height: 50px;
  background: rgba(255, 255, 255, 0.2);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 1rem;
  color: white;
  position: relative;
  overflow: hidden;
}

.feature-icon svg {
  width: 24px;
  height: 24px;
  color: white !important;
  fill: none !important;
  stroke: white !important;
  stroke-width: 2;
  flex-shrink: 0;
  z-index: 1;
}

.feature-icon::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
  border-radius: 12px;
  z-index: 0;
}

.feature-text {
  color: white;
  font-size: 0.9rem;
  font-weight: 500;
}

@keyframes slideUp {
  0% {
    transform: translateY(30px);
    opacity: 0;
  }
  100% {
    transform: translateY(0);
    opacity: 1;
  }
}

/* Version Info */
.version-info {
  position: absolute;
  bottom: 2rem;
  color: rgba(255, 255, 255, 0.6);
  font-size: 0.85rem;
  animation: fadeIn 1s ease-out forwards;
  opacity: 0;
}

/* Skip Button */
.skip-button {
  position: absolute;
  bottom: 5rem;
  right: 2rem;
  padding: 0.75rem 1.5rem;
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 25px;
  color: white;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
  animation: fadeIn 1s ease-out forwards;
  opacity: 0;
}

.skip-button:hover {
  background: rgba(255, 255, 255, 0.2);
  transform: translateY(-2px);
}

/* Responsive Design */
@media (max-width: 768px) {
  .welcome-title {
    font-size: 2.5rem;
  }
  
  .welcome-subtitle {
    font-size: 1.2rem;
  }
  
  .welcome-description {
    font-size: 1rem;
  }
  
  .features-grid {
    grid-template-columns: 1fr;
    gap: 1rem;
  }
  
  .logo-bg {
    width: 60px;
    height: 60px;
  }
  
  .logo-inner {
    width: 50px;
    height: 50px;
  }
  
  .logo-text {
    font-size: 20px;
  }
}

@media (max-width: 480px) {
  .skip-button {
    bottom: 2rem;
    right: 1rem;
    left: 1rem;
    text-align: center;
  }
}
</style>
