import '../scss/main.scss';
const importAll = () =>  require('./include/importall.js');
const images = () => importAll(require.context('../images', false, /\.(png|svg|jpg|jpeg|gif)$/));
import { createApp } from 'vue';
import SinglePostGoogleMap from './components/SinglePostGoogleMap.vue';
import header from './components/NavigationMenu.vue';
import footer from './components/Footer.vue';

const SinglePostGoogleMapApp = createApp(SinglePostGoogleMap);
SinglePostGoogleMapApp.mount('#google-map-iframe');


const headerApp = createApp(header);
headerApp.mount('#nav-main');


const footerApp = createApp(footer);
footerApp.mount('#footer');



// headerApp.mount('#app');
