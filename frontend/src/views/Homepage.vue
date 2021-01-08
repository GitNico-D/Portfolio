<template>
    <b-container fluid>
        <b-row id="circle" :style="style">
            <div class="circle circle-blue" :style="translate"></div>
            <div class="circle circle-purple"></div>
            <div class="circle circle-green">
                <div class="circle circle-littleGreen"></div>
            </div>
            <div class="circle circle-purple2" ></div>
            <div class="circle circle-green2"></div>
            <div class="circle circle-blue2"></div>
            <div id="title" v-on:mousemove="mouseMove" v-on:mouseleave="mouseLeave">
                <h2><span>Nicolas</span>,</h2> 
                <h1>Développeur Web</h1>
            </div>    
        </b-row>
        <Transition wordOne="Bienvenue" wordTwo="sur mon" wordThree="Portfolio" />
        <HomePageLink action="Projets" url="/projects" direction="animated-arrowRtl" class="position bottomButton"/>
        <HomePageLink action="Expériences" url="/experiences" direction="animated-arrowLtr" class="position upButton"/>
    </b-container>
</template>

<script>
import HomePageLink from "@/components/HomePageLink.vue"
import Transition from "@/components/Transition.vue"
import { gsap } from 'gsap'

export default {
    name: "background",
    components: {
        HomePageLink,
        Transition
    },
    data() {
        return {
            move: false,
            x: 0,
            y: 0
        }
    },
    computed: {
        style() {
            if(this.move) {
                return {
                    transform: `rotateX(${this.y}deg) rotateY(${this.x}deg)`
                }
            } else {
                return { 
                    transition: "all 0.5s ease",
                    transform: `rotateX(0deg) rotateY(0deg)`
                }
            }
        },
        translate() {
            return { transform: `translateZ(${this.x}px)`};
        }
    },
    methods: {
        mouseMove(event) {
            this.move = true;
            this.y = (window.innerWidth / 2 - event.pageY) / 25;
            this.x = (window.innerWidth / 2 - event.pageX) / 25;
        },
        mouseLeave() { 
            this.move = false;      
        }
    },
    mounted() {
        gsap.timeline()
            .from("#title h1", { y:160, stagger: 0.1, duration: 0.8, ease: "back" }, "+=3")
            .from("#title h2", { y:160, stagger: 0.1, duration: 0.8, ease: "back" }, "-=0.90")
            .fromTo(".upButton", { opacity: 0 }, { opacity: 1, duration: 1 })
            .fromTo(".bottomButton", { opacity: 0 }, { opacity: 1, duration: 1 }, "-=1")
            .from(".circle", {
                duration: 1,
                scale: 0.5, 
                opacity: 0, 
                // delay: 0.5,
                stagger: 0.3
            }, "-=2")
        // .fromTo(".circle-blue", { opacity: 0, scale: 0 }, { xPercent: 50, yPercent: 65, opacity: 1, rotation: 360, scale: 1, ease: "back", stagger: 0.1 }, "-=1")
        // gsap.from(".circle-green", { rotation: 360, duration: 5, repeat: -1, ease: "none" })
    }
}
</script>

<style lang="scss">
.container-fluid {
    background-color: rgba(0,0,0, 0.9);
    width: 100vh;
    position: relative;
    perspective: 1000px;
    overflow: hidden;
    .row {
        height: 100vh;
        #title {
            @include customFont;
            color: $white!important;
            line-height: 50px;
            width: 60%;
            text-align: left;
            span {
                color: $green;
                text-shadow: 0px 0px 20px $green;
            }
            h1 {
                @include customFont;
                color: $white!important;
                width: 85%;
            }
            h2 {
                font-size: 2.5rem; 
            }
        }
    }
}
.circle {
    position: absolute;
    border-radius: 100%;
    animation: circles 9.5s linear infinite;
    &-blue {
        background-color: rgba(41,171,226,1);
        width: 10vw;
        height: 10vw;
        top: 44%;
        left: 50%;
        transform-style: preserve-3d;
        animation-duration: 15s;
        filter: blur(10px);
    }
    &-purple {
        background-color: $purple;
        border-radius: 100%;
        width: 30vw;
        height: 30vw;
        top: 20%;
        left: -20%;
        box-shadow:0 0 100px $purple;
        transform-style: preserve-3d;
        animation-duration: 6s; 
        filter: blur(3px);
    }
    &-green {
        border: 25px solid rgba(54, 196, 134, 1);
        width: 15vw;
        height: 15vw;
        top: 10%;
        right: 5%;
        overflow: hidden;
        transform-style: preserve-3d;
        box-shadow:0 0 50px $green; 
        animation-duration: 30s; 
        filter: blur(10px);
    }
    &-littleGreen {
        background-color: rgba(54, 196, 134, 1);
        width: 2vw;
        height: 2vw;
        top: 25%;
        left: 70%;
        transform-style: preserve-3d;
        animation-duration: 5s; 
    }
    &-purple2 {
        border: 25px solid $blue;
        width: 10vw;
        height: 10vw;
        top: 60%;
        left: 20%;
        z-index: 30;
        transform-style: preserve-3d;
        animation-duration: 10s; 
        filter: blur(3px);
    }
    &-green2 {
        background-color: $white;
        width: 3vw;
        height: 3vw;
        top: 25%;
        left: 40%;
        box-shadow:0 0 50px $white;
    }
    &-blue2 {
        background-color: $purple;
        width: 8vw;
        height: 8vw;
        top: 80%;
        right: 20%;
        box-shadow:0 0 75px $purple;
        transform-style: preserve-3d;
        transform: translateZ(50px);
        filter: blur(1px);
    }

    @keyframes circles { 
        from { transform: translateY(450%) }
        to   { transform: translateY(calc(-100vh + -100%)) translateX(75%)}}

}
.position {
    position: absolute;
    &.upButton {
        top: 5%;
        left: 7%;
    }
    &.bottomButton {
        right: 7%;
        bottom: 5%;
    }
}
</style>

