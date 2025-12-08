// import './bootstrap';
// import { createApp } from 'vue';
// import PairSumSolver from './components/PairSumSolver.vue';
// import QuotesGallery from './components/QuotesGallery.vue';

// // createApp(PairSumSolver).mount('#app');

// // const app = createApp({});

// // app.component('pair-sum-solver', PairSumSolver);
// // app.component('quotes-gallery', QuotesGallery);

// import App from './App.vue';

// createApp(App).mount('#app');

import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';

createApp(App).use(router).mount('#app');
