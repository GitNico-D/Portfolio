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
    text-shadow: 0 1px 0 $purple,
        0 2px 0 $purple, 
        0 3px 0 $purple, 
        0 4px 0 $purple, 
        0 5px 0 $purple,
        0 6px 0 $purple,
        0 7px 0 $purple, 
        0 8px 0 $purple, 
        0 9px 0 $purple,
        0 50px 30px rgba(109, 50, 124, 0.3);
    color: $white;            
    text-transform: uppercase;
}
</style>