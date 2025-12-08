<template>
  <div>
    <!-- Loading State -->
    <div v-if="loading" class="min-h-screen bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50 flex items-center justify-center">
      <div class="text-center">
        <div class="inline-block animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-purple-600"></div>
        <p class="mt-4 text-xl text-gray-700 font-medium">Loading inspiring quotes...</p>
      </div>
    </div>

    <!-- Main Content -->
    <div v-else class="min-h-screen bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50 py-12 px-4">
      <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
          <h1 class="text-5xl font-bold text-gray-800 mb-4">
            Inspiring <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600">Quotes</span>
          </h1>
          <p class="text-gray-600 text-lg">Discover wisdom and motivation for your day</p>
          <p class="text-gray-500 mt-2">{{ totalCount }} quotes available</p>
          <button
            @click="handleRefresh"
            class="mt-6 inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-full hover:shadow-lg transition-all duration-300 hover:scale-105"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Refresh Page
          </button>
        </div>

        <!-- Quotes Grid -->
        <transition-group name="fade" tag="div" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8 mb-12">
          <div
            v-for="quote in quotes"
            :key="quote._id"
            class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2"
          >
            <div class="relative h-64 overflow-hidden">
              <img
                :src="quote.image"
                :alt="'Quote by ' + quote.author"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
            </div>
            
            <div class="p-6 relative -mt-20 z-10">
              <div class="bg-white rounded-xl p-6 shadow-xl">
                <svg class="w-10 h-10 text-purple-600 mb-3" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                </svg>
                <p class="text-gray-800 text-lg leading-relaxed mb-4 font-medium">
                  {{ quote.content }}
                </p>
                <div class="flex items-center justify-between flex-wrap gap-2">
                  <p class="text-purple-600 font-semibold">— {{ quote.author }}</p>
                  <div v-if="quote.tags.length > 0" class="flex gap-2 flex-wrap">
                    <span
                      v-for="(tag, index) in quote.tags"
                      :key="index"
                      class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm"
                    >
                      {{ tag }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </transition-group>

        <!-- Pagination -->
        <div class="flex items-center justify-center gap-4 mt-12 flex-wrap">
          <button
            @click="handlePrevPage"
            :disabled="currentPage === 1"
            :class="[
              'flex items-center gap-2 px-6 py-3 rounded-full font-medium transition-all duration-300',
              currentPage === 1
                ? 'bg-gray-200 text-gray-400 cursor-not-allowed'
                : 'bg-white text-purple-600 hover:bg-purple-600 hover:text-white shadow-lg hover:shadow-xl'
            ]"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Previous
          </button>

          <div class="flex items-center gap-2">
            <!-- First page -->
            <template v-if="currentPage > 3 && totalPages > 5">
              <button
                @click="handlePageClick(1)"
                class="w-10 h-10 rounded-full font-medium bg-white text-gray-700 hover:bg-purple-100 transition-all duration-300"
              >
                1
              </button>
              <span class="text-gray-500">...</span>
            </template>
            
            <!-- Page numbers -->
            <button
              v-for="page in pageNumbers"
              :key="page"
              @click="handlePageClick(page)"
              :class="[
                'w-10 h-10 rounded-full font-medium transition-all duration-300',
                currentPage === page
                  ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg scale-110'
                  : 'bg-white text-gray-700 hover:bg-purple-100'
              ]"
            >
              {{ page }}
            </button>
            
            <!-- Last page -->
            <template v-if="currentPage < totalPages - 2 && totalPages > 5">
              <span class="text-gray-500">...</span>
              <button
                @click="handlePageClick(totalPages)"
                class="w-10 h-10 rounded-full font-medium bg-white text-gray-700 hover:bg-purple-100 transition-all duration-300"
              >
                {{ totalPages }}
              </button>
            </template>
          </div>

          <button
            @click="handleNextPage"
            :disabled="currentPage === totalPages"
            :class="[
              'flex items-center gap-2 px-6 py-3 rounded-full font-medium transition-all duration-300',
              currentPage === totalPages
                ? 'bg-gray-200 text-gray-400 cursor-not-allowed'
                : 'bg-white text-purple-600 hover:bg-purple-600 hover:text-white shadow-lg hover:shadow-xl'
            ]"
          >
            Next
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </button>
        </div>

        <!-- Page Info -->
        <div class="text-center mt-8 text-gray-600">
          Page {{ currentPage }} of {{ totalPages }} • Showing {{ quotes.length }} quotes
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'QuotesGallery',
  data() {
    return {
      quotes: [],
      loading: true,
      currentPage: 1,
      totalPages: 0,
      totalCount: 0,
      itemsPerPage: 10
    };
  },
  computed: {
    pageNumbers() {
      const pages = [];
      const maxVisible = 5;
      
      if (this.totalPages <= maxVisible) {
        for (let i = 1; i <= this.totalPages; i++) {
          pages.push(i);
        }
      } else {
        if (this.currentPage <= 3) {
          for (let i = 1; i <= 5; i++) pages.push(i);
        } else if (this.currentPage >= this.totalPages - 2) {
          for (let i = this.totalPages - 4; i <= this.totalPages; i++) pages.push(i);
        } else {
          for (let i = this.currentPage - 2; i <= this.currentPage + 2; i++) pages.push(i);
        }
      }
      
      return pages;
    }
  },
  methods: {
    async fetchQuotes(page = 1) {
      this.loading = true;
      try {
        const response = await fetch(`https://api.quotable.io/quotes?limit=${this.itemsPerPage}&page=${page}`);
        const data = await response.json();
        
        // Add random images from Picsum
        this.quotes = data.results.map(quote => ({
          ...quote,
          image: `https://picsum.photos/seed/${quote._id}/400/300`
        }));
        
        this.totalPages = data.totalPages;
        this.totalCount = data.totalCount;
        this.currentPage = data.page;
      } catch (error) {
        console.error('Error fetching quotes:', error);
      }
      this.loading = false;
    },
    handleNextPage() {
      if (this.currentPage < this.totalPages) {
        this.fetchQuotes(this.currentPage + 1);
        window.scrollTo({ top: 0, behavior: 'smooth' });
      }
    },
    handlePrevPage() {
      if (this.currentPage > 1) {
        this.fetchQuotes(this.currentPage - 1);
        window.scrollTo({ top: 0, behavior: 'smooth' });
      }
    },
    handlePageClick(page) {
      this.fetchQuotes(page);
      window.scrollTo({ top: 0, behavior: 'smooth' });
    },
    handleRefresh() {
      this.fetchQuotes(this.currentPage);
    }
  },
  mounted() {
    this.fetchQuotes(1);
  }
};
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>