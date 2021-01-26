<template>
    <b-container fluid>
        <b-row>
            <HomePageLink action="Retour" url="/" direction="animated-arrowRtl" class="link link-bottom" textColor="#36C486"/>
        </b-row>
    </b-container>
</template>

<script>
import HomePageLink from '@/components/HomePageLink.vue'

export default {
    components: {
        HomePageLink
    }
}
</script>

<style lang="scss" scoped>
.container-fluid {
    .link {
        position: absolute;
        &-bottom {
            transform-style: preserve-3d;
            transform: rotateZ(90deg) scale(0.8);
            left: 0;
            bottom: 10%;
        }
    }
    .row {
        justify-content: space-around;
        align-items: center;        
    }
    h1 {
        position: absolute;
        top: 4rem;
    }
    .nav {
        position: absolute;
        top: 0;
        left: 5rem;
    }
}
</style>