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
            </div>    
        <b-button >En savoir plus</b-button>
        </b-row>
        <Transition />
        <HomePageLink action="Projets" url="/projects" direction="animated-arrowRtl" class="link link-right"/>
        <HomePageLink action="Expériences" url="/experiences" direction="animated-arrowLtr" class="link link-left"/>
        <HomePageLink action="Parcours" url="/career" direction="animated-arrowRtl" class="link link-top"/>
        <HomePageLink action="Compétences" url="/skills" direction="animated-arrowRtl" class="link link-bottom"/>
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
    background-color: rgba(0,0,0, 0.9);
    width: 100vh;
    position: relative;
    perspective: 1000px;
    overflow: hidden;
    .row {
        height: 100vh;
        .title {
            @include customFont;
            position: absolute;
            top: 45%;
            left: 20%;
            color: $white!important;
            line-height: 50px;
            width: 60%;
            text-align: left;
            &:hover {
                cursor: default;
            }
            span {
                color: $green;
                text-shadow: 0px 0px 5px $green;
            }
            h1 {
                @include customFont;
                color: $white!important;
                text-shadow: 2px 3px 2px $green;
                width: 85%;
            }
            h2 {
                font-size: 2.5rem; 
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
        to   { transform: translateY(calc(-100vh + -100%)) translateX(75%)}
    }
}
.btn {
    position: absolute;
    top: 60%;
    left: 50%;
    color: $green!important;
    background-color: transparent!important;
    border: 1px solid $green!important;
    &:hover {
        color: $white!important;
        background-color: $green!important;
        box-shadow:0 0 10px $white!important; 
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

@media (min-width: 1200px) {
    .title {
        h1 {
            font-size: 4rem;
        }
    }
}
@media (min-width: 992px) {
    .title {
        h1 {
            font-size: 2rem;
        }
    }
}
@media (min-width: 768px) {
    .title {
        h1 {
            font-size: 2rem;
        }
    }
}
@media (min-width: 576px) {
    .title {
        h1 {
            font-size: 2rem;
        }
    }
}

</style>

