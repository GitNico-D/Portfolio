<template>
    <b-container fluid>
        <PageTitle title="Page expériences" textColor="#00a1ba" />
    </b-container>
</template>

<script>
import PageTitle from '@/components/PageTitle.vue'

export default {
    components: {
        PageTitle
    }
}
</script>

<style lang="scss">
.container-fluid {
    @include container-background;
}
</style>