import '../scss/main.scss';

import { createApp } from 'vue';
import AppPage from './AppPage.vue';

const appPage = createApp(AppPage);
appPage.mount('#appPage');