<template>
    <b-container fluid>
        <MenuNavigation linkColor="white" activeLink="#6d327c" />
        <PageTitle title="Page Projets" textColor="#6d327c"/>
        <b-row>
            <Project title="Projet 1" content="Description projet 1"/>
            <Project title="Projet 2" content="Description projet 2"/>
            <Project title="Projet 3" content="Description projet 3"/>
            <Project title="Projet 4" content="Description projet 4"/>
        </b-row>
    </b-container>
</template>

<script>
import Project from '@/components/Project.vue'
import PageTitle from '@/components/PageTitle.vue'
import MenuNavigation from '@/components/MenuNavigation.vue'

export default {
    components: {
        Project,
        PageTitle,
        MenuNavigation
    }
}
</script>

<style lang="scss">
.container-fluid {
    @include container-background;
    .row {
        justify-content: space-around;
        align-items: center;        
    }
}
</style>