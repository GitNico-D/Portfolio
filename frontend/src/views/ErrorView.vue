<template>
  <b-container fluid>
    <Header title="Erreur" color="#6d327c" />
    <BackgroundPage circleColor="#00a1ba" />
    <b-row>
      <Error
        :code="this.$route.params.errorStatus"
        :message="lastErrorMessage"
      />
      <HomePageLink
        action="Retour"
        url="/"
        direction="animated-arrowLtr"
        class="link jumbotron-link"
        textColor="#00a1ba"
      />
    </b-row>
  </b-container>
</template>

<script>
import HomePageLink from "@/components/HomePageLink.vue";
import BackgroundPage from "@/components/BackgroundPage.vue";
import Header from "@/components/Header.vue";
import Error from "@/components/Error.vue";
import { mapGetters } from "vuex";

export default {
  components: {
    HomePageLink,
    BackgroundPage,
    Header,
    Error
  },
  computed: {
    ...mapGetters(["lastErrorMessage"])
  }
};
</script>

<style lang="scss" scoped>
.row {
  position: relative;
  .jumbotron {
    background: url("../assets/404-error.png") center no-repeat;
    width: 80%;
    &-link {
      bottom: 30%;
      left: 50%;
      transform: translate(-50%);
    }
  }
}
</style>
