<template>
  <AppLayout>
    <PageTransition>
      <router-view />
    </PageTransition>
    <PageLoading />
  </AppLayout>
</template>

<script>
import AppLayout from './components/AppLayout.vue'
import PageTransition from './components/PageTransition.vue'
import PageLoading from './components/PageLoading.vue'

export default {
  name: 'App',
  components: {
    AppLayout,
    PageTransition,
    PageLoading
  }
}
</script>

<style>
/* Global styles */
@import './styles/app.css';

/* Global page transition styles */
.page-enter-active,
.page-leave-active {
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.page-enter-from {
  opacity: 0;
  transform: translateY(30px) scale(0.95);
}

.page-leave-to {
  opacity: 0;
  transform: translateY(-30px) scale(1.05);
}

/* Smooth scroll behavior */
html {
  scroll-behavior: smooth;
}

/* Page loading animation */
@keyframes pageLoad {
  0% {
    opacity: 0;
    transform: translateY(20px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}

.page-content {
  animation: pageLoad 0.6s ease-out;
}

/* Reduce motion for users who prefer it */
@media (prefers-reduced-motion: reduce) {
  .page-enter-active,
  .page-leave-active {
    transition: none;
  }
  
  .page-enter-from,
  .page-leave-to {
    transform: none;
  }
}
</style>
