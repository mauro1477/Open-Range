<template lang="">
    <div v-if="!loading" class="max-w-7xl max-xl:pr-4 max-xl:pl-4 ml-auto mr-auto pt-4 pb-4">
		<article class="" id="">
			<section class="">
				<h1 class="">{{post.title.rendered}}</h1>
				<div v-html="content"></div>
			</section>
		</article>
	</div>
</template>
<script>
import axios from 'axios';

export default {
    name: "Page Template",
    data(){
        return{
            local_data_post_id: theme_vars['current_post_id'],
            post: null,
            loading: false,
            content: "",
        }
    },
    async created() {
        this.loading = true;
        const response = await axios.get(`/wp-json/wp/v2/pages/${this.local_data_post_id}`);
        const post = response.data;
        this.content = post.content.rendered;
        this.post = post;
        this.loading = false;
    },
}
</script>
<style lang="">
    
</style>