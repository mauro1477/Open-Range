<template>
    <navigation></navigation>
    <singlepostgooglemap></singlepostgooglemap>
    <mainfooter></mainfooter>
</template>
<script>
import NavigationMenu from './components/NavigationMenu.vue';
import SinglePostGoogleMap from './pages/SinglePostGoogleMap.vue'
import MainFooter from './components/Footer.vue';

export default {
  components: {
    'navigation': NavigationMenu,
    'singlepostgooglemap' : SinglePostGoogleMap,
    'mainfooter' : MainFooter,
  },
};
</script>