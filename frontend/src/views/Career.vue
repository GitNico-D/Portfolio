<template>
    <b-container fluid >
        <Header title="Parcours" color="#00a1ba" class="header"/>
        <BackgroundPage circleColor="#00a1ba"/>
        <Transition v-show="showTransition" directionAnimation="down"/>
        <CareerStage startDate="2000"  endDate="2000"  title="Stage 1" company="Company 1" color="#00a1ba" parity="odd"/>
        <CareerStage startDate="2000"  endDate="2000"  title="Stage 1" company="Company 1" color="#00a1ba" parity="even"/>
        <CareerStage startDate="2000"  endDate="2000"  title="Stage 1" company="Company 1" color="#00a1ba" parity="odd"/>
        <CareerStage startDate="2000"  endDate="2000"  title="Stage 1" company="Company 1" color="#00a1ba" parity="even"/>
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
import CareerStage from '@/components/CareerStage.vue'
import Transition from "@/components/Transition.vue"

export default {
    components: {
        HomePageLink,
        BackgroundPage,
        Header,
        CareerStage,
        Transition
    },
    data() {
        return {
            showTransition: true    
        }
    },
    methods: {
        actionTransition () {
            this.showTransition = true;
            setTimeout(() => {
                this.showTransition = false;
            },1300);
        }
    },
    created() {
        setTimeout(() => {
            this.showTransition = false;
        },1300);
    }
}
</script>

<style lang="scss" scoped>
.bottom {
    height: 16vh!important;
    position: relative;
    .link-bottom {
        position: absolute;
        bottom: 50%;
        left: 50%;
        transform: translate(-50%, 50%) rotate(90deg) scale(0.8);
    }
}
.header {
    padding-bottom: 5rem;
}
.line {
    position: absolute;
    height: 70%;
    width: 3px;
    left: 50%;
    top: 14%;
    background-color: $white;
    transform: translateZ(-10px);
    animation: scale-up-ver-top 2s cubic-bezier(0.390, 0.575, 0.565, 1.000) 0.5s both;
    z-index: 1;
}
.row {
    height: unset;
}
.odd {
    margin-bottom: 10rem;
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
@media (min-width: 768px) {
    .container-fluid {
        .line {
            display: initial;
            height: 72%;
            top: 12%;
        }
    }
}
@media (min-width: 1200px) {
    .container-fluid {
        .line {
            display: initial;
            height: 70%;
            top: 15%;
        }
    }
}
</style>