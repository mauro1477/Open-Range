import '../scss/main.scss';

import { createApp } from 'vue';
import AppHomePage from './AppHomePage.vue';

const appHomePage = createApp(AppHomePage);
appHomePage.mount('#appHomePage');