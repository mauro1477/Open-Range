import '../scss/main.scss';
import { locationDotSolid } from '../images/location-dot-solid.png';

import { createApp } from 'vue';
import header from './components/NavigationMenu.vue';
import footer from './components/Footer.vue';
import HomePageAgloliaSearch from './components/HomePageAgloliaSearch.vue'
import SinglePostGoogleMap from './components/SinglePostGoogleMap.vue';

if (document.getElementById('home-page-algolia-search')) {
    const HomePageAgloliaSearchApp = createApp(HomePageAgloliaSearch);
    HomePageAgloliaSearchApp.mount('#home-page-algolia-search');
} 

if (document.getElementById('google-map-iframe')) {
    const SinglePostGoogleMapApp = createApp(SinglePostGoogleMap);
    SinglePostGoogleMapApp.mount('#google-map-iframe');
} 

const headerApp = createApp(header);
headerApp.mount('#nav-main');


const footerApp = createApp(footer);
footerApp.mount('#footer');