<template>
    <footer class="footer">
        <div class="container d-flex justify-content-center flex-column align-items-center">
            <ul>
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
            <div class="mt-3 mb-3">Red Medial ©{{ new Date().getFullYear()}}</div>
            <div class="d-none">
                Una más de <a href="https://www.elciudadano.com" rel="nofollow" target="_blank">El Ciudadano</a> con
                desarrollo de <a href="https://raxkor.com" rel="nofollow" target="_blank">Raxkor</a>
            </div>
            <div class="row app-download">
                <div class="col-md-6 text-center mt-3 mt-md-0">
                    <a :href="shared('mobileApp').android" rel="nofollow" target="_blank">
                        <img alt="mobile-app-android" src="/dist/img/playmarket.png">
                    </a>
                </div>
                <div class="col-md-6 text-center mt-3 mt-md-0">
                    <a :href="shared('mobileApp').apple" rel="nofollow" target="_blank">
                        <img alt="mobile-app-apple" src="/dist/img/appstore.png">
                    </a>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
    import SocialIcons from "./SocialIcons"

    export default {
        components: {
            SocialIcons,
        }
    }
</script>
