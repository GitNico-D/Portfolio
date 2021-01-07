<template>
    <b-container fluid>
        <b-row id="circle" v-on:mousemove="mouseMove">
            <div class="circle circle-blue" :style="{left: x, top: y, position: 'absolute'}">
            </div>
                <div>{{x}}, {{y}}</div>
            <div class="circle circle-purple"></div>
            <div class="circle circle-green">
                <div class="circle circle-littleGreen"></div>
                <div class="circle circle-littleGreen2"></div>
            </div>
            <div class="circle circle-purple2"></div>
            <div class="circle circle-green2"></div>
            <div class="circle circle-blue2"></div>
            <div id="title">
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
            x: 0,
            y: 0
        }
    },
    mounted() {
        gsap.timeline()
            // .from("#title h1", { y:160, stagger: 0.1, duration: 0.8, ease: "back" }, "+=3")
            // .from("#title h2", { y:160, stagger: 0.1, duration: 0.8, ease: "back" }, "-=0.90")
            // .fromTo(".upButton", { opacity: 0 }, { opacity: 1, duration: 1 })
            // .fromTo(".bottomButton", { opacity: 0 }, { opacity: 1, duration: 1 }, "-=1")
            // .from(".circle", {
            //     duration: 1,
            //     scale: 0.5,
            //     rotation: 180, 
            //     opacity: 0, 
            //     // delay: 0.5,
            //     stagger: 0.1, 
            //     ease: "back", 
            //     force3D: true
            // }, "-=1.5")
            // .fromTo(".circle-blue", { opacity: 0, scale: 0 }, { xPercent: 50, yPercent: 65, opacity: 1, rotation: 360, scale: 1, ease: "back", stagger: 0.1 }, "-=1")
        // gsap.from(".circle-green", { rotation: 360, duration: 5, repeat: -1, ease: "none" })
    },
    methods: {
        // mouseEnter() {
        // },
        mouseMove(event) {
            this.y = event.clientY + "px";
            this.x = event.clientX + "px";
            
            // this.rotateY(`${xAxis}deg`);
        }
        // mouseLeave() {
        //     this.style.transform = `rotateY(0deg) rotateX(0deg)`
            // circle = document.querySelectorAll(".circle");
            
            // document.getElementById("title").style.transition = "all 0.5s ease";
            // document.getElementById("title").style.transform = `rotateY(0deg) rotateX(0deg)`;
        // }
    }
}
</script>

<style lang="scss">

.container-fluid {
    // background: no-repeat, linear-gradient(to right top, #6d327c, #485DA6, #00a1ba, #00BF98, #36C486)!important;
    // background: linear-gradient(180deg, rgba(255,255,255,0.03405112044817926) 75%, rgba(218,218,218,0.773546918767507) 95%);
    background-color: whitesmoke;
    width: 100vh;
    position: relative;
    perspective: 1000px;
    #background {
        position: relative;
        left: 50%;
        top: 0;
        transform: translate(-50%, 0);
        overflow: hidden;
        width: 100%;
        height: 100vh;
    }
    .row {
        height: 100vh;
        h1 {
            @include customFont;
            color: $green!important;
            width: 85%;
            margin: auto;
        }
        h2 {
            font-size: 2.5rem; 
        }
        #title {
            @include customFont;
            transform-style: preserve-3d;
            color: $white!important;
            margin: auto;
            width: 60%;
            text-align: left;
            span {
                color: $purple;
            }
        }
    }
}
.circle {
    position: absolute;
    border-radius: 100%;
    transform-style: preserve-3d;
    // transform: translate3d(0,0,0);
    &-blue {
        background-color: rgba(41,171,226,0.3);
        width: 10vw;
        height: 10vw;
        top: 44%;
        left: 50%;
        z-index: 1;
    }
    &-purple {
        background-color: rgba(109, 50, 124,0.5);
        border-radius: 100%;
        width: 30vw;
        height: 30vw;
        top: 20%;
        left: -20%;
        z-index: 5;
        transform: rotateX(25deg) rotateY(25deg);
    }
    &-green {
        border: 25px solid rgba(54, 196, 134, 0.6);
        width: 15vw;
        height: 15vw;
        top: 10%;
        right: 5%;
        overflow: hidden;
    }
    &-littleGreen {
        background-color: rgba(54, 196, 134, 0.6);
        width: 2vw;
        height: 2vw;
        top: 25%;
        left: 70%;
    }
    // &-littleGreen2 {
    //     border-radius: 100%;
    //     background-color: rgba(54, 196, 134, 0.6);
    //     width: 2vw;
    //     height: 2vw;
    //     top: 0;
    //     left: 0;
    //     transform: translate(-100%);
    // }
    &-purple2 {
        border: 25px solid rgba(72, 93, 166, 0.7);
        width: 10vw;
        height: 10vw;
        top: 60%;
        left: 20%;
        z-index: 30;
    }
    &-green2 {
        background-color: rgba(54, 196, 134,  0.9);
        width: 3vw;
        height: 3vw;
        top: 25%;
        left: 40%;
        z-index: 40;
    }
    &-blue2 {
        background-color: $light-blue-alpha;
        width: 8vw;
        height: 8vw;
        top: 80%;
        right: 20%;
        transform-style: preserve-3d;
        transform: translateZ(50px);
    }

}
.position {
    // @include positionX;
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

