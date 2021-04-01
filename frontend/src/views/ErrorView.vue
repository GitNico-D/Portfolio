<template>
  <b-container fluid>
    <Header title="Erreur" color="#6d327c" />
    <BackgroundPage circleColor="#00a1ba" />
    <b-jumbotron
      :header="'Une erreur ' + this.$route.params.errorStatus + ' est survenue'"
      class="text-center m-auto"
    >
      <hr />
      <h4>{{ lastErrorMessage }}</h4>
    </b-jumbotron>
    <HomePageLink
      action="Retour"
      url="/"
      direction="animated-arrowLtr"
      class="link jumbotron-link"
      textColor="#00a1ba"
    />
  </b-container>
</template>

<script>
import HomePageLink from "@/components/HomePageLink.vue";
import BackgroundPage from "@/components/BackgroundPage.vue";
import Header from "@/components/Header.vue";
import { mapGetters } from "vuex";

export default {
  components: {
    HomePageLink,
    BackgroundPage,
    Header
  },
  computed: {
    ...mapGetters(["lastErrorMessage"])
  }
};
</script>

<style lang="scss" scoped>
.container-fluid {
  background-color: $dark-gray;
  position: relative;
  perspective: 1000px;
  min-height: 100vh;
}
  .jumbotron {
    position: relative;
    // background: url("../assets/404-error.png") center no-repeat;
    font-family: "MontSerrat", sans-serif;
    color: white;
    border: none;
    background-color: transparent !important;
    width: 80%;
}


@media (min-width: 320px) {
  .container-fluid {
    .jumbotron {
      .display-3 {
        font-size: 2.5rem;
      }
    }
  }
}
@media (min-width: 576px) {
  .container-fluid {
    .jumbotron {
      .display-3 {
        font-size: 4.5rem;
      }
    }
  }
}
</style>
