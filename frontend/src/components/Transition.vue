<template>
    <b-row class="intro">
        <div class="intro-text">
            <div class="hide">
            <span class="text">{{wordOne}}</span>
            </div>
            <div class="hide">
            <span class="text">{{wordTwo}}</span>
            </div>
            <div class="hide">
            <span class="text">{{wordThree}}</span>
            </div>
        </div>
        <div class="slider"></div>
    </b-row>
</template>

<script>
import gsap from 'gsap'

export default {
    name: "Transition",
    props: {
        wordOne: String,
        wordTwo: String,
        wordThree: String
    },
    mounted() {
        gsap.timeline({defaults: { ease: "power1.out"}})
            .to(".slider", { y: "-100%", duration: 1})
            .to(".intro", { y: "-100%", duration: 0.5 }, "-=0.5")
    }
}
</script>

<style lang="scss">
.intro {
    background: $green;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}
.slider {
    background: $purple;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    transform: translateY(100%);
}
.intro-text {
    @include customFont;
    color: rgb(233, 233, 233);
    font-family: "Montserrat", sans-serif;
    font-size: 5.5rem!important;
    .hide {
        background: $green;
        overflow: hidden;
        width: 100%!important;
    }
    .hide span {
        transform: translateY(100%);
        display: inline-block;
    }
}
</style>