<template>
    <navigation></navigation>
    <singlepage></singlepage>
    <mainfooter></mainfooter>
</template>
<script>
import NavigationMenu from './components/NavigationMenu.vue';
import SinglePage from './pages/SinglePage.vue'
import MainFooter from './components/Footer.vue';

export default {
  components: {
    'navigation': NavigationMenu,
    'singlepage' : SinglePage,
    'mainfooter' : MainFooter,
  },
};
</script>