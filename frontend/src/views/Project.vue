<template>
    <b-container fluid>
        <h1>Page Projets</h1>
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
export default {
    components: {
        Project
    }
}
</script>

<style lang="scss">
.container-fluid {
    @include container-background;
    h1 {
        @include customFont;
        @include text_shadow(2px, 3px, 2px);
        color: $white;            
    }
    .row {
        justify-content: space-around;
        align-items: center;        
    }
}
</style>