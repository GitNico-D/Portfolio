<template>
    <div class="text-box">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#0099ff" fill-opacity="1" d="M0,64L1440,224L1440,320L0,320Z"></path></svg>
        <!-- <div class=""></div> -->
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
        pageTitle: String
    }
}
</script>

<style lang="scss">
.text-box {
    position: relative;
    perspective: 1000px;
    font-family: 'MontSerrat',  sans-serif;
    // height: 100vh;
    .one {
        position: absolute;
        text-transform: uppercase;
        overflow: hidden;
        transform: translate3d(200px, -80px, -35px);
        color: rgba(53, 53, 53, 0.8);
        font-size: 26rem;
    }
    .two {
        position: absolute;
        text-transform: uppercase;
        overflow: hidden;
        top: 0;
        transform: translate3d(-110rem, -5rem, -1rem);
        color: rgba(245,245,245,0.8);
        font-size: 55rem;
    }
}
</style>