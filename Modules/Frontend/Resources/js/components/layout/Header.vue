<template>
    <header :class="{'sticky-header' : isScroll}" class="header">
        <div class="header-top after-fade">
            <ul class="full-width-menu overflow-horizontal">
                <li class="menu-item" v-for="(name,slug) in countries">
                    <a :href="route('frontend.rss.countries.show',slug)">{{name}}</a>
                </li>
            </ul>
        </div>
        <div class="header-middle container">
            <a class="logo" href="/"><img alt="logo" src="/dist/img/logo.svg"></a>
            <div>
                <language-switcher></language-switcher>
            </div>
            <div :class="{'open-search' : openSearch}" class="search-box">
                <form :action="route('frontend.search')" class="search-box-form">
                    <input class="form-control" name="query" placeholder="Search" required type="text">
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
                    <li><a href="/">Home</a></li>
                    <li><a href="/quienes-somos">Quiénes Somos</a></li>
                    <li><a href="/contacto">Contacto</a></li>
                    <li><a href="/red-de-medios">Enlaces</a></li>
                    <li><a :href="route('frontend.search')">Search</a></li>
                    <li><a href="/all-rss">All Rss</a></li>
                    <li><a href="/all-youtube">All Youtube</a></li>
                    <li><a href="http://covid19alert.net" target="_blank">Covid-19 </a></li>
                </ul>
                <social-icons></social-icons>
            </div>
        </div>
    </header>
</template>

<script>
    import SocialIcons from "./SocialIcons"

    export default {
        data() {
            return {
                countries: {...this.shared('countries')},
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
        components: {
            SocialIcons,
            LanguageSwitcher: () => import('../includes/LanguageSwitcher')
        }
    }
</script>
