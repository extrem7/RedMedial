<template>
    <header :class="{'sticky-header' : isScroll}" class="header">
        <div class="header-top after-fade">
            <ul class="full-width-menu overflow-horizontal">
                <li class="menu-item" v-for="n in 40">
                    <a href="https://redmedial.com/venezuela/">Venezuela</a>
                </li>
            </ul>
        </div>
        <div class="header-middle container">
            <a class="logo" href=""><img alt="" src="/dist/img/logo.svg"></a>
            <div>
                <b-dropdown class="language" id="dropdown-1" right variant="outline">
                    <template v-slot:button-content>
                        <img alt="ar" src="https://redmedial.com/wp-content/plugins/gtranslate/flags/24/ar.png">
                        <span>Spanish</span>
                    </template>
                    <b-dropdown-item>
                        <img alt="ar" src="https://redmedial.com/wp-content/plugins/gtranslate/flags/24/ar.png">
                        <span>Arabic</span>
                    </b-dropdown-item>
                    <b-dropdown-item>
                        <img alt="ar" src="https://redmedial.com/wp-content/plugins/gtranslate/flags/24/ar.png">
                        <span>Arabic</span>
                    </b-dropdown-item>
                    <b-dropdown-item>
                        <img alt="ar" src="https://redmedial.com/wp-content/plugins/gtranslate/flags/24/ar.png">
                        <span>Arabic</span>
                    </b-dropdown-item>
                    <b-dropdown-item>
                        <img alt="ar" src="https://redmedial.com/wp-content/plugins/gtranslate/flags/24/ar.png">
                        <span>Arabic</span>
                    </b-dropdown-item>
                    <b-dropdown-item>
                        <img alt="ar" src="https://redmedial.com/wp-content/plugins/gtranslate/flags/24/ar.png">
                        <span>Arabic</span>
                    </b-dropdown-item>
                </b-dropdown>
            </div>
            <div :class="{'open-search' : openSearch}" class="search-box">
                <form action="" class="search-box-form">
                    <input class="form-control" name="s" placeholder="Search" type="text">
                    <button class="btn-submit-search icon" type="submit">
                        <svg-vue icon="search"></svg-vue>
                    </button>
                    <span @click="openSearch = !openSearch" class="icon close-icon"><svg-vue
                        icon="times"></svg-vue></span>
                </form>
            </div>
            <button @click="openSearch = !openSearch" class="btn-search icon">
                <svg-vue icon="search"></svg-vue>
            </button>
            <button :class="{'open' : openMenu}" @click="openMenu = !openMenu" class="mobile-btn">
                <span></span><span></span><span></span></button>
        </div>
        <div :class="{'open-menu' : openMenu}" class="header-bottom menu-container">
            <div class="container d-flex align-items-center justify-content-between">
                <ul class="menu overflow-horizontal">
                    <li><a href="">Home</a></li>
                    <li><a href="">About us</a></li>
                    <li><a href="">Contact</a></li>
                    <li><a href="">Links</a></li>
                    <li><a href="">Search</a></li>
                    <li><a href="">All Rss</a></li>
                    <li><a href="">All Youtube</a></li>
                    <li><a href="">Covid-19 </a></li>
                </ul>
                <div class="media-block">
                    <a href="" target="_blank">
                        <svg-vue icon="facebook"></svg-vue>
                    </a>
                    <a href="" target="_blank">
                        <svg-vue icon="viber"></svg-vue>
                    </a>
                    <a href="" target="_blank">
                        <svg-vue icon="youtube"></svg-vue>
                    </a>
                    <a href="" target="_blank">
                        <svg-vue icon="google-plus-g"></svg-vue>
                    </a>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
    export default {
        data() {
            return {
                openSearch: false,
                openMenu: false,
                isScroll: false,
            }
        },
        methods: {
            isScrollHeader() {
                this.isScroll = window.pageYOffset > (window.innerWidth > 767 ? 98 : 24);
            },
        },
        beforeMount() {
            window.addEventListener("resize", this.isScrollHeader, false);
            window.addEventListener("scroll", this.isScrollHeader, false);
        },
    }
</script>
