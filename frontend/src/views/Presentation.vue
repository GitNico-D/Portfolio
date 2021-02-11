<template>
    <b-container fluid>
        <Header title="Presentation" color="#485DA6"/>
        <BackgroundPage circleColor="#485DA6"/>
        <Transition v-show="showTransition" directionAnimation="left"/>
        <b-row class="bottom">
            <HomePageLink action="Retour" url="/" direction="animated-arrowRtl" class="link link-bottom" textColor="#00a1ba"/>
        </b-row> 
    </b-container>
</template>

<script>
import BackgroundPage from '@/components/BackgroundPage.vue'
import Header from '@/components/Header.vue'
import HomePageLink from '@/components/HomePageLink.vue'
import Transition from "@/components/Transition.vue"

export default {
    components: {
        BackgroundPage,
        Header,
        HomePageLink,
        Transition
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

<style>

</style>