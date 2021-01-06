<template>
    <b-container fluid>
        <b-row id="circle">
            <div class="circle circle-blue"></div>
            <div class="circle circle-purple"></div>
            <div class="circle circle-green">
                <div class="circle circle-littleGreen"></div>
            </div>
            <div class="circle circle-purple2"></div>
            <div class="circle circle-green2"></div>
            <div class="circle circle-blue2"></div>
            <h1 id="title" v-on:mousemove="mouseMove" v-on:mouseleave="mouseLeave">
                <span>Nicolas</span>
                <h2> Développeur Web !</h2>
            </h1>    
        </b-row>
        <HomePageLink action="Projets" url="/projects" direction="animated-arrowRtl" class="position bottomButton"/>
        <HomePageLink action="Expériences" url="/experiences" direction="animated-arrowLtr" class="position upButton"/>
    </b-container>
</template>

<script>
import HomePageLink from "@/components/HomePageLink.vue"
import { gsap } from 'gsap'

export default {
    name: "background",
    components: {
        HomePageLink
    },
    mounted() {
        gsap.from(".circle", {
            duration: 2,
            scale: 0.5, 
            opacity: 0, 
            delay: 0.5, 
            ease: "back", 
            force3D: true
        });
        gsap.to(".circle-green", {
            rotation: 90, 
            duration: 5,
            ease: "elastic.out(1.5, 0.3)",
            repeat: -1 
        });
        gsap.to(".circle-purple2", {
            rotation: 90, 
            duration: 5,
            ease: "elastic.out(1.5, 0.3)",
            repeat: -1,
            },
            "+=1"
        );
    },
    methods: {
        // animatedSquare() {
        //         gsap.to(".circle-green", {
        //         rotation: 90, 
        //         duration: 5,
        //         ease: "elastic.out(1.5, 0.3)",
        //         repeat: -1 
        //     });
        // }
        // mouseMove(event) {
            // let circles = document.querySelectorAll(".circle");
            // let x = (window.innerWidth / 2 - event.pageX) / 25;
            // let y = (window.innerHeight / 2 - event.pageY) / 25;
            // circles.forEach(circle => {
            //     circle.style.transition = "ease";               
            //     circle.style.transform = `rotateX(${y}deg) rotateY(${x}deg)`;
            // });
            // document.getElementById("title").style.transform = `rotateX(${y}deg) rotateY(${x}deg)`;

        // },
        // mouseLeave() {
        //     document.getElementById("title").style.transform = "all 0.5s ease";
        //     document.getElementById("title").style.transform = `rotateX(0deg) rotateY(0deg)`;
        //     let circles = document.querySelectorAll(".circle");
        //     circles.forEach(circle => {
        //         circle.style.transition = "all 0.5s ease";
        //         circle.style.transform = "unset";
        //     });
        // }
    }
}
</script>

<style lang="scss">

.container-fluid {
    // background: no-repeat, linear-gradient(to right top, #6d327c, #485DA6, #00a1ba, #00BF98, #36C486)!important;
    background: whitesmoke;
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
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-weight: 900!important;
            color: black!important;
            font-size: 4rem!important;
            letter-spacing: 0.10em!important;
            text-shadow: 2px 3px 0px rgb(255, 187, 124);
            width: 60%;
            margin: auto;
        }
        h2 {
            z-index: 10;
        }
    }
}
.circle {
    position: absolute;
    // border-radius: 100%;
    transform-style: preserve-3d;
    transform: translate3d(0,0,0);
    &-blue {
        background-color: rgba(41,171,226,0.1);
        width: 5vw;
        height: 5vw;
        top: 60%;
        left: 50%;
        z-index: 1;
    }
    &-purple {
        background-color: rgba(109, 50, 124,0.1);
        border-radius: 100%;
        width: 30vw;
        height: 30vw;
        top: 20%;
        left: -20%;
        z-index: 5;
    }
    &-green {
        border: 25px solid rgba(54, 196, 134, 0.1);
        width: 15vw;
        height: 15vw;
        top: 25%;
        left: 70%;
        z-index: 20;
    }
    &-littleGreen {
        background-color: rgba(54, 196, 134, 0.1);
        width: 2vw;
        height: 2vw;
        top: 25%;
        left: 71%;
        z-index: 20;
    }
    &-purple2 {
        border: 25px solid rgba(72, 93, 166, 0.1);
        width: 10vw;
        height: 10vw;
        top: 60%;
        left: 20%;
        z-index: 30;
    }
    &-green2 {
        background-color: rgba(54, 196, 134,  0.1);
        width: 3vw;
        height: 3vw;
        top: 25%;
        left: 40%;
        z-index: 40;
    }
    &-blue2 {
        background-color: rgba(54, 196, 134,  0.1);
        width: 8vw;
        height: 8vw;
        top: 80%;
        right: 20%;
        z-index: 50;
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

