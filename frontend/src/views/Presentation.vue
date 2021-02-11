<template>
    <b-container fluid>
        <Header title="Projets" color="#6d327c"/>
        <BackgroundPage circleColor="#6d327c"/>
        <Transition v-show="showTransition" directionAnimation="left"/>
        <b-row class="back">
            <HomePageLink action="Retour" url="/" direction="animated-arrowLtr" class="link link-left" textColor="#6d327c"/>
        </b-row>
    </b-container>
</template>

<script>
export default {

}
</script>

<style>

</style>