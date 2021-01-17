<template>
    <b-container fluid>
        <b-row>
            <BackgroundPage pageTitle="Projets"/>
            <MenuNavigation linkColor="white" actionColorLink="#6d327c" spanColor="#6d327c"/>
            <HomePageLink action="Retour" url="/" direction="animated-arrowLtr" class="link link-left" textColor="#6d327c"/>
            <PageTitle title="Page Projets" textColor="#6d327c"/>
            <!-- <Project title="Projet 1" content="Description projet 1"/>
            <Project title="Projet 2" content="Description projet 2"/>
            <Project title="Projet 3" content="Description projet 3"/>
            <Project title="Projet 4" content="Description projet 4"/> -->
        </b-row>
    </b-container>
</template>

<script>
// import Project from '@/components/Project.vue'
import PageTitle from '@/components/PageTitle.vue'
import MenuNavigation from '@/components/MenuNavigation.vue'
import BackgroundPage from '../components/BackgroundPage.vue'
import HomePageLink from '@/components/HomePageLink.vue'

export default {
    components: {
        // Project,
        PageTitle,
        MenuNavigation,
        BackgroundPage,
        HomePageLink
    }
}
</script>

<style lang="scss" scoped>
.container-fluid {
    .link {
        position: absolute;
        &-left {
            left: 1%;
            top: 95%;
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