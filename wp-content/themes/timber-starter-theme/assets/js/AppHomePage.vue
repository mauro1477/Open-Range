<template>
    <navigation></navigation>
    <homepageagloliasearch></homepageagloliasearch>
    <mainfooter></mainfooter>
</template>
<script>
import NavigationMenu from './components/NavigationMenu.vue';
import HomePageAgloliaSearch from './pages/HomePageAgloliaSearch.vue';
import MainFooter from './components/Footer.vue';

export default {
  components: {
    'navigation': NavigationMenu,
    'homepageagloliasearch' : HomePageAgloliaSearch,
    'mainfooter' : MainFooter,
  },
};
</script>