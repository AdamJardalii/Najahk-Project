<template>
  <div class="min-h-screen bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-100 py-8 px-4">
    <div class="max-w-4xl mx-auto">
      <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 mb-2">
          Pair Sum Solver - REST API
        </h1>
        <p class="text-gray-600">Find unique pairs that sum to your target via Laravel API</p>
      </div>

      <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-2xl shadow-2xl p-6 mb-6">
        <h2 class="text-xl font-bold mb-3 flex items-center">
          <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
          </svg>
          API Endpoint
        </h2>
        <p class="font-mono text-sm bg-white/20 rounded px-3 py-2">POST /api/pair-sum</p>
      </div>

      <div class="bg-white rounded-2xl shadow-2xl p-8 mb-6">
        <div class="space-y-6">
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
              Array Size (n)
            </label>
            <input 
              v-model.number="size"
              type="number" 
              placeholder="Enter array size"
              class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition"
            >
          </div>
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
              Target Sum
            </label>
            <input 
              v-model.number="targetSum"
              type="number" 
              placeholder="Enter target sum"
              class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition"
            >
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
              Array Elements (space-separated)
            </label>
            <textarea 
              v-model="numbersInput"
              rows="3"
              placeholder="Enter numbers separated by spaces (e.g., 1 5 7 -1 5)"
              class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition resize-none"
            ></textarea>
          </div>
          <button 
            @click="solvePairSum"
            :disabled="loading"
            class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold py-4 px-6 rounded-lg hover:from-indigo-700 hover:to-purple-700 transform hover:scale-[1.02] transition-all duration-200 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
          >
            <span class="flex items-center justify-center">
              <svg v-if="!loading" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
              </svg>
              <svg v-else class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              {{ loading ? 'Calling API...' : 'Solve via API' }}
            </span>
          </button>
        </div>
      </div>

      <transition name="fade">
        <div v-if="error" class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
          <div class="flex items-center">
            <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <p class="text-red-700 font-medium">{{ error }}</p>
          </div>
        </div>
      </transition>

      <transition name="slide-up">
        <div v-if="showResults" class="bg-white rounded-2xl shadow-2xl p-8">
          <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <svg class="w-6 h-6 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            API Response
          </h2>

          <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
              <div>
                <p class="text-sm text-gray-600 font-medium">Array Size</p>
                <p class="text-2xl font-bold text-indigo-600">{{ resultData.input.numbers.length }}</p>
              </div>
              <div>
                <p class="text-sm text-gray-600 font-medium">Target Sum</p>
                <p class="text-2xl font-bold text-purple-600">{{ resultData.input.targetSum }}</p>
              </div>
              <div>
                <p class="text-sm text-gray-600 font-medium">Pairs Found</p>
                <p class="text-2xl font-bold text-pink-600">{{ resultData.count }}</p>
              </div>
            </div>
            <div class="mt-4">
              <p class="text-sm text-gray-600 font-medium mb-2">Input Array</p>
              <div class="flex flex-wrap gap-2">
                <span 
                  v-for="(num, index) in resultData.input.numbers" 
                  :key="index"
                  class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-lg font-semibold"
                >
                  {{ num }}
                </span>
              </div>
            </div>
          </div>

          <div v-if="resultData.pairs.length > 0">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Unique Pairs</h3>
            <div class="space-y-3">
              <div 
                v-for="(pair, index) in resultData.pairs" 
                :key="index"
                class="flex items-center space-x-4 p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border-2 border-green-200 hover:border-green-300 transition-all"
              >
                <div class="flex-shrink-0 w-10 h-10 bg-green-500 text-white rounded-full flex items-center justify-center font-bold">
                  {{ index + 1 }}
                </div>
                <div class="flex items-center space-x-3 flex-1 flex-wrap">
                  <span class="px-4 py-2 bg-white text-green-700 rounded-lg font-bold text-lg shadow-sm">{{ pair[0] }}</span>
                  <span class="text-green-500 font-bold text-xl">+</span>
                  <span class="px-4 py-2 bg-white text-green-700 rounded-lg font-bold text-lg shadow-sm">{{ pair[1] }}</span>
                  <span class="text-green-500 font-bold text-xl">=</span>
                  <span class="px-4 py-2 bg-green-500 text-white rounded-lg font-bold text-lg shadow-sm">{{ resultData.input.targetSum }}</span>
                </div>
              </div>
            </div>
          </div>

          <div v-else class="text-center py-8">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-gray-500 text-lg">No pairs found that sum to the target</p>
          </div>

          <div class="mt-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Raw JSON Response</h3>
            <pre class="bg-gray-900 text-green-400 p-4 rounded-lg overflow-x-auto text-sm font-mono">{{ JSON.stringify(resultData, null, 2) }}</pre>
          </div>
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'PairSumSolver',
  data() {
    return {
      size: null,
      targetSum: null,
      numbersInput: '',
      loading: false,
      error: null,
      showResults: false,
      resultData: {
        input: {
          numbers: [],
          targetSum: 0
        },
        pairs: [],
        count: 0
      }
    };
  },
  methods: {
    async solvePairSum() {
      this.error = null;
      this.showResults = false;

      if (!this.size || this.size <= 0) {
        this.error = 'Please enter a valid array size greater than 0';
        return;
      }

      if (this.targetSum === null || this.targetSum === '') {
        this.error = 'Please enter a valid target sum';
        return;
      }

      if (!this.numbersInput.trim()) {
        this.error = 'Please enter array elements';
        return;
      }
      const numbers = this.numbersInput
        .match(/-?\d+/g) 
        ?.map(Number) || [];

      if (numbers.length !== this.size) {
        this.error = `Array size mismatch. Expected ${this.size} elements but got ${numbers.length}`;
        return;
      }

      this.loading = true;

      try {
        const response = await axios.post('/api/pair-sum', {
          numbers: numbers,
          targetSum: this.targetSum
        });

        this.resultData = response.data;
        this.showResults = true;

        this.$nextTick(() => {
          const resultsElement = document.querySelector('.bg-white.rounded-2xl.shadow-2xl.p-8');
          if (resultsElement) {
            resultsElement.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
          }
        });

      } catch (err) {
        if (err.response && err.response.data) {
          this.error = err.response.data.error || 'API request failed';
        } else {
          this.error = 'Failed to connect to API: ' + err.message;
        }
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}

.slide-up-enter-active {
  transition: all 0.4s ease-out;
}
.slide-up-enter-from {
  opacity: 0;
  transform: translateY(20px);
}
</style>