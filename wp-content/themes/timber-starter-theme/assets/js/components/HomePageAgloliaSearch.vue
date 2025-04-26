<template>
<div>
  <div id="gist"></div>
	<ais-instant-search :search-client="searchClient" :index-name="env_algolia_prefix">
		<GoogleMap 
			:api-key="YOUR_GOOGLE_MAPS_API_KEY" 
			style="width: 100%; height: 500px; margin-bottom: 20px;" 
			:center="selected_address_result" 
			:zoom="10"
    >
		<ais-hits :class-names="{ 'ais-Hits': 'hits' }" >
        <template v-slot="{ items }">
					<Marker v-for="post in items" :key="post.id" :options="{ position:  post._geoloc }">
						<InfoWindow>
						<div id="content">
							<div id="siteNotice"></div>
							<h3 id="firstHeading" class="firstHeading">{{post.post_title}}</h3>
							<a :href="getGoogleMapsDirectionsLinke(post.address)" target="_blank" rel="noopener noreferrer">Directions</a>
						</div>
					</InfoWindow>
    	</Marker>
        </template>
      </ais-hits>

	</GoogleMap>
	
		<ais-configure
				:hits-per-page.camel="20"
				:analytics="false"
				:enable-personalization.camel="true"
				:around-lat-lng.camel="`${selected_address_result.lat},${selected_address_result.lng}`"
				:around-radius.camel="selectedOptionRadiusValue"
			/>
		<div class="ais-address-form">
			<input id="input-address-form" class="input-address-form" :style="{ backgroundImage: 'url(/wp-content/themes/timber-starter-theme/assets/images/location-dot-solid.png)'}" type="text" :v-model="address"  placeholder="Enter Location">
		</div>	
		<ais-search-box placeholder="Search for Guides"/>
		<ais-menu-select 
				attribute="taxonomies.guides_categories"
				:class-names="{
					'ais-MenuSelect-select': 'form-select',
					'ais-MenuSelect-option': 'dropdown-item'
				}">
				<template v-slot:defaultOption>
					Recreation Services
				</template>
				</ais-menu-select>
			<ais-menu-select 
				attribute="state" 
				:class-names="{
					'ais-MenuSelect-select': 'form-select',
					'ais-MenuSelect-option': 'dropdown-item'
				}"
				>
				<template v-slot:defaultOption>
					State
				</template>
				</ais-menu-select>
			<div class="ais-radius-dropdown">
		  <select class="form-select" v-model="selectedOptionRadiusValue">
				<option  class="dropdown-item" value="all">No Raduis</option>
				<option class="dropdown-item" value="80467">50 Miles</option>
				<option class="dropdown-item" value="160934">100 Miles</option>
				<option class="dropdown-item" value="402336">250 Miles</option>
				<option class="dropdown-item" value="804672">500 Miles</option>
  		</select>
		</div>
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
	import { GoogleMap, Marker, InfoWindow } from "vue3-google-map";
	import postscribe from 'postscribe'
			
    export default {
      name: 'AddressSearch',
      components: {
        AisInstantSearch,
        AisSearchBox,
        AisHits,
		AisPagination,
		AisRefinementList,
		AisMenuSelect,
		AisConfigure,
		GoogleMap,
		Marker,
		InfoWindow
      },
      data() {
        return {
		YOUR_GOOGLE_MAPS_API_KEY: process.env.GOOGLE_MAPS_API, // Replace with your actual API key
		title: null,
		address: null,
		mapZoom: 12,
		infoWindowPosition: { 
			lat: null, 
			lng: null
		},
		infoWindowOpened: false,
		selectedMarker: null,
		autocomplete: null,
		address: '',		
          searchClient: algoliasearch(
            process.env.ALGOLIA_ID,
            process.env.ALGOLIA_API_KEY
          ),
           env_algolia_prefix: "wp_" + process.env.ALGOLIA_PREFIX + "posts_guides",
		  location_icon: "background-image: url(/wp-content/themes/timber-starter-theme/assets/images/location-dot-solid.png)",
		  selected_address_result: {
			lat: 39.7392,
			lng: -104.9903
		  },
		  // 1 mile = 16000
		  selectedOptionRadiusValue : 'all'
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
			// const { Map } = await google.maps.importLibrary('maps');
			const { Autocomplete } = await google.maps.importLibrary('places');

			// const map = new google.maps.Map(document.getElementById("map"), {
			// 	center: this.selected_address_result,
			// 	zoom: 12,
			// });		
			
			this.autocomplete = new Autocomplete(
				document.getElementById('input-address-form'),
				{
				componentRestrictions: { country: 'us' },
				fields: ['address_components', 'geometry', 'name'],
				}
			);
			this.autocomplete.addListener('place_changed', this.onPlaceChanged);
		},
		getCurrentHits() {
		this.$children[0].$children[0].getResults().then(content => {
			this.currentHits = content.hits;
			console.log('Current Hits:', this.currentHits);
		})
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

			// const map = new google.maps.Map(document.getElementById("map"), {
			// 	center: this.selected_address_result,
			// 	zoom: 12,
			// });		
			this.address = place.formatted_address;
		},
		openInfoWindow() {
			this.infoWindowOpened = true;
		},
		closeInfoWindow() {
			this.infoWindowOpened = false;
		},
		getGoogleMapsDirectionsLinke(address){
			return `https://www.google.com/maps/dir/?api=1&destination=${address}`;
		}
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
