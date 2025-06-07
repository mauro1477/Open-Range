import '../scss/main.scss';

import { createApp } from 'vue';
import AppSinglePage from './AppSinglePage.vue';

const appSinglePage = createApp(AppSinglePage);
appSinglePage.mount('#appSinglePage');