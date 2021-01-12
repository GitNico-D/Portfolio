<template>
    <b-container fluid>
        <b-row>
            <h1>Page Compétences</h1>
        </b-row>
    </b-container>
</template>

<script>
export default {

}
</script>

<style lang="scss">
    .row {
        h1 {
            @include customFont;
            @include text_shadow(2px, 3px, 2px);
            color: $white;            
        }
    }
</style>