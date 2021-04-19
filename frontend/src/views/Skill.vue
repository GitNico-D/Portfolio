<template>
  <b-container fluid>
    <Header title="Compétences" color="#36C486" />
    <BackgroundPage circleColor="#36C486" />
    <Transition v-show="showTransition" directionAnimation="up" />
    <b-row class="skill-title m-3 p-3">
      <b-button
        v-for="categories in allCategories"
        :key="categories.id"
        @click="current = categories.id"
        :class="{ current: categories.id == current }"
      >
        {{ categories.name }}
      </b-button>
    </b-row>
    <b-row
      v-for="categories in allCategories"
      :key="categories.allCategories"
      class="skill-description"
    >
      <b-col cols="12" md="7">
        <div class="skill-block" v-show="current == categories.id">
          <ProgressBarCard
            v-for="skills in categories.skills"
            :key="skills.id"
            :title="skills.name"
            :urlIcon="skills.icon"
            :value="skills.knowledge_level"
            color="#36C486"
          />
        </div>
      </b-col>
      <b-col cols="12" md="5">
        <div
          v-show="current == categories.id"
          class="software-block mt-1 ms-auto"
        >
          <h4 class="software-title">Logiciel associées</h4>
          <ProgressBarCard
            v-for="software in categories.softwares"
            :key="software.id"
            :title="software.name"
            :urlIcon="software.icon"
            :value="software.mastery_of"
            color="#36C486"
          />
        </div>
      </b-col>
    </b-row>
    <b-row class="back position-relative my-3">
      <HomePageLink
        action="Retour"
        url="/"
        direction="animated-arrowRtl"
        class="position-absolute link-bottom"
        textColor="#36C486"
      />
    </b-row>
  </b-container>
</template>

<script>
import HomePageLink from "@/components/HomePageLink.vue";
import Header from "@/components/Header.vue";
import BackgroundPage from "@/components/BackgroundPage.vue";
import ProgressBarCard from "@/components/ProgressBarCard.vue";
import Transition from "@/components/Transition.vue";
import { mapGetters, mapActions } from "vuex";

export default {
  components: {
    HomePageLink,
    Header,
    BackgroundPage,
    ProgressBarCard,
    Transition
  },
  data() {
    return {
      current: 1,
      showTransition: true
    };
  },
  methods: {
    actionTransition() {
      this.showTransition = true;
      setTimeout(() => {
        this.showTransition = false;
      }, 1300);
    },
    ...mapActions(["getAllCategories"])
  },
  computed: {
    ...mapGetters(["allCategories"])
  },
  created() {
    setTimeout(() => {
      this.showTransition = false;
    }, 1300);
  },
  mounted() {
    this.$store.dispatch("getAllCategories");
  }
};
</script>

<style lang="scss" scoped>
.container-fluid {
  background-color: $dark-gray;
  perspective: 1000px;
  position: relative;
  .back {
    height: 15vh;
  }
  .btn {
    font-family: "Oswald", sans-serif;
    color: $white;
    background: $green;
    border: none;
    transition: ease-out 0.2s;
    position: relative;
    margin: 0.5rem;
    text-decoration: none;
    &:hover {
      cursor: pointer;
      transform: scale(1.1);
    }
    &:active {
      background-color: $green !important;
      border-color: $green !important;
    }
    &:focus {
      box-shadow: 0 0 0 0.2rem $green;
    }
  }
  col {
    margin: 0;
    padding: 0;
  }
  .current {
    color: $green;
    background-color: $white;
  }
  .skill {
    &-title {
      justify-content: space-around;
      height: unset;
      animation: scale-up-center 0.4s cubic-bezier(0.39, 0.575, 0.565, 1) 0.8s
        both;
    }
    &-description {
      height: unset;
      padding-top: 2rem;
      animation: scale-up-hor-right 0.5s cubic-bezier(0.39, 0.575, 0.565, 1)
        both;
    }
    &-block {
      .card {
        animation: swing-in-top-fwd 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275)
          both;
        @for $i from 1 through 10 {
          &:nth-child(#{$i}) {
            animation-delay: $i * 0.2s;
          }
        }
      }
    }
  }
  .software {
    &-title {
      font-family: "Oswald", sans-serif;
      color: $white;
    }
    &-block {
      .card {
        animation: swing-in-top-fwd 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275)
          1s both;
        @for $i from 1 through 10 {
          &:nth-child(#{$i}) {
            animation-delay: $i * 0.2s;
          }
        }
      }
    }
  }
}
@keyframes swing-in-top-fwd {
  0% {
    transform: rotateX(-100deg);
    transform-origin: top;
    opacity: 0;
  }
  100% {
    transform: rotateX(0deg);
    transform-origin: top;
    opacity: 1;
  }
}
@keyframes scale-up-center {
  0% {
    transform: scale(0.1);
  }
  100% {
    transform: scale(1);
  }
}
@media (min-width: 320px) {
  .container-fluid {
    .btn {
      font-size: 0.9rem;
      padding: 0.5rem;
    }
    .back {
      .link {
        &-bottom {
          left: 50%;
          bottom: 50%;
          transform: translate(-50%, -50%) rotateZ(-90deg) scale(0.5);
        }
      }
    }
    .skill {
      &-title {
        flex-direction: column;
        padding-top: 3rem;
      }
    }
    .software {
      &-title {
        text-align: left;
        font-size: 0.9rem;
        margin-top: 2rem;
      }
    }
  }
}
@media (min-width: 768px) {
  .container-fluid {
    .skill {
      &-title {
        flex-direction: row;
      }
    }
    .btn {
      font-size: 0.9rem;
      padding: 1rem 5rem 1rem 5rem;
    }
    .card {
      margin-bottom: 0.5rem;
    }
    .back {
      .link {
        &-bottom {
          transform: translate(-50%, -50%) rotateZ(-90deg) scale(0.6);
        }
      }
    }
    .software {
      &-title {
        text-align: right;
        font-size: 1rem;
        margin-top: 2rem;
      }
    }
  }
}
@media (min-width: 992px) {
  .container-fluid {
    .back {
      .link {
        &-bottom {
          transform: translate(-50%, -50%) rotateZ(-90deg) scale(0.8);
        }
      }
    }
    .skill {
      &-description {
        align-items: center;
        width: 90%;
        margin: auto;
      }
    }
    .btn {
      font-size: 1.2rem;
      padding: 1rem 5rem 1rem 5rem;
    }
    .software {
      &-title {
        text-align: right;
      }
    }
  }
}
@media (min-width: 1200px) {
  .container-fluid {
    .btn {
      font-size: 1.5rem;
      padding: 1rem 5rem 1rem 5rem;
    }
  }
}
</style>
