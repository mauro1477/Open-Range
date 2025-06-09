<template>
<div class="flex justify-center max-w-7xl  max-xl:pr-4 max-xl:pl-4 pt-4 pb-4 m-auto">
  <div id="gist"></div>
	<ais-instant-search :search-client="searchClient" :index-name="env_algolia_prefix" :class-names="{ 'ais-InstantSearch' : 'lg:flex max-w-7xl  flex-row-reverse justify-evenly w-1/1'}">
		<div class="lg:w-1/2">
			<GoogleMap 
				:api-key="YOUR_GOOGLE_MAPS_API_KEY" 
				:center="selected_address_result" 
				:zoom="10"
				:mapTypeControl="false"
				:disableDefaultUI="true"
				:streetViewControl="show_view_street"
				class="max-h-[400px] max-w-400px mb-4"
				style="height: 400px; width: 100%;"
				>
				<ais-hits :class-names="{ 'ais-Hits': 'hits' }" >
					<template v-slot="{ items }">
						<Marker v-for="post in items" :key="post.id" :options="{ position:  post._geoloc , title: post.post_title }">
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
		</div>
		<div class="lg:w-1/2 lg:mr-4">
			<ais-configure
				:hits-per-page.camel="20"
				:analytics="false"
				:enable-personalization.camel="true"
				:around-lat-lng.camel="`${selected_address_result.lat},${selected_address_result.lng}`"
				:around-radius.camel="selectedOptionRadiusValue"
			/>
			<div class="ais-address-form max-w-md mb-2">
				<div class="relative block pl-2 py-2 w-full pl-7 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50">
					<input id="input-address-form" class="outline-none w-full focus:ring-blue-500 focus:border-blue-500 " :aria-label="'Search address'" type="text" :v-model="address"  placeholder="Enter Location">
					<i class="fa-solid fa-location-dot absolute top-28/100 left-2"></i>
				</div>
			</div>	

			<ais-search-box>
				<template v-slot="{ currentRefinement, isSearchStalled, refine }">
					<div class="max-w-md mb-2">
						<div class="relative relative block pl-7 py-2 w-full ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50">
							<input
							type="search"
							:value="currentRefinement"
							@input="refine($event.currentTarget.value)"
							placeholder="Search for Guides"
							:aria-label="'Search for Guides'" 
							class="outline-none w-full focus:ring-blue-500 focus:border-blue-500"
							>
							<i class="fas fa-search absolute top-28/100 left-2"></i>
					</div>
					</div>
				</template>
			</ais-search-box>

			<ais-menu-select 
				attribute="taxonomies.guides_categories"
				:aria-label="'Filter by guides categroy'"
				class="max-w-md mb-2" 
				>
				<template v-slot="{ items, canRefine, refine, sendEvent }">
					<select
						class="ais-MenuSelect-select form-select text-sm"
						aria-label="Recreation Services"
						:disabled="!canRefine"
						@change="refine($event.currentTarget.value)"
						>
						<option value="">Recreation Services</option>
						<option
							v-for="item in items"
							:key="item.value"
							:value="item.value"
							:selected="item.isRefined"
							:aria-label="`Option ${item.value}`"
							class="ais-MenuSelect-option dropdown-item"
						>
							{{ item.label }}
						</option>
					</select>
				</template>
			</ais-menu-select>

			<ais-menu-select 
				attribute="state"
				:aria-label="'Filter by state'" 
				class="max-w-md mb-2" 
				>
				<template v-slot="{ items, canRefine, refine, sendEvent }">
					<select
						class="ais-MenuSelect-select form-select text-sm"
						aria-label="Recreation Services"
						:disabled="!canRefine"
						@change="refine($event.currentTarget.value)"
						>
						<option value="">State</option>
						<option
							v-for="item in items"
							:key="item.value"
							:value="item.value"
							:selected="item.isRefined"
							:aria-label="`Option ${item.value}`"
							class="ais-MenuSelect-option dropdown-item"
						>
							{{ item.label }}
						</option>
					</select>
				</template>
			</ais-menu-select>

			<div class="max-w-md mb-2">
				<select aria-label="Filter by radius in miles" class="form-select text-sm" v-model="selectedOptionRadiusValue">
						<option aria-label="Option no radius"   class="dropdown-item" value="all">No Raduis</option>
						<option aria-label="Option 50 miles"  class="dropdown-item" value="80467">50 Miles</option>
						<option aria-label="Option 100 miles"  class="dropdown-item" value="160934">100 Miles</option>
						<option aria-label="Option 250 miles"  class="dropdown-item" value="402336">250 Miles</option>
						<option aria-label="Option 500 miles"  class="dropdown-item" value="804672">500 Miles</option>
				</select>
			</div>
		<div  id="ais-hits"ref="scrollTarget"></div>
		<ais-hits
		:class-names="{
			'ais-Hits-list': 'pt-4 !pl-0',
			'ais-Hits-item': 'pb-2',
		}"
		>
			<template v-slot:item="{ item }">
				<a :href="item.permalink" target="" rel="noopener noreferrer" class="link-dark">
					<h6>{{ item.post_title }}</h6>
					<address>Address: {{item.address}}</address>
				</a>
			</template>
		</ais-hits>
		<ais-pagination 
			@click="scrollToDiv"
			:show-first="false"
		    :show-last="false"
			:total-pages="5"
			:class-names="{
			'ais-Pagination-list': 'pagination',
			'ais-Pagination-item': 'page-item',
			'ais-Pagination-link': 'page-link',
			'ais-Pagination-item--disable': 'disabled',
			'ais-Pagination-item--selected': 'active',
		}"
		/>
		</div>
	</ais-instant-search>
</div>
</template>
<script>
    import { liteClient as algoliasearch } from 'algoliasearch/lite';
    import {AisConfigure, AisMenuSelect, AisInstantSearch, AisSearchBox, AisHits, AisPagination, AisRefinementList } from 'vue-instantsearch/vue3/es';
	import { GoogleMap, Marker, InfoWindow } from "vue3-google-map";
			
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
		  show_view_street: false,
		  selectedOptionRadiusValue : 'all'
        };
      },
	  mounted() {
        this.initMap();
	},
      methods: {
		scrollToTop() {
			window.scrollTo(0, 0);
		},
		async initMap() {
			const { Autocomplete } = await google.maps.importLibrary('places');
			this.autocomplete = new Autocomplete(
				document.getElementById('input-address-form'),
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
			
			this.scrollToTop();	
			this.address = place.formatted_address;
		},
		scrollToDiv() {
          this.$nextTick(() => {
            this.$refs.scrollTarget.scrollIntoView({ behavior: 'smooth' });
          });
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
