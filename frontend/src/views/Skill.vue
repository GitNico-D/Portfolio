<template>
    <b-container fluid>
        <Header title="Compétences" color="#36C486"/>
        <BackgroundPage circleColor="#36C486"/>
        <Transition v-show="showTransition" directionAnimation="up"/>
            <b-row class="skill-title m-3 p-3">
                <b-button v-for="(name, i) in skillsName" :key="i" @click="current = i" :class="{current:i == current}">
                    {{ name }}
                </b-button>
            </b-row>
            <b-row class="skill-description">
                <b-col cols="12" md="7">
                    <div v-show="this.current == 0" class="">
                        <ProgressBarCard title="DÉV 1" :value=60 color="#36C486"/>
                        <ProgressBarCard title="DÉV 2" :value=80 color="white"/>
                        <ProgressBarCard title="DÉV 3" :value=50 color="white"/>
                        <ProgressBarCard title="DÉV 4" :value=50 color="white"/>
                        <ProgressBarCard title="DÉV 5" :value=50 color="white"/>
                    </div>
                    <div v-show="this.current == 1" class="">
                        <ProgressBarCard title="VIDEO 1" :value=80 color="white"/>
                        <ProgressBarCard title="VIDEO 2" :value=80 color="white"/>
                        <ProgressBarCard title="VIDEO 3" :value=50 color="white"/>
                        <ProgressBarCard title="VIDEO 4" :value=50 color="white"/>
                        <ProgressBarCard title="VIDEO 5" :value=50 color="white"/>
                    </div>
                    <div v-show="this.current == 2" class="">
                        <ProgressBarCard title="SON 1" :value=80 color="white"/>
                        <ProgressBarCard title="SON 2" :value=80 color="white"/>
                        <ProgressBarCard title="SON 3" :value=50 color="white"/>
                        <ProgressBarCard title="SON 4" :value=50 color="white"/>
                        <ProgressBarCard title="SON 5" :value=50 color="white"/>
                    </div>
                </b-col>
                <b-col cols="12" md="5">
                    <h2>Logiciel associées</h2>
                    <div v-show="this.current == 0" class=" mt-1 ms-auto">
                        <ProgressBarCard title="Logiciel Dév 1" value=80 color="white"/>
                        <ProgressBarCard title="Logiciel Dév 2" value=80 color="white"/>
                        <ProgressBarCard title="Logiciel Dév 3" value=50 color="white"/>
                    </div>
                    <div v-show="this.current == 1" class=" mt-1 ms-auto">
                        <ProgressBarCard title="Logiciel vidéo 1" value=60 color="white"/>
                        <ProgressBarCard title="Logiciel vidéo 2" value=40 color="white"/>
                        <ProgressBarCard title="Logiciel vidéo 3" value=80 color="white"/>
                    </div>
                    <div v-show="this.current == 2" class=" mt-1 ms-auto">
                        <ProgressBarCard title="Logiciel son 1" value=80 color="white"/>
                        <ProgressBarCard title="Logiciel son 2" value=80 color="white"/>
                        <ProgressBarCard title="Logiciel son 3" value=50 color="white"/>
                    </div>
                </b-col> 
            </b-row>
        <b-row class="back my-3">
            <HomePageLink action="Retour" url="/" direction="animated-arrowRtl" class="link link-bottom" textColor="#36C486"/>
        </b-row>
    </b-container>
</template>

<script>
import HomePageLink from '@/components/HomePageLink.vue'
import Header from '@/components/Header.vue'
import BackgroundPage from '@/components/BackgroundPage.vue'
import ProgressBarCard from '@/components/ProgressBarCard.vue'
import Transition from '@/components/Transition.vue'

export default {
    components: {
        HomePageLink,
        Header,
        BackgroundPage,
        ProgressBarCard,
        Transition
    },
    data() {
        return {
            current: 0,
            skillsName:["Développement Web", "Vidéo", "Son"],
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
.container-fluid {
    col {
        margin: 0;
        padding: 0;
    }
    .btn {
        font-family: "Oswald", "sans-serif";
        color: $white;
        background: $green;
        border: none;
        transition: ease-out 0.2s;
        position: relative;
        margin: 0.5rem;
        text-decoration: none;
        &:hover {
            cursor: pointer;
            transform: scale(1.1);
        }
        &:active {
            background-color: $green!important;
            border-color: $green!important;
        }
        &:focus {
            box-shadow: 0 0 0 0.2rem $green;
        }   
    }
    .current {
        color: $green;
        background-color: $white;
    }
    .back {
        position: relative;
        height: 15vh;
        .link {
            position: absolute;
            &-bottom {
                left: 2%;
                bottom: 0;
                transform: scale(0.8);
            }
        }
    }
    .skill {
        &-title {
            justify-content: space-around;
            height: unset;
        }
        &-description {
            height: unset;
            padding-top: 2rem;
            animation: scale-up-hor-right 0.5s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;
        }
    }
}
@keyframes opacity-in {
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
@media (min-width: 320px) {
    .container-fluid {
        .skill {
            &-title {
                flex-direction: column;
                padding-top: 3rem;
            }
        }
        .btn {
            font-size: 0.9rem;
            padding: 0.5rem;
        }
        .back {
            .link {
                &-bottom {
                    left: 50%;
                    bottom: 40%;
                    transform: translateX(-50%) rotateZ(-90deg) scale(0.5);
                }
            }
        }
    }
}
@media (min-width: 768px) {
    .container-fluid {
        .skill {
            &-title {
                flex-direction: row;
            }
        }
        .btn {
            font-size: 0.9rem;
            padding: 1rem 5rem 1rem 5rem;
        }
        .back {
            .link {
                &-bottom {
                    left: 5%;
                    bottom: 40%;
                    transform: translateX(-50%) rotateZ(-90deg) scale(0.6);
                }
            }
        }
    }
}
@media (min-width: 992px) {
    .container-fluid {
        .back {
            .link {
                &-bottom {
                    left: 5%;
                    bottom: 40%;
                    transform: translateX(-50%) rotateZ(-90deg) scale(0.8);
                }
            }
        }
        .skill {
            &-description {
                align-items: center;
                width: 90%;
                margin: auto;
            }
        }
        .btn {
            font-size: 1.2rem;
            padding: 1rem 5rem 1rem 5rem;
        }
    }
}
@media (min-width: 1200px) {
    .container-fluid {
        .btn {
            font-size: 1.5rem;
            padding: 1rem 5rem 1rem 5rem;
        }
        .back {
            height: 15vh;
            .link {
                &-bottom {
                    left: 5%;
                    bottom: 45%;
                    transform: translateX(-50%) rotateZ(-90deg) scale(1);
                }
            }
        }
    }
}
</style>