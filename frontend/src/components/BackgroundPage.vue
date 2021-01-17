<template>
    <div class="text-box">
        <div class="one">
            {{pageTitle}}
        </div>
        <div class="two">
            {{pageTitle}}
        </div>
    </div>
</template>

<script>
export default {
    name: "BackgroundPage",
    props: {
        pageTitle: String,
        gradientFirstColor: String,
        gradientSecondColor: String
    }
}
</script>

<style lang="scss">
.text-box {
    // background: linear-gradient(150deg, $light-purple 0%, $light-purple 50%, $purple 50%, $purple 100%);
    position: relative;
    perspective: 1000px;
    font-family: 'MontSerrat',  sans-serif;
    width: 100vw;
    height: 100vh;
    transform: translate3d(0, 0, 1rem);
    .one {
        position: absolute;
        text-transform: uppercase;
        overflow: hidden;
        top: 5%;
        color: rgba(53, 53, 53, 0.8);
        font-size: 20rem;
        animation: 25s linear infinite translatingOne;
        filter: blur(0.5px);
    }
    .two {
        position: absolute;
        text-transform: uppercase;
        overflow: hidden;
        top: 0;
        color: rgba(245,245,245,0.8);
        font-size: 55rem;
        filter: blur(4px);
        animation: 10s linear infinite translatingTwo;
    }
    @keyframes translatingTwo {
        from { transform: translateX(-250rem); }
        to   { transform: translateX(200rem); }
    }
    @keyframes translatingOne {
        from { transform: translateX(-125rem); }
        to   { transform: translateX(125rem); }
    }
}
</style>