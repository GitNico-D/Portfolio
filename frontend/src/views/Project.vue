<template>
    <b-container fluid>
        <BackgroundPage pageTitle="Projets"/>
        <MenuNavigation linkColor="white" actionColorLink="#6d327c"/>
        <PageTitle title="Page Projets" textColor="#6d327c"/>
        <b-row>
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
    @include container-background;
    // background: linear-gradient(150deg, rgba(246,213,255,1) 0%, rgba(246,213,255,1) 50%, rgba(109,50,124,1) 50%, rgba(109,50,124,1) 100%);
    .row {
        justify-content: space-around;
        align-items: center;        
    }
    .text-box {
        position: absolute;
    }
}
</style>