<template>
    <navigation></navigation>
    page template
    <mainfooter></mainfooter>
</template>
<script>
import NavigationMenu from './components/NavigationMenu.vue';
import MainFooter from './components/Footer.vue';

export default {
  components: {
    'navigation': NavigationMenu,
    'mainfooter' : MainFooter,
  },
};
</script>