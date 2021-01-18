<template>
    <b-container fluid>
            <BackgroundPage pageTitle="Projets"/>
            <MenuNavigation linkColor="white" actionColorLink="#6d327c" spanColor="#6d327c"/>
        <b-row class="header">
            <PageTitle title="Projets" textColor="#6d327c"/>
        </b-row>
        <b-row class="cards">
            <Project title="Projet 1" content="Description projet 1"/>
            <Project title="Projet 2" content="Description projet 2"/>
            <Project title="Projet 3" content="Description projet 3"/>
            <Project title="Projet 4" content="Description projet 4"/>
            <Project title="Projet 5" content="Description projet 5"/>
        </b-row>
        <b-row class="back">
            <HomePageLink action="Retour" url="/" direction="animated-arrowLtr" class="link link-left" textColor="#6d327c"/>
        </b-row>
    </b-container>
</template>

<script>
import Project from '@/components/Project.vue'
import PageTitle from '@/components/PageTitle.vue'
import MenuNavigation from '@/components/MenuNavigation.vue'
import BackgroundPage from '../components/BackgroundPage.vue'
import HomePageLink from '@/components/HomePageLink.vue'

export default {
    components: {
        Project,
        PageTitle,
        MenuNavigation,
        BackgroundPage,
        HomePageLink
    }
}
</script>

<style lang="scss" scoped>
.container-fluid {
    background: linear-gradient(150deg, $light-purple 0%, $light-purple 50%, $purple 50%, $purple 100%);
    .link {
        position: absolute;
        &-left {
            left: 1%;
            top: 95%;
            transform: scale(0.8);
        }
    }
    .header {
        align-items: center;        
        height: 10vh;
        margin: 2rem 0 0 0;
    }
    .nav {
        position: absolute;
        top: 0;
        left: 5rem;
    }
    .cards {
        justify-content: space-around; 
        width: 90%;
        margin: auto;
    }
    .back {
        height: 10vh;
    }
}
</style>