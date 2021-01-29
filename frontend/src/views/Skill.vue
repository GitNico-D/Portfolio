<template>
    <b-container fluid>
        <Header title="Compétences" linkColor="white" actionColorLink="#36C486" spanColor="#36C486" textColor="#36C486"/>
        <BackgroundPage circleColor="#36C486"/>
            <b-row class="skill-title">
                <b-button v-for="(name, i) in skillsName" :key="i" @click="current = i" :class="{current:i == current}">
                    {{ name }}
                </b-button>
            </b-row>
            <b-row class="skill-description">
                <b-col col lg="8" sm="12">
                    <b-row v-show="this.current == 0" class="skill-description-development mt-1 ms-auto">
                        <ProgressBarCard title="DÉV 1" value=80 color="white"/>
                        <ProgressBarCard title="DÉV 2" value=80 color="white"/>
                        <ProgressBarCard title="DÉV 3" value=50 color="white"/>
                        <ProgressBarCard title="DÉV 4" value=45 color="white"/>
                        <ProgressBarCard title="DÉV 5" value=50 color="white"/>
                    </b-row>
                    <b-row v-show="this.current == 1" class="skill-description-video">
                        <ProgressBarCard title="VIDEO 1" value=80 color="white"/>
                        <ProgressBarCard title="VIDEO 2" value=80 color="white"/>
                        <ProgressBarCard title="VIDEO 3" value=50 color="white"/>
                        <ProgressBarCard title="VIDEO 4" value=45 color="white"/>
                        <ProgressBarCard title="VIDEO 5" value=50 color="white"/>
                    </b-row>
                    <b-row v-show="this.current == 2" class="skill-description-sound">
                        <ProgressBarCard title="SON 1" value=80 color="white"/>
                        <ProgressBarCard title="SON 2" value=80 color="white"/>
                        <ProgressBarCard title="SON 3" value=50 color="white"/>
                        <ProgressBarCard title="SON 4" value=45 color="white"/>
                        </b-row>
                </b-col>
                <b-col col lg="4" sm="12">
                    <h2>Logiciel associées</h2>
                    <div v-show="this.current == 0">
                        <ProgressBarCard title="Logiciel Dév 1" value=80 color="white"/>
                        <ProgressBarCard title="Logiciel Dév 2" value=80 color="white"/>
                        <ProgressBarCard title="Logiciel Dév 3" value=50 color="white"/>
                    </div>
                    <div v-show="this.current == 1">
                        <ProgressBarCard title="Logiciel vidéo 1" value=60 color="white"/>
                        <ProgressBarCard title="Logiciel vidéo 2" value=40 color="white"/>
                        <ProgressBarCard title="Logiciel vidéo 3" value=80 color="white"/>
                    </div>
                    <div v-show="this.current == 2">
                        <ProgressBarCard title="Logiciel son 1" value=80 color="white"/>
                        <ProgressBarCard title="Logiciel son 2" value=80 color="white"/>
                        <ProgressBarCard title="Logiciel son 3" value=50 color="white"/>
                    </div>
                </b-col> 
            </b-row>
        <b-row class="bottom">
            <HomePageLink action="Retour" url="/" direction="animated-arrowRtl" class="link link-bottom" textColor="#36C486"/>
        </b-row>
    </b-container>
</template>

<script>
import HomePageLink from '@/components/HomePageLink.vue'
import Header from '@/components/Header.vue'
import BackgroundPage from '@/components/BackgroundPage.vue'
import ProgressBarCard from '@/components/ProgressBarCard.vue'

export default {
    components: {
        HomePageLink,
        Header,
        BackgroundPage,
        ProgressBarCard
    },
    data() {
        return {
            current: 0,
            skillsName:["Développement Web", "Vidéo", "Son"]
        }
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
        font-size: 1.5rem;
        color: $white;
        background: $green;
        border: none;
        transition: ease-out 0.2s;
        position: relative;
        padding: 1rem 5rem 1rem 5rem;
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
    }
    .current {
        color: $green;
        background-color: $white;
    }
    .bottom {
        position: relative;
        height: 16vh;
        .link {
            position: absolute;
            &-bottom {
                transform: rotateZ(-90deg) scale(0.8);
                left: 2%;
                top: 5%;
            }
        }
    }
    .skill {
        &-title {
            justify-content: space-around;
            height: unset;
            margin: 1rem;
            padding: 1rem;
        }
        &-description {
            height: 10vh;
            margin: 1rem;
            padding: 1rem;
            height: 80vh;
            justify-content: space-around;
            animation: scale-up-hor-right 0.5s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;
            &-development, &-video, &-sound {
                height: 50vh;
                width: 100%;
                margin: auto;
            }
        }
    }
    .skillBlock {
        justify-content: center;
        align-items: center;
        flex-direction: column;
        
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
            }
            &-description {
                display: block;
            }
        }
        .btn {
            font-size: 0.9rem;
        }
        .bottom {
            .link {
                &-bottom {
                    left: 55%;
                    bottom: 0;
                    transform: translateX(-50%) rotateZ(-90deg) scale(0.6);
                }
            }
        }
    }
}
@media (min-width: 576px) {
}
@media (min-width: 768px) {
    .container-fluid {
        .skill {
            &-title {
                flex-direction: row;
            }
        }
    }
}
@media (min-width: 992px) {
    .container-fluid {
        .back {
            .link {
                &-left {
                    left: 85%;
                    bottom: 0;
                    transform: scale(0.8);
                }
            }
        }
    }
}
</style>