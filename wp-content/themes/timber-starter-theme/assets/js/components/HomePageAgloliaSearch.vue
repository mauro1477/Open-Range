<template>
    <ais-instant-search :search-client="searchClient" index-name="wp_posts_guides">
      <ais-search-box />
      <ais-hits>
        <template v-slot:item="{ item }">
          <a :href="item.permalink" target="" rel="noopener noreferrer">
            <h3>{{ item.post_title }}</h3>
          </a>
        </template>
      </ais-hits>
    </ais-instant-search>
  </template>
<script>

    import { liteClient as algoliasearch } from 'algoliasearch/lite';
    // import 'instantsearch.css/themes/algolia-min.css';
    import { AisInstantSearch, AisSearchBox, AisHits } from 'vue-instantsearch/vue3/es';

    export default {
      name: 'AddressSearch',
      components: {
        AisInstantSearch,
        AisSearchBox,
        AisHits
      },
      data() {
        return {
          searchClient: algoliasearch(
            process.env.ALGOLIA_ID,
            process.env.ALGOLIA_API_KEY
          ),
        };
      },
      methods: {
        handleSearch(event) {
            // You can add custom logic here if needed, like debouncing
            // or handling empty queries
        }
      },
    };
</script>

<style lang="scss" scoped>

</style>
