import '../scss/main.scss'
const importAll = () =>  require('./include/importall.js')
const images = () => importAll(require.context('../images', false, /\.(png|svg|jpg|jpeg|gif)$/));
import { createApp } from 'vue'
import  App from './App.vue';
const app  = createApp(App);
app.mount('#app');
