<template>
    <b-container fluid >
        <Header title="Parcours" color="#00a1ba"/>
        <BackgroundPage circleColor="#00a1ba"/>
        <CareerStageOdd date="date 1 - date 2"  title="Stage 1" company="Company 1" color="#00a1ba"/>
        <CareerStageEven date="date 1 - date 2"  title="Stage 1" company="Company 1" color="#00a1ba"/>
        <CareerStageOdd date="date 1 - date 2"  title="Stage 1" company="Company 1" color="#00a1ba"/>
        <CareerStageEven date="date 1 - date 2"  title="Stage 1" company="Company 1" color="#00a1ba"/>
        <b-row class="bottom">
            <HomePageLink action="Retour" url="/" direction="animated-arrowRtl" class="link link-bottom" textColor="#00a1ba"/>
        </b-row> 
        <div class="line"></div>
    </b-container>
</template>

<script> 
import HomePageLink from '@/components/HomePageLink.vue'
import BackgroundPage from '@/components/BackgroundPage.vue'
import Header from '@/components/Header.vue'
import CareerStageEven from '@/components/CareerStageEven.vue'
import CareerStageOdd from '@/components/CareerStageOdd.vue'

export default {
    components: {
        HomePageLink,
        BackgroundPage,
        Header,
        CareerStageEven,
        CareerStageOdd
    }
}
</script>

<style lang="scss" scoped>
.container-fluid {
    position: relative;
    perspective: 1000px;
    .line {
        position: absolute;
        height: 70%;
        width: 3px;
        left: 50%;
        top: 14%;
        background-color: $white;
        transform: translateZ(-10px);
        animation: scale-up-ver-top 2s cubic-bezier(0.390, 0.575, 0.565, 1.000) 1s both;
    }
}
.row {
    height: unset;
}
.bottom {
    height: 20vh;
    position: relative;
    .link-bottom {
        position: absolute;
        bottom: 50%;
        left: 50%;
        transform: translate(-50%, 50%) rotate(90deg) scale(0.8);
    }
}
@keyframes scale-up-ver-top {
    0% {
        transform: scaleY(0);
        transform-origin: 100% 0%;
        background-color: $light-blue;
    }
    100% {
        transform: scaleY(1);
        transform-origin: 100% 0%;
        background-color: $white;
    }
}
@media (min-width: 320px) {
    .container-fluid {
        .line {
            display: none;
        }
    }
}
@media (min-width: 576px) {
    .container-fluid {
        .line {
            display: initial;
            height: 72%;
            top: 12%;
        }
    }
}
@media (min-width: 768px) {
    .container-fluid {
        .line {
            display: initial;
            height: 74%;
            top: 12%;
        }
    }
}
@media (min-width: 1200px) {
    .container-fluid {
        .line {
            display: initial;
            height: 69%;
            top: 14%;
        }
    }
}
</style>