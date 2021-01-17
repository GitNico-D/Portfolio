<template>
    <b-container fluid>
        <b-row>
            <BackgroundPage pageTitle="Projets"/>
            <MenuNavigation linkColor="white" actionColorLink="#6d327c"/>
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

export default {
    components: {
        // Project,
        PageTitle,
        MenuNavigation,
        BackgroundPage
    }
}
</script>

<style lang="scss">
.container-fluid {
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