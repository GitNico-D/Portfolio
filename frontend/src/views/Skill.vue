<template>
    <b-container fluid>
        <MenuNavigation linkColor="white" actionColorLink="#36C486"/>
        <PageTitle title="Page Compétences" textColor="#36C486" />
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