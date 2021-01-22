<template>
    <div>
        <div class="circlebackground -one" :style="{'--circle-color': circleColor }"></div>
    </div>
</template>

<script>
export default {
    name: "BackgroundPage",
    props: {
        circleColor: String
    }
}
</script>

<style lang="scss">
.circlebackground {
    position: absolute;
    border-radius: 50%;
    top: 50%;
    right: 50%;
    transform: translate(50%, -50%);
    &.-one {
        background-color: var(--circle-color);
        opacity: 1;
        width: 50vw;
        height: 50vw;
        @include box_shadow(0px, 0px, 20px, $purple);
    }
    @keyframes respire {
        from {
            transform: translateX(100%) translateY(100%);
        }
        to {
            transform: translateX(-150rem) translateY(-200%);
        }
    }
}
</style>