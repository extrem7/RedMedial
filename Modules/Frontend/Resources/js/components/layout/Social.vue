<template>
    <div class="subscribe-block">
        <div class="title">Suscríbete a nuestros canales para mantenerte informado.</div>
        <a :href="facebook.link" class="subscribe-item facebook" rel="nofollow" target="_blank">
            <div class="subscribe-info">
                <img alt="facebook" src="/dist/img/icons/facebook.svg">
                <span>{{facebook.count}}</span>
                <span>Fans</span>
            </div>
            <div class="text-uppercase subscribe-action">Me gusta</div>
        </a>
        <a :href="instagram.link" class="subscribe-item instagram" rel="nofollow" target="_blank">
            <div class="subscribe-info">
                <img alt="instagram" src="/dist/img/icons/instagram.svg">
                <span>{{instagram.count}}</span>
                <span>Seguidores</span>
            </div>
            <div class="text-uppercase subscribe-action">Seguir</div>
        </a>
        <a :href="twitter.link" class="subscribe-item twitter" rel="nofollow" target="_blank">
            <div class="subscribe-info">
                <img alt="twitter" src="/dist/img/icons/twitter.svg">
                <span>{{twitter.count}}</span>
                <span>Seguidores</span>
            </div>
            <div class="text-uppercase subscribe-action">Seguir</div>
        </a>
        <a :href="youtube.link" class="subscribe-item youtube" rel="nofollow" target="_blank">
            <div class="subscribe-info">
                <img alt="youtube" src="/dist/img/icons/play.svg">
                <span>{{youtube.count}}</span>
                <span>Suscriptores</span>
            </div>
            <div class="text-uppercase subscribe-action">Suscribirte</div>
        </a>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                ...this.shared('social')
            }
        }
    }
</script>
