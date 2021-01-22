<template>
    <b-container fluid>
        <Header title="Compétences" linkColor="white" actionColorLink="#6d327c" spanColor="#6d327c" textColor="#6d327c"/>
        <BackgroundPage circleColor="#6d327c"/>
        <b-row class="cards">
            <ProjectCard title="Projet 1" content="Description projet 1" :style="[this.transformUnset ? { transform: 'unset' } : { transform: 'translateX(330%)' }]"/>
            <ProjectCard title="Projet 2" content="Description projet 2" :style="[this.transformUnset ? { transform: 'unset' } : { transform: 'translateX(330%)' }]"/>
            <ProjectCard title="Projet 3" content="Description projet 3" :style="[this.transformUnset ? { transform: 'unset' } : { transform: 'translateX(330%)' }]"/>
            <ProjectCard title="Projet 4" content="Description projet 4" :style="[this.transformUnset ? { transform: 'unset' } : { transform: 'translateX(330%)' }]"/>
            <ProjectCard title="Projet 5" content="Description projet 5" :style="[this.transformUnset ? { transform: 'unset' } : { transform: 'translateX(330%)' }]"/>
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

export default {
    components: {
        ProjectCard,
        Header,
        BackgroundPage,
        HomePageLink
    },
    data() {
        return {
            transformUnset: Boolean
        }
    },
    beforeCreate() {
        this.transformUnset = false;
    },
    mounted() {
        this.transformUnset = true;
    },
}
</script>

<style lang="scss" scoped>
.container-fluid {
    position: relative;
    background-color: $dark-gray;
    .link {
        position: absolute;
        &-left {
            left: 85%;
            top: 95%;
            transform: scale(0.8);
        }
    }
    .header {
        align-items: center;        
        height: 10vh;
        margin: 2rem 0 0 0;
    }
    .nav {
        position: absolute;
        top: 0;
        left: 5rem;
    }
    .cards {
        justify-content: space-around; 
        align-items: stretch;
        width: 90%;
        margin: auto;
        padding: 4rem 0 2rem 0;
        height: unset;
        .cardflip {
            animation: slide-in-blurred-right 0.8s cubic-bezier(0.230, 1.000, 0.320, 1.000) both;
            &:nth-child(1) {
                animation-delay: 0.3s;
            }
            &:nth-child(2) {
                animation-delay: 0.6s;
            }
            &:nth-child(3) {
                animation-delay: 0.9s;
            }
            &:nth-child(4) {
                animation-delay: 1.2s;
            }
            &:nth-child(5) {
                animation-delay: 1.5s;
            }
        }
    }
    .back {
        height: 10vh;
    }
}
@keyframes slide-in-blurred-right {
    0% {
        transform: translateX(1000px) scaleX(2.5) scaleY(0.2);
        transform-origin: 0% 50%;
        filter: blur(40px);
        opacity: 0;
    }
    100% {
        transform: translateX(0) scaleY(1) scaleX(1);
        transform-origin: 50% 50%;
        filter: blur(0);
        opacity: 1;
    }
}
</style>