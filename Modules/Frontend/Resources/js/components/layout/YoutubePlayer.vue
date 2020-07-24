<template>
    <div class="video-chanel">
        <div class="chanel-name">{{ player.title }}</div>
        <div class="chanel-main-video">
        </div>
        <div class="chanel-play-box">
            <div class="play-btn"><img alt="" src="/dist/img/icons/play.svg"></div>
            <div class="video-name">{{ player.lists[0].name }}</div>
            <div class="time">{{ player.lists[0].time }}</div>
        </div>
        <div class="chanel-video-list">
            <div class="video-item" v-for="item in player.lists">
                <img :alt="item.alt" :src="item.thumb">
                <div>
                    <div class="video-name">{{ item.name }}</div>
                    <div class="time">{{ item.time }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['player']
    }
</script>
