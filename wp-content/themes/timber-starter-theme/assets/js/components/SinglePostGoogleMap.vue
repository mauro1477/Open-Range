<template>
     <GoogleMap 
        :api-key="YOUR_GOOGLE_MAPS_API_KEY" 
        style="width: 100%; height: 500px" 
        :center="center" 
        :zoom="15"
      >
        <Marker :options="{ position: center }" />
      </GoogleMap>
</template>

<script>
    import { GoogleMap, Marker } from "vue3-google-map";

    export default {
        name: "GoogleMapComponent",
        components: {
        GoogleMap,
        Marker
      },
      data() {
        return {
            YOUR_GOOGLE_MAPS_API_KEY: process.env.GOOGLE_MAPS_API, // Replace with your actual API key
            center: { 
                lat: null, 
                lng: null
            },
        };
      },
      mounted() {
        let myArray = document.getElementById('google-map-iframe').dataset.guidesLocation;
        const javascriptObject = JSON.parse(myArray);
        this.center.lat = javascriptObject['lat'];
        this.center.lng = javascriptObject['lng'];
      }
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