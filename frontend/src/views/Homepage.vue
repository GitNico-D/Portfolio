<template>
    <b-container fluid>
        <b-row>
            <h1>
                BIENVENUE SUR MON PORTFOLIO !
            </h1>    
        </b-row>
        <ButtonLink action="Projets" class="position bottomButton"/>
        <ButtonLink action="Expériences" class="position upButton"/>
    </b-container>
</template>

<script>
import ButtonLink from "@/components/ButtonLink.vue"

export default {
    name: "background",
    components: {
        ButtonLink
    }
}
</script>

<style lang="scss">
@import "@/styles/scss/_variables.scss";

.container-fluid {
    background: no-repeat, linear-gradient(to right top, #6d327c, #485DA6, #00a1ba, #00BF98, #36C486)!important;
    width: 100vh;
    .row {
        height: 100vh;
        h1 {
            font-weight: 900!important;
            color: $white!important;
            font-size: 4em!important;
            letter-spacing: 0.10em!important;
            text-shadow: 2px 3px 0px $gray-shadow;
            width: 80%;
            margin: auto;
        }
    }
}
.position {
    position: absolute;
    left: 50%;
    &.upButton {
        top: 0;
        transform: translate(-50%, 50%);
    }
    &.bottomButton {
        bottom: 0;
        transform: translate(-50%, -50%);
    }
}
</style>

