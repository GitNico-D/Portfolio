<template>
    <b-container fluid>
        <MenuNavigation linkColor="white" actionColorLink="#485DA6"/>
        <PageTitle title="Page Carrières" textColor="#485DA6"/>
    </b-container>
</template>

<script>
import PageTitle from '@/components/PageTitle.vue'
import MenuNavigation from '@/components/MenuNavigation.vue' 

export default {
    components: {
        PageTitle,
        MenuNavigation
    }
}
</script>

<style lang="scss">
.container-fluid {
    @include container-background;
}
</style>