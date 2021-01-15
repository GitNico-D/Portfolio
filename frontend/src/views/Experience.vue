<template>
    <b-container fluid>
        <MenuNavigation linkColor="white" actionColorLink="#00a1ba"/>
        <PageTitle title="Page expériences" textColor="#00a1ba" />
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