<template>
<div>
  <div id="gist"></div>
	<div id="map"></div>
	<ais-instant-search :search-client="searchClient" :index-name="env_algolia_prefix">
		<div class="ais-address-form">
			<input class="input-address-form" :style="{ backgroundImage: 'url(/wp-content/themes/timber-starter-theme/assets/images/location-dot-solid.png)'}" type="text" :value="address"  @input="updateAddress"  placeholder="Enter Location">
		</div>	
		<ais-search-box placeholder="Search for Guides"/>
		<ais-hits>
			<template v-slot:item="{ item }">
				<a :href="item.permalink" target="" rel="noopener noreferrer" class="link-dark">
					<h6>{{ item.post_title }}</h6>
					<address>Address: {{item.address}}</address>
				</a>
			</template>
		</ais-hits>
		<ais-pagination 
			@page-change="scrollToTop"
			:show-first="false"
			:show-last="false"
			:class-names="{
			'ais-Pagination-list': 'pagination',
			'ais-Pagination-item': 'page-item',
			'ais-Pagination-link': 'page-link',
			'ais-Pagination-item--disable': 'disabled',
			'ais-Pagination-item--selected': 'active',
		}"
		/>
	</ais-instant-search>
</div>
</template>
<script>
    import { liteClient as algoliasearch } from 'algoliasearch/lite';
    import {AisConfigure, AisMenuSelect, AisInstantSearch, AisSearchBox, AisHits, AisPagination, AisRefinementList } from 'vue-instantsearch/vue3/es';
	import postscribe from 'postscribe'
    // Define initMap outside of the component's scope
    
		
    export default {
      name: 'AddressSearch',
      components: {
        AisInstantSearch,
        AisSearchBox,
        AisHits,
		AisPagination,
		AisRefinementList,
		AisMenuSelect
      },
      data() {
        return {
		autocomplete: null,
		address: '',		
          searchClient: algoliasearch(
            process.env.ALGOLIA_ID,
            process.env.ALGOLIA_API_KEY
          ),
           env_algolia_prefix: "wp_" + process.env.ALGOLIA_PREFIX + "posts_guides",
		  location_icon: "background-image: url(/wp-content/themes/timber-starter-theme/assets/images/location-dot-solid.png)",
		  selected_address_result: {
			lat: -34.397,
			lng: 150.644
		  },
        };
      },
	  mounted() {
		// postscribe('#gist', `<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDgYeoslPIi0_0ttWCFbtQGdNTmT24ktfA&loading=async&libraries=places"><\/script>`)
        this.initMap();
	},
      methods: {
		scrollToTop() {
			window.scrollTo(0, 0);
		},
		async initMap() {
			const { Map } = await google.maps.importLibrary('maps');
			const { Autocomplete } = await google.maps.importLibrary('places');

			const map = new google.maps.Map(document.getElementById("map"), {
				center: this.selected_address_result,
				zoom: 12,
			});		
			
			this.autocomplete = new Autocomplete(
				document.querySelector('input'),
				{
				componentRestrictions: { country: 'us' },
				fields: ['address_components', 'geometry', 'name'],
				}
			);
			this.autocomplete.addListener('place_changed', this.onPlaceChanged);
		},
		onPlaceChanged() {
			const place = this.autocomplete.getPlace();
			if (!place.geometry) {
				// User entered the name of a Place that was not suggested and
				// pressed the Enter key, or the Place Details request failed.
				window.alert("No details available for input: '" + this.address + "'");
				return;
			}
			this.selected_address_result = {
				lat: place.geometry.location.lat(),
				lng: place.geometry.location.lng()
			};

			const map = new google.maps.Map(document.getElementById("map"), {
				center: this.selected_address_result,
				zoom: 12,
			});		
			this.address = place.formatted_address;
		},
      },
	  beforeUnmount() {
		if (this.autocomplete) {
			google.maps.event.clearInstanceListeners(this.autocomplete);
		}
	  },
    };
</script>

<style lang="scss" scoped>

</style>
