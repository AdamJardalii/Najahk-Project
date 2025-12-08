import { createRouter, createWebHistory } from 'vue-router';
import PairSumSolver from './components/PairSumSolver.vue';
import QuotesGallery from './components/QuotesGallery.vue';

const routes = [
  {
    path: '/', // homepage
    name: 'PairSum',
    component: PairSumSolver,
  },
  {
    path: '/quotes', // quotes gallery page
    name: 'QuotesGallery',
    component: QuotesGallery,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
