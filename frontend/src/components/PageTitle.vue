<template>
    <h1 :style="{'--text-color': textColor}">{{ title }}</h1>
</template>

<script>
export default {
    name: "PageTitle",
    props: {
        title: String,
        textColor: String
    }
}
</script>

<style lang="scss">
h1 {
    @include customFont;
    // @include text_shadow(2px, 3px, 2px, var(--text-color)!important);
    @include special-text-shadow;
    color: $white;            
    text-transform: uppercase;
}
</style>