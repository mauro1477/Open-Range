<template>
<div>
    <header :class="{'scrolled-nav': scrollPosition }">
        <nav>
            <div class="branding">
                <img :src="logo"  alt="">
                <div class="website-title-logo">Open Range</div>
            </div>
        </nav>
    </header>
</div>
</template>

<script>

export default {
    data() {
        return {
            logo: "wp-content/themes/timber-starter-theme/assets/images/logo.png"
        }
    }
}
</script>