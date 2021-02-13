<template>
    <b-container fluid>
        <Header title="Projets" color="#6d327c"/>
        <BackgroundPage circleColor="#6d327c"/>
        <Transition v-show="showTransition" directionAnimation="right"/>
        <b-alert show variant="danger">{{ error }}</b-alert>
        <b-row class="cards m-auto">
            {{info}}
            <ProjectCard title="Projet 1" content="Description projet 1" url="/" :imgSrc="require('../assets/img-test-1.jpg')" imgAlt="Image Projet 1"/>
            <ProjectCard title="Projet 2" content="Description projet 2" url="/" :imgSrc="require('../assets/img-test-2.jpg')" imgAlt="Image Projet 2"/>
            <ProjectCard title="Projet 3" content="Description projet 3" url="/" :imgSrc="require('../assets/img-test-3.jpg')" imgAlt="Image Projet 3"/>
            <ProjectCard title="Projet 4" content="Description projet 4" url="/" :imgSrc="require('../assets/img-test-1.jpg')" imgAlt="Image Projet 4"/>
            <ProjectCard title="Projet 5" content="Description projet 5" url="/" :imgSrc="require('../assets/img-test-2.jpg')" imgAlt="Image Projet 5"/>
        </b-row>
        <b-row class="back">
            <HomePageLink action="Retour" url="/" direction="animated-arrowLtr" class="link link-left" textColor="#6d327c"/>
        </b-row>
    </b-container>
</template>

<script>
import ProjectCard from '@/components/ProjectCard.vue'
import HomePageLink from '@/components/HomePageLink.vue'
import BackgroundPage from '@/components/BackgroundPage.vue'
import Header from '@/components/Header.vue'
import Transition from "@/components/Transition.vue"


export default {
    components: {
        ProjectCard,
        Header,
        BackgroundPage,
        HomePageLink,
        Transition
    },
    data() {
        return {
            showTransition: true,  
            info: null,
            error: null 
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
    }, 
    mounted() {
        this.axios.get('http://portfolio/api/projects', {
            headers: {
                'Authorization': 'Bearer' + 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MTMyMzY4NjgsImV4cCI6MTYxMzMyMzI2OCwicm9sZXMiOlsiUk9MRV9BRE1JTiIsIlJPTEVfVVNFUiJdLCJ1c2VybmFtZSI6ImFkbWluQGFkbWluLmNvbSJ9.qBKp8xcBP1SFiXthavx8YimrXibc6jFdaSBq4UVfRt6A886GW_GvR_KpnXPj-PiK1um0dOFNrty3BZV1pjdB-B1_fvsB5D2B4S6eFmtIIsDWbrG2x6UzR4voVgt9FeDv5hghGaM-44APmUAs5c28y3QGMWFfXw9tNxdN4cuKFuC2a8o3fyLV3uYPH-bSZN8F1CEzTL2kQhedFcSwxtb_m4RdfyrVLDZZhSslVRd7R9O0k-yLBzDM6DXi993JHq7Ks8C4E9JvX2838oMVIUiZttY9HvzQVwxyg3kitdzfElu6cjBDNu80KDtzH38prBOh4z-Cn1MyAZdbeblFGNbqbrgRrU0j1Q74KZ_1xavWqjt3sh7C5V6wLSj3NDPBv1HfCUK_hzIUnUsarrsapSSXZ6dlaTFVRW748FzuqtQX9SilP8faDO27W3UFXaUYdV0OzD8ITtZjKFwIDu-j_RlWzVbkAff6LWiG6BWZ5HiZ8WRfwx-FpEiUS-1TLkzEPC3oKnDHJdIFY0s_w8Qwa8rJ1brFVi556I1OO_42qW-05Hb_eD8gIN2EvdJlplgjx-3pPWAYAxm73xo-TRjDz3a8ZcxM1Xq_FWgmSswlIujRO6ujqnqmQMHkohuZeGIDHbHar9rCFE8taHRe_9DVB6irIZCQ-PiXlDQpjfm8hI6bvKk',
                "Content-Type": "application/json"
            },
        })  
        .then(response => { 
            this.info = response.data 
            console.log(response)
            })
        .catch(error => {
            this.error = error.response.data;
            console.log(error.response.data);
        });
    }
}
</script>

<style lang="scss" scoped>
.container-fluid {
    position: relative;
    background-color: $dark-gray;
    .back {
        position: relative;
        height: 10vh;
        .link {
            position: absolute;
            &-left {
                left: 70%;
                bottom: 0;
                transform: scale(0.8);
            }
        }
    }
    .cards {
        justify-content: space-around;
        height: unset;
        .cardflip {
            animation: slide-in-blurred-right 0.8s cubic-bezier(0.230, 1.000, 0.320, 1.000) both;
            &:nth-child(1) {
                animation-delay: 0.8s;
            }
            &:nth-child(2) {
                animation-delay: 1s;
            }
            &:nth-child(3) {
                animation-delay: 1.2s;
            }
            &:nth-child(4) {
                animation-delay: 1.4s;
            }
            &:nth-child(5) {
                animation-delay: 1.6s;
            }
        }
    }
    
}
@keyframes slide-in-blurred-right {
    0% {
        transform: translateX(1000px) scaleX(2.5) scaleY(0.2);
        transform-origin: 0% 50%;
        // filter: blur(20px);
        opacity: 0;
    }
    100% {
        transform: translateX(0) scaleY(1) scaleX(1);
        transform-origin: 50% 50%;
        // filter: blur(0);
        opacity: 1;
    }
}
@media (min-width: 320px) {
    .container-fluid {
        .back {
            .link {
                &-left {
                    left: 50%;
                    bottom: 0;
                    transform: translate(-50%) scale(0.8);
                }
            }
        }
        .cards {
            padding-top: 3rem;
        }
    }
}
@media (min-width: 576px) {
    .container-fluid {
        .cards {
            padding-top: 2rem;
        }
    }
}
@media (min-width: 992px) {
    .container-fluid {
        .back {
            .link {
                &-left {
                    left: 81%;
                    bottom: 0;
                    transform: scale(0.8);
                }
            }
        }
    }
}
</style>