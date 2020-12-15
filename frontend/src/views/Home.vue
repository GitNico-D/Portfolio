<template>
  <b-container fluid class="background">
      <Background msg="Bienvenue !!" class="bgcolor" />
      <BottomHomeButton action="Mes Projets" class="bottomButtonPosition"/>
      <UpHomeButton action="Expérience Professionnelle" class="upButtonPosition" />
  </b-container>
</template>

<script>
import Background from "@/components/Background.vue"
import BottomHomeButton from "@/components/BottomHomeButton.vue"
import UpHomeButton from "@/components/UpHomeButton.vue"

export default {
    name: "background",
    components: {
      Background,
      BottomHomeButton,
      UpHomeButton
    }
}
</script>

<style lang="scss">
.background {
  position: relative;
  background: rgb(255,126,33);
  background: linear-gradient(90deg, rgba(255,166,102,1) 0%, rgba(254,225,127,1) 53%, rgba(201,123,252,1) 100%);
  padding: 25rem;
  margin-top: 5rem;
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

