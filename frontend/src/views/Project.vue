/* eslint-disable */
<template>
  <b-container fluid>
    <Header title="Projets" color="#6d327c" />
    <BackgroundPage circleColor="#6d327c" />
    <Transition v-show="showTransition" directionAnimation="right" />
    <b-row class="cards m-auto">
      <ProjectCard
        v-for="project in allProjects"
        :key="project.id"
        :title="project.name"
        :content="project.description"
        :url="project.url"
        :imgSrc="project.imgStatic"
        :imgAlt="project.altStatic"
        :date="project.creationDate"
      />
    </b-row>
    <b-row class="back position-relative">
      <HomePageLink
        action="Retour"
        url="/"
        direction="animated-arrowLtr"
        class="position-absolute link link-left"
        textColor="#6d327c"
      />
    </b-row>
  </b-container>
</template>

<script>
import ProjectCard from "@/components/ProjectCard.vue";
import HomePageLink from "@/components/HomePageLink.vue";
import BackgroundPage from "@/components/BackgroundPage.vue";
import Header from "@/components/Header.vue";
import Transition from "@/components/Transition.vue";
import { mapGetters, mapActions } from "vuex";

export default {
  components: {
    ProjectCard,
    Header,
    BackgroundPage,
    HomePageLink,
    Transition
  },
  data() {
    return {
      showTransition: true
    };
  },
  methods: {
    // Hide or show slider transition
    actionTransition() {
      this.showTransition = true;
      setTimeout(() => {
        this.showTransition = false;
      }, 1300);
    },
    ...mapActions(["getAllProjects"])
  },
  computed: {
    ...mapGetters(["allProjects"])
  },
  beforeCreate() {
    // Hide slider transition after created
    setTimeout(() => {
      this.showTransition = false;
    }, 1300);
  },
  mounted() {
    // Dispatch all projets contains in the vuex state.projects
    this.$store.dispatch("getAllProjects");
  }
};
</script>

<style lang="scss" scoped>
.container-fluid {
  position: relative;
  background-color: $dark-gray;
  perspective: 1000px;
  min-height: 100vh;
  .back {
    height: 15vh;
  }
  .cards {
    justify-content: space-around;
    height: unset;
    .cardflip {
      animation: slide-in-blurred-right 0.8s cubic-bezier(0.23, 1, 0.32, 1) both;
      &:nth-child(1) {
        animation-delay: 0.8s;
      }
      &:nth-child(2) {
        animation-delay: 1s;
      }
      &:nth-child(3) {
        animation-delay: 1.2s;
      }
      &:nth-child(4) {
        animation-delay: 1.4s;
      }
      &:nth-child(5) {
        animation-delay: 1.6s;
      }
    }
  }
}
@keyframes slide-in-blurred-right {
  0% {
    transform: translateX(1000px) scaleX(2.5) scaleY(0.2);
    transform-origin: 0% 50%;
    opacity: 0;
  }
  100% {
    transform: translateX(0) scaleY(1) scaleX(1);
    transform-origin: 50% 50%;
    opacity: 1;
  }
}
@media (min-width: 320px) {
  .container-fluid {
    .back {
      .link {
        &-left {
          left: 50%;
          bottom: 50%;
          transform: translate(-50%, 0) scale(0.8);
        }
      }
    }
    .cards {
      padding-top: 3rem;
    }
  }
}
@media (min-width: 576px) {
  .container-fluid {
    .cards {
      padding-top: 2rem;
    }
  }
}
@media (min-width: 768px) {
  .container-fluid {
    .back {
      .link {
        &-left {
          transform: translate(-50%, 0) scale(1);
        }
      }
    }
  }
}
</style>
