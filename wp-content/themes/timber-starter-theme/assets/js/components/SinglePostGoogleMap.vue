<template>
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
          <h3 id="firstHeading" class="firstHeading">{{title}}</h3>
					<a :href="getGoogleMapsDirectionsLinke()" target="_blank" rel="noopener noreferrer">Directions</a>
        </div>
      </InfoWindow>
    </Marker>
	
	</GoogleMap>
</template>

<script>
    import { GoogleMap, Marker, InfoWindow } from "vue3-google-map";

    export default {
        name: "GoogleMapComponent",
        components: {
		GoogleMap,
        Marker,
		InfoWindow
      },
      data() {
        return {
            YOUR_GOOGLE_MAPS_API_KEY: process.env.GOOGLE_MAPS_API, // Replace with your actual API key
            center: { 
                lat: null, 
                lng: null
            },
			title: null,
			address: null,
			mapZoom: 10,
			infoWindowPosition: { 
                lat: null, 
                lng: null
            },
			infoWindowOpened: false,
			selectedMarker: null,
        };
      },
      mounted() {
        let myArray = document.getElementById('google-map-iframe').dataset.guidesLocation;
        const javascriptObject = JSON.parse(myArray);
        this.center.lat = javascriptObject['lat'];
        this.center.lng = javascriptObject['lng'];
        this.address = javascriptObject['address'];
        this.title = javascriptObject['title'].replace("&#8211;", "-")
        console.log(javascriptObject);
        this.infoWindowPosition.lat = javascriptObject['lat'];
        this.infoWindowPosition.lng = javascriptObject['lng'];
      },
	  methods: {
		openInfoWindow() {
			this.infoWindowOpened = true;
		},
		closeInfoWindow() {
			this.infoWindowOpened = false;
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