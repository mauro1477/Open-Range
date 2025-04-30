<template>
<div if="true">
    <header>
        <nav>
            <a href="/" target="" class="branding">
                <i class="fa-solid fa-tree" style="color: #57ae37;"></i>
                <div class="website-title-logo">Opened Range</div>
            </a>
            <ul v-show="!mobile" class="navigation">
                <li v-for="(item, index) in local_data_primary_menu">
                    <a class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" :href=item.url target="" rel="noopener noreferrer">{{ item.title }}</a>
                </li>
            </ul>
            <div class="icon">
                <i id="toggle-icon" @click="toggleMobileNav"  v-show="mobile" :class="{'icon-active' : mobileNav }"  class="fa-solid fa-bars"></i>
            </div>
            <Transition id="mobile-nav" name="mobile-nav">
                <ul v-show="mobileNav" class="dropdown-nav">
                    <li class="link-rapper" v-for="(item, index) in local_data_primary_menu">
                        <a class="link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" :href=item.url target="" rel="noopener noreferrer">{{ item.title }}</a>
                    </li>
                </ul>
            </Transition>
        </nav>
    </header>
</div>
</template>

<script>

export default {
	name: 'Main Nav',
    data() {
		
        return {
            local_data_primary_menu: theme_vars['menu'],
            mobile: true,
            mobileNav: null,
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
        toggleMobileNav(){
            this.mobileNav = !this.mobileNav;
        },
        checkScreen(){
            this.windowWidth = window.innerWidth;
            if(this.windowWidth <= 750){
                this.mobile = true;
                return;
            }

            this.mobile = false;
            this.mobileNav = false;
            return;
        },
        handleClickOutsideDropdownMenu(event){
            if (event.target.id !== "mobile-nav" && event.target.id !== "toggle-icon" && event.target.className !== "link" && event.target.className !== "link-wrapper"  ) {
                this.mobileNav = false;
            } 
        }
    },
}
</script>

<style lang="scss" scoped>
header{
    background-color: #000;
    nav{
        display: flex;
        position: relative;
        background: rgba(0,0,0,0.8);
        z-index: 99;
        padding: 12px 0;
        transition: 0.5s ease all;
        width: 90%;
        margin: 0 auto;
        @media screen and (min-width: 1140px) {
            max-width: 1140px;
        }
    }

    .navigation{
        display: flex;
        align-items: center;
        flex: 1;
        justify-content: flex-end;
    }


    ul,
    .link{
        font-weight: 500;
        color: white;
        list-style: none;
        text-decoration: none;
    }

    li{
        text-transform: none;
        padding: 16px;
        margin-left: 16px;
    }

    .link{
        font-size: 14px;
        transition: 0.5s ease all;
        padding-bottom: 4px;
        border-bottom: 4px;
        border-bottom: 1px solid transparent;

        &:hover{
            color: #00afea;
            border-color: #00afea;
        }
    }

    .branding{
        text-decoration: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        i,
        img{
            font-size: 20px;
            margin-right: 15px;
            transition: 0.5s ease all;
        }
    }
    .fa-bars{
        color: white;
    }

    .icon{
        display: flex;
        align-items: center;
        position: absolute;
        top: 0;
        right: 14px;
        height: 100%;

        i{
            cursor: pointer;
            font-size: 24px;
            transition: 0.8s ease all;
        }
    }

    .dropdown-nav{
        margin-top: 0;
        display: flex;
        flex-direction: column;
        position: fixed;
        width: 100%;
        max-width: 250px;
        height: 100%;
        background-color: white;
        top: 0;
        left: 0;

        li{
            margin-left: 0;
            .link{
                color: #000;

            }
        }
    }

    .icon-active{
        transform: rotate(180deg);
    }

    .website-title-logo{
        color: white;
    }

    .mobile-nav-enter-active,
    .mobile-nav-leave-active{
        transition: 1s ease all;
    }
    .mobile-nav-leave-to,
    .mobile-nav-enter-from{
        transform: translate(-250px);
    }

    .mobile-nav-enter-to{
        transform: translate(0);
    }

}
</style>