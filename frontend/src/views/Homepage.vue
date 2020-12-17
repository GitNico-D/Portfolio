<template>
    <b-container fluid class="background">
        <div class="d-flex title">
            <h1 class="title-h1">
                BIENVENUE SUR MON PORTFOLIO !
            </h1>            
        </div>
        <ButtonLink action="Mes Projets" class="bottomButtonPosition"/>
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
.background {
    background: no-repeat, linear-gradient(to right top, #6d327c, #485DA6, #00a1ba, #00BF98, #36C486)!important;
}
.title {
    min-height: 100vh;
    &-h1 {
        font-weight: 900!important;
        color: #fff!important;
        font-size: 4em!important;
        letter-spacing: 0.10em!important;
        text-shadow: 2px 3px 0px #898999;
        width: 80%;
        margin: auto;
    }
}
.bottomButtonPosition {
    
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translate(-50%, -50%);
}
.upButtonPosition {
    position: absolute;
    top: 0;
    left: 50%;
    transform: translate(-50%, 50%);
}
</style>

