<template>
    <b-container fluid>
        <b-row>
        <svg id="background" xmlns="http://www.w3.org/2000/svg">
            <circle cx="246" cy="189" r="60" fill="#8cc63f"/>
            <circle cx="865" cy="348" r="50" fill="#29abe2"/>
            <circle cx="400" cy="290" r="40" fill="#a82a2a"/>
            <circle cx="80" cy="550" r="12" fill="#93278f"/>
            <circle cx="25" cy="850" r="150" fill="#93278f"/>
            <circle cx="550" cy="392" r="12" fill="#93278f"/>
            <circle cx="550" cy="392" r="12" fill="#93278f"/>
            <circle cx="550" cy="392" r="12" fill="#93278f"/>
        </svg>        
            <h1>
                BIENVENUE SUR MON PORTFOLIO !
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
        gsap.from("circle", {
            duration: 2,
            scale: 0.5, 
            opacity: 0, 
            delay: 0.5, 
            ease: "back", 
            force3D: true
        });
    },
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
            font-size: 4em!important;
            letter-spacing: 0.10em!important;
            // text-shadow: 2px 3px 0px $gray-shadow;
            text-shadow:
                0 0 10px #6d327c, 
                0 0 20px #485DA6, 
                0 0 30px #e60073, 
                0 0 40px #e60073, 
                0 0 50px #00a1ba, 
                0 0 60px #00BF98, 
                0 0 70px #36C486;
            width: 60%;
            margin: auto;
        }
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

