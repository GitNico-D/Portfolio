<template>
    <div>
        <div class="circlebackground" :style="{'--circle-color': circleColor }"></div>
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
    left: 50%;
    transform: translate(-50%, -50%);
    border: 0px solid var(--circle-color);
    opacity: 1;
    width: 40vw;
    height: 40vw;
    @include box_shadow(0px, 0px, 55px, var(--circle-color));
    animation: scale-up-center 0.8s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;
}
@keyframes scale-up-center {
    0% {
    transform: translate(-50%, -50%) scale(0);
    }
    100% {
    transform:translate(-50%, -50%) scale(1);
    }
}
</style>