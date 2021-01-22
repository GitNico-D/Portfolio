<template>
    <b-container fluid>
        <b-row>
            <HomePageLink action="Retour" url="/" direction="animated-arrowRtl" class="link link-right" textColor="#00a1ba"/>
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
        &-right {
            right: 0;
            bottom: 3%;
            transform: scale(0.8);
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