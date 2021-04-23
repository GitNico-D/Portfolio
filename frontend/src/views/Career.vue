<template>
  <b-container fluid>
    <Header title="Parcours" color="#00a1ba" class="header" />
    <BackgroundPage circleColor="#00a1ba" />
    <Transition v-show="showTransition" directionAnimation="down" />
    <CareerStage
      v-for="(careerStage, index) in allCareerStages"
      :key="careerStage.id"
      :title="careerStage.name"
      :description="careerStage.description"
      :company="careerStage.company"
      :logo="careerStage.logoCompany"
      :startDate="careerStage.startDate"
      :endDate="careerStage.endDate"
      color="#00a1ba"
      :parity="index % 2 ? (parity = 'even') : (parity = 'odd')"
    />
    <b-row class="position-relative bottom">
      <HomePageLink
        action="Retour"
        url="/"
        direction="animated-arrowRtl"
        class="position-absolute link link-bottom"
        textColor="#00a1ba"
      />
    </b-row>
    <div class="line"></div>
  </b-container>
</template>

<script>
import HomePageLink from "@/components/HomePageLink.vue";
import BackgroundPage from "@/components/BackgroundPage.vue";
import Header from "@/components/Header.vue";
import CareerStage from "@/components/CareerStage.vue";
import Transition from "@/components/Transition.vue";
import { mapGetters, mapActions } from "vuex";

export default {
  components: {
    HomePageLink,
    BackgroundPage,
    Header,
    CareerStage,
    Transition
  },
  data() {
    return {
      showTransition: true
    };
  },
  methods: {
    // Start transition effect and hide it after 1.3s
    actionTransition() {
      this.showTransition = true;
      setTimeout(() => {
        this.showTransition = false;
      }, 1300);
    },
    ...mapActions(["getAllCareerStage"])
  },
  computed: {
    ...mapGetters(["allCareerStages"])
  },
  created() {
    setTimeout(() => {
      this.showTransition = false;
    }, 1300);
  },
  //Dispatch all career stage contains in career vuex module
  mounted() {
    this.$store.dispatch("getAllCareerStage");
  },
  updated() {
    this.getAllCareerStage();
  },
};
</script>

<style lang="scss" scoped>
.container-fluid {
  background-color: $dark-gray;
  position: relative;
  perspective: 1000px;
  min-height: 100vh
}
.bottom {
  height: 15vh;
}
.even,
.odd {
  margin-bottom: 8rem;
}
.header {
  padding-bottom: 5rem;
}
.line {
  position: absolute;
  height: 70%;
  width: 3px;
  left: 50%;
  top: 14%;
  background-color: $white;
  transform: translateZ(-10px);
  animation: scale-up-ver-top 2s cubic-bezier(0.39, 0.575, 0.565, 1) 0.5s both;
  z-index: -1;
}
@keyframes scale-up-ver-top {
  0% {
    transform: scaleY(0);
    transform-origin: 100% 0%;
    background-color: $light-blue;
  }
  100% {
    transform: scaleY(1);
    transform-origin: 100% 0%;
    background-color: $white;
  }
}
@media (min-width: 320px) {
  .container-fluid {
    .line {
      display: none;
    }
    .link {
      &-bottom {
        bottom: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(90deg) scale(0.6);
      }
    }
  }
}
@media (min-width: 768px) {
  .container-fluid {
    .line {
      display: initial;
      height: 75%;
      top: 12%;
    }
    .link {
      &-bottom {
        transform: translate(-50%, -50%) rotate(90deg) scale(0.8);
      }
    }
  }
}
</style>
