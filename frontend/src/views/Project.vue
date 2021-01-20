<template>
    <b-container fluid>
            <!-- <BackgroundPage pageTitle="Projets"/> -->
            <MenuNavigation linkColor="white" actionColorLink="#6d327c" spanColor="#6d327c"/>
        <b-row class="header">
            <PageTitle title="Projets" textColor="#6d327c"/>
        </b-row>
        <b-row class="cards">
            <ProjectCard title="Projet 1" content="Description projet 1"/>
            <ProjectCard title="Projet 2" content="Description projet 2"/>
            <ProjectCard title="Projet 3" content="Description projet 3"/>
            <ProjectCard title="Projet 4" content="Description projet 4"/>
            <ProjectCard title="Projet 5" content="Description projet 5"/>
        </b-row>
        <b-row class="back">
            <HomePageLink action="Retour" url="/" direction="animated-arrowLtr" class="link link-left" textColor="#6d327c"/>
        </b-row>
    </b-container>
</template>

<script>
import ProjectCard from '@/components/ProjectCard.vue'
import PageTitle from '@/components/PageTitle.vue'
import MenuNavigation from '@/components/MenuNavigation.vue'
// import BackgroundPage from '../components/BackgroundPage.vue'
import HomePageLink from '@/components/HomePageLink.vue'

export default {
    components: {
        ProjectCard,
        PageTitle,
        MenuNavigation,
        // BackgroundPage,
        HomePageLink
    }
}
</script>

<style lang="scss" scoped>
.container-fluid {
    background-color: $dark-gray;
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
        height: unset;
    }
    .back {
        height: 10vh;
    }
}
</style>