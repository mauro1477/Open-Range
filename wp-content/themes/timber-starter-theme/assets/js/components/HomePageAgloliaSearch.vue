<template>
    <ais-instant-search :search-client="searchClient" :index-name="env_algolia_prefix">
      <ais-search-box placeholder="Search for Guides"/>
      <ais-hits>
        <template v-slot:item="{ item }">
          <a :href="item.permalink" target="" rel="noopener noreferrer" class="link-dark">
            <h6>{{ item.post_title }}</h6>
						<address>Address: {{item.address}}</address>
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
          env_algolia_prefix: "wp_" + process.env.ALGOLIA_PREFIX + "posts_guides"
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
