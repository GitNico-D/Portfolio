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
    text-shadow: 1px 1px rgba(109, 50, 124, 0.04),
        2px 2px rgba(109, 50, 124, 0.04), 
        3px 3px rgba(109, 50, 124, 0.04),
        4px 4px rgba(109, 50, 124, 0.04), 
        0.125rem 0.125rem rgba(109, 50, 124, 0.04), 
        6px 6px rgba(109, 50, 124, 0.04), 
        7px 7px rgba(109, 50, 124, 0.04), 
        8px 8px rgba(109, 50, 124, 0.04), 
        9px 9px rgba(109, 50, 124, 0.04), 
        0.3125rem 0.3125rem rgba(109, 50, 124, 0.04), 
        11px 11px rgba(109, 50, 124, 0.04), 
        12px 12px rgba(109, 50, 124, 0.04), 
        13px 13px rgba(109, 50, 124, 0.04), 
        14px 14px rgba(109, 50, 124, 0.04), 
        0.625rem 0.625rem rgba(109, 50, 124, 0.04), 
        16px 16px rgba(109, 50, 124, 0.04), 
        17px 17px rgba(109, 50, 124, 0.04),
        18px 18px rgba(109, 50, 124, 0.04), 
        19px 19px rgba(109, 50, 124, 0.04), 
        1.25rem 1.25rem rgba(109, 50, 124, 0.04);
    color: $white;            
    text-transform: uppercase;
}
</style>