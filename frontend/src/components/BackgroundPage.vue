<template>
    <div>
        <div class="circlebackground -one" :style="{'--circle-color': circleColor }"></div>
        <div class="circlebackground -two" :style="{'--circle-color': circleColor }"></div>
        <div class="circlebackground -three" :style="{'--circle-color': circleColor }"></div>
        <div class="circlebackground -four" :style="{'--circle-color': circleColor }"></div>
        <div class="circlebackground -five" :style="{'--circle-color': circleColor }"></div>
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
    background-color: var(--circle-color);
    top: 50%;
    right: 50%;
    transform: translate(50%, -50%);
    &.-one {
        opacity: 0.4;
        width: 60vw;
        height: 60vw;
        filter: blur(2px);
    }
    &.-two {
        opacity: 0.2;
        width: 70vw;
        height: 60vw;
    }
    &.-three {
        opacity: 0.4;
        width: 75vw;
        height: 60vw;
    }
    // &.-four {
    //     opacity: 0.6;
    //     width: 5vw;
    //     height: 5vw;
    // }
    // &.-five {
    //     opacity: 0.4;
    //     width: 15vw;
    //     height: 15vw;
    // }
    @keyframes circletranslate {
        from {
            transform: translateX(100%) translateY(100%);
        }
        to {
            transform: translateX(-150rem) translateY(-200%);
        }
    }
}
</style>