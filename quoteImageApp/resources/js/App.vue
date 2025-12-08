<template>
  <div class="min-h-screen bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50">
    <!-- Navigation -->
    <nav class="bg-white/80 backdrop-blur-md shadow-lg sticky top-0 z-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
          <!-- Logo/Brand -->
          <div class="flex-shrink-0">
            <h1 class="text-2xl font-bold">
              <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600">
                Najahak.io Backend Assesment!
              </span>
            </h1>
          </div>

          <!-- Desktop Navigation -->
          <div class="hidden md:flex items-center space-x-2">
            <button
              @click="currentComponent = 'PairSumSolver'"
              :class="currentComponent === 'PairSumSolver' ? activeClass : inactiveClass"
            >
              <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                  </path>
                </svg>
                <span>Pair Sum Solver</span>
              </div>
            </button>

            <button
              @click="currentComponent = 'QuotesGallery'"
              :class="currentComponent === 'QuotesGallery' ? activeClass : inactiveClass"
            >
              <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                  </path>
                </svg>
                <span>Quotes Gallery</span>
              </div>
            </button>
          </div>

          <!-- Mobile Menu Button -->
          <div class="md:hidden">
            <button
              @click="mobileMenuOpen = !mobileMenuOpen"
              class="inline-flex items-center justify-center p-2 rounded-full text-gray-700 hover:bg-purple-100 focus:outline-none transition-all duration-300"
            >
              <svg v-if="!mobileMenuOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
              </svg>
              <svg v-else class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Mobile Menu -->
      <transition
        enter-active-class="transition ease-out duration-200"
        enter-from-class="opacity-0 -translate-y-2"
        enter-to-class="opacity-100 translate-y-0"
        leave-active-class="transition ease-in duration-150"
        leave-from-class="opacity-100 translate-y-0"
        leave-to-class="opacity-0 -translate-y-2"
      >
        <div v-if="mobileMenuOpen" class="md:hidden bg-white border-t border-gray-200">
          <div class="px-4 pt-4 pb-6 space-y-3">
            <button
              @click="currentComponent = 'PairSumSolver'; mobileMenuOpen = false"
              :class="currentComponent === 'PairSumSolver' ? activeClass : inactiveClass"
              class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-300 w-full text-left"
            >
              Pair Sum Solver
            </button>

            <button
              @click="currentComponent = 'QuotesGallery'; mobileMenuOpen = false"
              :class="currentComponent === 'QuotesGallery' ? activeClass : inactiveClass"
              class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-300 w-full text-left"
            >
              Quotes Gallery
            </button>
          </div>
        </div>
      </transition>
    </nav>

    <!-- Main Content -->
    <main class="min-h-[calc(100vh-5rem)] p-8">
      <component :is="currentComponent"></component>
    </main>
  </div>
</template>

<script>
import PairSumSolver from './components/PairSumSolver.vue';
import QuotesGallery from './components/QuotesGallery.vue';

export default {
  name: 'App',
  components: { PairSumSolver, QuotesGallery },
  data() {
    return {
      mobileMenuOpen: false,
      currentComponent: 'PairSumSolver',
      activeClass: 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg px-4 py-2 rounded',
      inactiveClass: 'text-gray-700 hover:bg-purple-100 px-4 py-2 rounded'
    };
  }
};
</script>

<style>
button {
  transition: all 0.2s;
}

body{
background-color:red;
}
</style>