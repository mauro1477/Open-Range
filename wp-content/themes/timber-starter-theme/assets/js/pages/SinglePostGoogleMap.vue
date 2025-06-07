<template>
  <div v-if="!loading" class="max-w-7xl max-xl:pr-4 max-xl:pl-4 ml-auto mr-auto pt-4 pb-4">
      <article class="w-1/1">
        <section class="article-content">
            <h1 class="article-h1" v-text="get_title(post.title.rendered)"></h1>
            <div class="article-body">
                <a class="block mb-3" href="{{ googleDirectionLink  }} " target="_blank" rel="noopener noreferrer">
                  Address:  {{ post.acf.guides_location.address}}
                </a>
                <p v-if="post.acf.registration">Registration:  {{ post.acf.registration }}</p>
                <p v-if="post.acf.phone">Phone: {{ post.acf.phone }}</p>
                <p v-if="post.acf.hunt_units">Hunt Units: {{ post.acf.hunt_units }}</p>
                <a class="block mb-3" v-if="post.acf.website" href="{{ post.acf.website }}" target="_blank" rel="noopener noreferrer">{{ post.acf.website }}</a>
                <div v-if="post.acf.openedrange_verified">
                  <p>OpenedRange Verified: Yes</p>
                </div>
                <div v-else>
                  <p>OpenedRange Verified: No</p>
                </div>
            </div>
          </section>
      </article>

      <GoogleMap 
    :api-key="YOUR_GOOGLE_MAPS_API_KEY" 
    style="width: 100%; height: 500px" 
    :center="center" 
    :zoom="15"
  >
    <Marker :options="{ position: center }">
      <InfoWindow>
        <div id="content">
          <div id="siteNotice"></div>
          <h3 id="firstHeading" class="firstHeading" v-text="get_title(post.title.rendered)"></h3>
          <a :href="getGoogleMapsDirectionsLinke()" target="_blank" rel="noopener noreferrer">Directions</a>
        </div>
      </InfoWindow>
    </Marker>
  
  </GoogleMap>
  </div>
</template>

<script>
import { GoogleMap, Marker, InfoWindow } from "vue3-google-map";
import axios from 'axios';

export default {
  name: "GoogleMapComponent",
  components: {
    GoogleMap,
    Marker,
    InfoWindow
  },
  data() {
    return {
        local_data_post_id: theme_vars['current_post_id'],
        post: null,
        YOUR_GOOGLE_MAPS_API_KEY: process.env.GOOGLE_MAPS_API, // Replace with your actual API key
        title: null,
        address: "1150 E Arkansas Ave, Denver, CO 80210, USA",
        center: null,
        loading: false,
        mapZoom: 10,
        infoWindowPosition: { 
                  lat: null, 
                  lng: null
              },
        infoWindowOpened: false,
        selectedMarker: null,
    };
  },
  async created() {
    this.loading = true;
    const response = await axios.get(`/wp-json/wp/v2/guides/${this.local_data_post_id}`);
    const post = response.data;
    this.center = {
      lat: post.acf.guides_location.lat,
      lng: post.acf.guides_location.lng,
    };
    this.post = post;
    this.loading = false;
  },
  mounted() {
    
  },
  methods: {
    openInfoWindow() {
      this.infoWindowOpened = true;
    },
    closeInfoWindow() {
      this.infoWindowOpened = false;
    },
    get_title(current_title){
      console.log(current_title);
      let title = current_title.replace("&#8211;", "-");
      let title2 = title.replace("&amp;", "&");

      return title2;
    },
    getGoogleMapsDirectionsLinke(){
      return `https://www.google.com/maps/dir/?api=1&destination=${this.address}`;
    }
  },
};
</script>

<style lang="scss" scoped>
    .footer{
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        background-color: #000;
        color: white;
        text-align: center;
    }
</style>