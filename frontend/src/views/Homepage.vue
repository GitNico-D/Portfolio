<template>
    <b-container fluid>
        <b-row>
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

export default {
    name: "background",
    components: {
        HomePageLink
    }
}
</script>

<style lang="scss">

.container-fluid {
    background: no-repeat, linear-gradient(to right top, #6d327c, #485DA6, #00a1ba, #00BF98, #36C486)!important;
    width: 100vh;
    position: relative;
    .row {
        height: 100vh;
        h1 {
            font-weight: 900!important;
            color: $white!important;
            font-size: 4em!important;
            letter-spacing: 0.10em!important;
            text-shadow: 2px 3px 0px $gray-shadow;
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

