<template>
    <div class="footer">
        <p> Copyright © 2025 Opened Range. All Rights Reserved.</p>
		    <ul class="navigation">
						<li v-for="(item, index) in local_data_primary_menu_footer">
								<a class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" :href=item.url target="" rel="noopener noreferrer">{{ item.title }}</a>
						</li>
				</ul>
    </div>
</template>

<script>

    export default {
		name: 'Main Footer',
		data() {
			return {
				local_data_primary_menu_footer: theme_vars['menu_footer'],
				mobile: true,
				mobileFooter: null,
				windowWidth: null
			}
		},
		created() {
			window.addEventListener('resize', this.checkScreen);
			this.checkScreen();
		},
		mounted() {
			document.addEventListener('click', this.handleClickOutsideDropdownMenu);
		},
		beforeUnmount() {
			document.removeEventListener('click', this.handleClickOutsideDropdownMenu);
		},
		methods: {
			togglemobileFooter(){
				this.mobileFooter = !this.mobileFooter;
			},
			checkScreen(){
				this.windowWidth = window.innerWidth;
				if(this.windowWidth <= 750){
					this.mobile = true;
					return;
				}

				this.mobile = false;
				this.mobileFooter = false;
				return;
			},
			handleClickOutsideDropdownMenu(event){
				if (event.target.id !== "mobile-nav" && event.target.id !== "toggle-icon" && event.target.className !== "link" && event.target.className !== "link-wrapper"  ) {
					this.mobileFooter = false;
				} 
			}
		},
    }
</script>

<style lang="scss" scoped>
    .footer{
        background-color: #000;
        color: white;
        text-align: center;
				margin-bottom: 0px;
				padding: 20px 15px;
				font-size: 14px;

				p{
					margin-bottom: 0;
				}

				ul{
					list-style: none;
					display: flex;
					justify-content: center;
					flex-wrap: wrap;
					margin-top: 10px;
					padding: 0px;
					li{
						padding: 5px 5px;
					}
					a{
						padding: 0 5px;
					}
				}
    }
</style>