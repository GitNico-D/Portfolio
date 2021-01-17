<template>
    <b-container fluid>
        <b-row>
            <MenuNavigation linkColor="white" actionColorLink="#36C486" spanColor="#36C486"/>
            <HomePageLink action="Retour" url="/" direction="animated-arrowRtl" class="link link-top" textColor="#36C486"/>
            <PageTitle title="Page Compétences" textColor="#36C486" />
            </b-row>
    </b-container>
</template>

<script>
import PageTitle from '@/components/PageTitle.vue'
import MenuNavigation from '@/components/MenuNavigation.vue'
import HomePageLink from '@/components/HomePageLink.vue'

export default {
    components: {
        PageTitle,
        MenuNavigation,
        HomePageLink
    }
}
</script>

<style lang="scss" scoped>
.container-fluid {
    .link {
        position: absolute;
        &-top {
            transform-style: preserve-3d;
            transform: rotateZ(-90deg) scale(0.8);
            right: -2%;
            top: 7%;
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