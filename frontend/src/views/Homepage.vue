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
            <div class="title" >
                <h2><span>Nicolas</span>,</h2> 
                <h1>Développeur Web</h1>
            <b-button @click="actionTransition" directionAnimation="up">En savoir plus</b-button>
            </div>    
        </b-row>
        <Transition v-show="showTransition" directionAnimation="up"/>
        <HomePageLink @click="actionTransition" directionAnimation="right" action="Projets" url="/projects" direction="animated-arrowRtl" class="link link-right"/>
        <HomePageLink action="Expériences" url="/experiences" direction="animated-arrowLtr" class="link link-left"/>
        <HomePageLink action="Parcours" url="/career" direction="animated-arrowRtl" class="link link-top"/>
        <HomePageLink action="Compétences" url="/skills" direction="animated-arrowRtl" class="link link-bottom"/>
    </b-container>
</template>

<script>
import HomePageLink from "@/components/HomePageLink.vue"
import Transition from "@/components/Transition.vue"

export default {
    name: "background",
    components: {
        HomePageLink,
        Transition,
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

<style lang="scss">
.container-fluid {
    background-color: $dark-gray;
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
            left: 24%;
            color: $white!important;
            line-height: 50px;
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
                margin-left: 2rem;
                animation: slideH1 1s ease-in-out 0.5s;
                transition: transform 0.5s cubic-bezier(.03,.92,.87,1.46);
                &:hover {
                    transform: translate3d(0px, 0px, 100px);
                }
            }
            h2 {
                font-size: 2.5rem; 
                animation: slideH2 1.25s ease-in-out 0.5s;
                transition: transform 0.5s cubic-bezier(.03,.92,.87,1.46);
                &:hover {
                    transform: translate3d(0px, 0px, 100px);
                }
            }
            .btn {
                margin: 2rem 0 0 20rem;
                color: $green!important;
                background-color: transparent!important;
                border: 2px solid $green!important;
                animation: slideBtn 1.25s ease-in-out 0.5s;
                &:hover {
                    color: $white!important;
                    background-color: $green!important;
                    box-shadow: 0 0 10px $white!important; 
                }
            }  
        }
    }
}
@keyframes slideH1 {
    0% {
        transform: translateY(100px);
    }  
    50% {
        transform: translateY(-40px);
    }
    100% {
        transform: translateY(0px);
    }
}
@keyframes slideH2 {
    0% {
        transform: translateY(100px);
    }  
    50% {
        transform: translateY(-60px);
    }
    100% {
        transform: translateY(0px);
    }
}
@keyframes slideBtn {
    0% {
        transform: translateY(80px) ;
    }  
    50% {
        transform: translateY(-30px);
    }
    100% {
        transform: translateY(0px);
    }
}
@keyframes opacityIn {
    0% {
        opacity: 0;
    }  
    50% {
        opacity: 0;
    }
    100% {
        opacity: 1;
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
        transform-style: preserve-3d;
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


@media (min-width: 320px) {
    .container-fluid .row{
        .title {
            h1 {
                font-size: 1.5rem;
                margin-left: 0;
                width: 80%;
            }
            h2 {
                font-size: 1rem;
            }
            .btn {
                margin: 1rem 0 0 4rem;
                transform: scale(0.7);
            }
        }
    }
    .link {
        position: absolute;
        animation: 1.5s ease-in-out opacityIn;
        &-left {
            transform: translateX(-5%) scale(0.7);
            left: 0;
            top: 2%;
        }
        &-right {
            transform: translateX(5%) scale(0.7);
            right: 0;
            bottom: 2%;
        }
        &-top {
            transform-style: preserve-3d;
            transform: translateX(35%) rotateZ(-90deg) scale(0.7);
            right: 0;
            top: 12%;
        }
        &-bottom {
            transform-style: preserve-3d;
            transform: translatex(-35%) rotateZ(90deg) scale(0.7);
            left: 0;
            bottom: 14%;
        }
    }
}
@media (min-width: 576px) {
    .container-fluid .row{
        .title {
            left: 20%;
            h1 {
                font-size: 2rem;
                margin-left: 0.5rem;
                width: 100%;
            }
            h2 {
                font-size: 1.3rem;
            }
            .btn {
                margin: 2rem 0 0 15rem;
                transform: scale(0.9);
            }
        }
    }
    .link {
        &-left {
            transform: scale(0.8);
        }
        &-right {
            transform: scale(0.8);
        }
        &-top {
            transform: translateX(35%) rotateZ(-90deg) scale(0.8);
            right: 0;
            top: 12%;
        }
        &-bottom {
            transform: translatex(-35%) rotateZ(90deg) scale(0.8);
            left: 0;
            bottom: 14%;
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
                transform: scale(1);
            }
        }
    }
    .link {
        &-left {
            transform: scale(0.9);
        }
        &-right {
            transform: scale(0.9);
        }
        &-top {
            transform: translateX(25%) rotateZ(-90deg) scale(0.9);
            right: 0;
            top: 12%;
        }
        &-bottom {
            transform: translatex(-25%) rotateZ(90deg) scale(0.9);
            left: 0;
            bottom: 14%;
        }
    }
}
@media (min-width: 992px) {
    .container-fluid .row{
        .title {
            left: 24%;
            h1 {
                font-size: 3rem;
                margin-left: 1.5rem;
            }
            h2 {
                font-size: 2.2rem;
            }
            .btn {
                margin: 2rem 0 0 20rem;
            }
        }
    }
    .link {
        &-left {
            left: 3%;
            top: 4%;
        }
        &-right {
            right: 3%;
            bottom: 4%;
        }
        &-top {
            transform: translateX(25%) rotateZ(-90deg);
            right: 0;
            top: 14%;
        }
        &-bottom {
            transform: translatex(-25%) rotateZ(90deg);
            left: 0;
            bottom: 17%;
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
    .link {
        &-left {
            left: 5%;
            top: 5%;
        }
        &-right {
            right: 4%;
            bottom: 5%;
        }
        &-top {
            transform: rotateZ(-90deg);
            top: 13%;
        }
        &-bottom {
            transform: rotateZ(90deg);
            left: 0;
            bottom: 16%;
        }
    }
}
</style>

