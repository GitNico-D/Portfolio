<template>
    <b-container fluid class="background">
        <div class="title">
            <h1>
                BIENVENUE !
            </h1>            
        </div>
        <BottomHomeButton action="Mes Projets" class="bottomButtonPosition"/>
        <UpHomeButton action="Expérience Professionnelle" class="upButtonPosition" />
    </b-container>
</template>

<script>
import BottomHomeButton from "@/components/BottomHomeButton.vue"
import UpHomeButton from "@/components/UpHomeButton.vue"

export default {
    name: "background",
    components: {
        BottomHomeButton,
        UpHomeButton
    }
}
</script>

<style lang="scss">
// .curvedBackground {
    // svg {
        // display: block;
    // }
    // &-lower {
        // position: relative;
        // background: rgb(255,126,33);
        // background: linear-gradient(90deg, rgba(255,166,102,1) 0%, rgba(254,225,127,1) 53%, rgba(201,123,252,1) 100%);
        // border-radius: 50%/0 0 150px 30px;
        // border-bottom: 2px solid black;
        // overflow: hidden;
        // padding: 25rem;
    // }
    // &-upper {
        // position: relative;
        // background: rgb(255,126,33);
        // background: #fff;
        // border-radius: 50%/0 0 150px 30px;
        // border-bottom: 2px solid black;
        // padding: 25rem;
    // }
// }
.title {
    height: 1040px;
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

