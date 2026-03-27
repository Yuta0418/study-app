import './bootstrap';

import Alpine from 'alpinejs';
import { createApp } from 'vue';
import AnalysisDashboard from './components/analysis/AnalysisDashboard.vue';

window.Alpine = Alpine;

Alpine.start();

const analysisRoot = document.getElementById('analysis-dashboard');

if (analysisRoot) {
    const payload = analysisRoot.dataset.payload;

    createApp(AnalysisDashboard, {
        initialData: payload ? JSON.parse(payload) : {},
    }).mount(analysisRoot);
}
