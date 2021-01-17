<template>
    <b-container fluid >
        <b-row>
            <div class="circle_box">
                <div class="circle circle-blue"></div>
                <div class="circle circle-purple"></div>
                <div class="circle circle-green">
                    <div class="circle circle-littleGreen"></div>
                </div>
                <div class="circle circle-purple2" ></div>
                <div class="circle circle-green2"></div>
                <div class="circle circle-blue2"></div>
            </div>
            <div class="title" v-on:mouseleave="mouseLeave">
                <h2><span>Nicolas</span>,</h2> 
                <h1>Développeur Web</h1>
            <b-button >En savoir plus</b-button>
            </div>    
        </b-row>
        <Transition />
        <HomePageLink action="Projets" url="/projects" direction="animated-arrowRtl" class="link link-right" textColor="#36C486"/>
        <HomePageLink action="Expériences" url="/experiences" direction="animated-arrowLtr" class="link link-left" textColor="#36C486"/>
        <HomePageLink action="Parcours" url="/career" direction="animated-arrowRtl" class="link link-top" textColor="#36C486"/>
        <HomePageLink action="Compétences" url="/skills" direction="animated-arrowRtl" class="link link-bottom" textColor="#36C486"/>
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
        }
    },
    methods: {
        mouseLeave() { 
            gsap.from(".title h1", { duration: 2.5, ease: "elastic.out(1, 0.3)", stagger:0.5, z: -60 })
            gsap.from(".title h2", { duration: 2, ease: "elastic.out(1, 0.3)", stagger:0.5, z: -40 })
        }
    },
    mounted() {
        gsap.timeline()
            .from(".title h1", { y:160, stagger: 0.1, duration: 0.8, ease: "back" }, "+=0.5")
            .from(".title h2", { y:160, stagger: 0.1, duration: 0.8, ease: "back" }, "-=1")
            .from(".link", { opacity: 0, duration: 1}, "=-0.5")
            .from(".circle", { duration: 1, scale: 0.5,  opacity: 0, stagger: 0.3}, "-=0.25")
    }
}
</script>

<style lang="scss">
.container-fluid {
    @include container-background;
    perspective: 1000px;
    .row {
        height: 100vh;
        .title {
            @include customFont;
            position: absolute;
            top: 45%;
            left: 20%;
            color: $white!important;
            line-height: 50px;
            width: 70%;
            text-align: left;
            &:hover {
                cursor: default;
            }
            span {
                color: $green;
                @include text_shadow(0px, 0px, 5px);
            }
            h1 {
                @include customFont;
                @include text_shadow(2px, 3px, 2px);
                color: $white!important;
            }
            .btn {
                margin: 2rem 0 0 20rem;
                color: $green!important;
                background-color: transparent!important;
                border: 1px solid $green!important;
                &:hover {
                    color: $white!important;
                    background-color: $green!important;
                    box-shadow:0 0 10px $white!important; 
                }
            }   
        }
    }
}
.circle_box {
    height: 100vh;
    width: 100vw;
}
.circle {
    position: absolute;
    width: 100%;
    border-radius: 100%;
    animation: circles 9.5s linear infinite;
    &-blue {
        background-color: $light-blue;
        width: 10vw;
        height: 10vw;
        top: 44%;
        left: 50%;
        // transform-style: preserve-3d;
        animation-duration: 15s;
        filter: blur(7px);
    }
    &-purple {
        background-color: $purple;
        border-radius: 100%;
        width: 30vw;
        height: 30vw;
        top: 20%;
        left: -20%;
        @include box_shadow(0px, 0px, 100px, $purple);
        transform-style: preserve-3d;
        animation-duration: 6s; 
        filter: blur(3px);
    }
    &-green {
        border: 25px solid $green;
        width: 15vw;
        height: 15vw;
        top: 10%;
        right: 5%;
        transform-style: preserve-3d;
        @include box_shadow(0px, 0px, 50px); 
        animation-duration: 30s; 
        filter: blur(10px);
    }
    &-littleGreen {
        background-color: $green;
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
        @include box_shadow(0px, 0px, 50px, $white);
    }
    &-blue2 {
        background-color: $purple;
        width: 8vw;
        height: 8vw;
        top: 80%;
        right: 20%;
        @include box_shadow(0px, 0px, 75px, $purple);
        transform-style: preserve-3d;
        filter: blur(1px);
    }
    @keyframes circles { 
        from { transform: translateY(450%) }
        to   { transform: translateY(calc(-100vh + -100%)) translateX(75%)}
    }
}

.link {
    position: absolute;
    &-left {
        left: 5%;
        top: 5%;
    }
    &-right {
        right: 4%;
        bottom: 5%;
    }
    &-top {
        transform-style: preserve-3d;
        transform: rotateZ(-90deg);
        right: 0;
        top: 15%;
    }
    &-bottom {
        transform-style: preserve-3d;
        transform: rotateZ(90deg);
        left: 0;
        bottom: 17%;
    }
}

@media (min-width: 320px) {
    .container-fluid .row{
        .title {
            h1 {
                font-size: 1.5rem;
                margin-left: 0;
            }
            h2 {
                font-size: 1rem;
            }
            .btn {
                margin: 2rem 0 0 4rem;
                transform: scale(0.8);
            }
        }
    }
}
@media (min-width: 576px) {
    .container-fluid .row{
        .title {
            h1 {
                font-size: 2rem;
                margin-left: 0.5rem;
            }
            h2 {
                font-size: 1.3rem;
            }
            .btn {
                margin: 2rem 0 0 15rem;
                transform: scale(1);
            }
        }
    }
}
@media (min-width: 768px) {
    .container-fluid .row{
        .title {
            h1 {
                font-size: 2.5rem;
                margin-left: 1rem;
            }
            h2 {
                font-size: 1.8rem;
            }
            .btn {
                margin: 2rem 0 0 18rem;
            }
        }
    }
}
@media (min-width: 992px) {
    .container-fluid .row{
        .title {
            h1 {
                font-size: 2rem;
                margin-left: 1.5rem;
            }
            h2 {
                font-size: 2rem;
            }
            .btn {
                margin: 2rem 0 0 20rem;
            }
        }
    }
}
@media (min-width: 1200px) {
    .container-fluid .row{
        .title {
            h1 {
                font-size: 4rem;
                margin-left: 2rem;
            }
            h2 {
                font-size: 2.5rem;
            }
            .btn {
                margin: 2rem 0 0 30rem;
            }
        }
    }
}
</style>

