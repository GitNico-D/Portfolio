<template>
  <b-container fluid>
    <Header :color="pageColor" class="header" :title="sectionSelected"/>
    <BackgroundPage :circleColor="pageColor" />
    <Transition v-show="showTransition" directionAnimation="down" />
    <AdminPresentation v-show="showOverview" />
    <SidebarAdmin 
      v-on:showProjectForm="showProjectForm"
      v-on:showCareerForm="showCareerForm"
      v-on:returnToOverview="returnToOverview"
      />
    <AllProjectForm v-show="displayProjectForm"/>
    <CareerForm v-show="displayCareerForm"/>
    <h2 class="text-center text-white mb-4 text-uppercase font-weight-bold" v-show="showOverview">Aperçu</h2>
      <b-row>
        <b-card-group deck v-show="showOverview" class="p-4 rounded flex-wrap">
          <b-card class="card-project">
            <b-card-title class="text-uppercase font-weight-bold">Projets</b-card-title>
            <hr>
            <font-awesome-icon icon="laptop-code" size="9x" class="py-2"/>
            <hr>
            <b-card-text class="my-4">
              Il y a un total de <span class="text-justify font-weight-bold">{{allProjects.length}}</span> projets présent sur le site.
              <hr>
              <p class="text-left"><u><i>Dernier projet ajouté</i></u> :
                <b-card title="projectName" sub-title="projectCreatedAt" class="mt-3"></b-card>
              </p>
              <p class="text-left"><u><i>Dernier projet modifié</i></u> :
                <b-card title="projectName" sub-title="projectUpdatedAt" class="mt-3"> </b-card>
              </p>
            </b-card-text>
            <template #footer>
            </template>
          </b-card>
          <b-card class="card-skill">
            <b-card-title class="text-uppercase font-weight-bold">Compétences</b-card-title>
            <hr>
            <font-awesome-icon icon="chart-pie" size="9x" class="py-2"/>
            <hr>
            <b-card-text class="my-4">
              Il y a un total de <span class="text-justify font-weight-bold">allSkills</span> 
              compétences répartie dans 
              <span class="text-justify font-weight-bold">allCategories</span> 
              catégories.
              <hr>
              <p class="text-left"><u><i>Dernière compétence ajoutée</i></u> :
                <b-card title="skillName" sub-title="skillCreatedAt" class="mt-3"></b-card>
              </p>
              <p class="text-left"><u><i>Dernière compétence modifiée</i></u> :
                <b-card title="skillName" sub-title="skillUpdatedAt" class="mt-3"> </b-card>
              </p>
            </b-card-text>
            <template #footer>
            </template>
          </b-card>
          <b-card class="card-career">
            <b-card-title class="text-uppercase font-weight-bold">Carrières</b-card-title>
            <hr>
            <font-awesome-icon icon="laptop-code" size="9x" class="py-2"/>
            <hr>
            <b-card-text class="my-4">
              Il y a un total de 
              <span class="font-weight-bold">allCareers</span>
              étapes de carrières ajoutées sur le site.
              <hr>
              <p class="text-left"><u><i>Dernière étape de carrière ajoutée</i></u> :
                <b-card title="careerName" sub-title="careerCreatedAt" class="mt-3"></b-card>
              </p>
              <p class="text-left"><u><i>Dernière étape de carrière modifiée</i></u> :
                <b-card title="careerName" sub-title="careerUpdatedAt" class="mt-3"> </b-card>
              </p>
            </b-card-text>
            <template #footer>
            </template>
          </b-card>
          <b-card class="card-presentation">
            <b-card-title class="text-uppercase font-weight-bold">Présentation</b-card-title>
            <hr>
            <font-awesome-icon icon="address-book" size="9x" class="py-2"/>
            <hr>
            <b-card-text class="my-4">
              Il y a 
              <span class="font-weight-bold">presentation</span>
              présentation.
              <hr>
              <div class="d-flex flex-column text-left">
                <p><u><i>Date d'ajout </i></u>: 
                  <span class="font-weight-bold">presentationCreatedAt</span>
                </p>
                <p><u><i>Dernière modification </i></u>: 
                  <span class="font-weight-bold">presentationUpdatedAt</span>
                </p>
              </div>
            </b-card-text>
            <template #footer>
            </template>
          </b-card>
        </b-card-group>
    </b-row>
    <b-row class="footer justify-content-center align-items-center">
      <HomePageLink action="Retour"
        url="/"
        direction="animated-arrowLtr"
        :textColor="pageColor"/>
    </b-row>
  </b-container>
</template>

<script>
import Header from "@/components/Header.vue";
import BackgroundPage from "@/components/BackgroundPage.vue";
import Transition from "@/components/Transition.vue";
import SidebarAdmin from "@/components/admin/SidebarAdmin.vue";
import AdminPresentation from "@/components/admin/AdminPresentation.vue";
import AllProjectForm from "@/components/form/AllProjectForm.vue";
import CareerForm from "@/components/admin/CareerForm.vue";
import HomePageLink from "@/components/HomePageLink.vue";
import { mapGetters } from "vuex";
import jwt_decode from "jwt-decode";

export default {
  components: {
    Header,
    BackgroundPage,
    Transition,
    SidebarAdmin,
    HomePageLink,
    AdminPresentation,
    CareerForm,
    AllProjectForm

  },
  data() {
    return {
      pageColor: "#BE8C2E",
      displayProjectForm: false,
      displayCareerForm: false,
      displayPresentationForm: false,
      displaySkillForm: false,
      showOverview: true,
      sectionSelected: 'Tableau de bord',
      showTransition: true
    }
  },
  computed: {
    loggedIn() {
      return this.$store.state.auth.status.loggedIn;
    },
    ...mapGetters(["allProjects"])
  },
  methods: {
    dateDiff(date1, date2) {
      var diff = {};
      var tmp = date2 - date1;
      tmp = Math.floor(tmp / 1000);
      diff.sec = tmp % 60;
      tmp = Math.floor((tmp - diff.sec) / 60);
      diff.min = tmp % 60;
      tmp = Math.floor((tmp - diff.min) / 60);
      diff.hour = tmp % 24;
      tmp = Math.floor((tmp - diff.hour) / 24);
      diff.day = tmp;
      return diff;
    },
    returnToOverview: function(color) {
      this.pageColor = color;
      this.displayProjectForm = false;
      this.displayCareerForm = false;
      this.displayPresentationForm = false;
      this.displaySkillForm = false;
      this.showOverview = true;
      this.sectionSelected = "Tableau de bord"
    },
    showProjectForm: function(color) {
      this.pageColor = color;
      this.displayProjectForm = true;
      this.displayCareerForm = false;
      this.displayPresentationForm = false;
      this.displaySkillForm = false;
      this.showOverview = false;
      this.sectionSelected = "Section projet"
    },
    showCareerForm: function(color) {
      this.pageColor = color;
      this.displayCareerForm = true;
      this.displayPresentationForm = false;
      this.displaySkillForm = false;
      this.displayProjectForm = false;
      this.sectionSelected = "Section expérience"
    },
    showPresentationForm: function(color) {
      this.pageColor = color;
      this.displayCareerForm = false;
      this.displayPresentationForm = false;
      this.displaySkillForm = false;
      this.displayProjectForm = false;
      this.sectionSelected = "Section presentation"
    },
    showSkillForm: function(color) {
      this.pageColor = color;
      this.displayCareerForm = false;
      this.displayPresentationForm = false;
      this.displaySkillForm = true;
      this.displayProjectForm = false;
      this.sectionSelected = "Section compétence"
    },
    actionTransition() {
      this.showTransition = true;
      setTimeout(() => {
        this.showTransition = false;
      }, 1300);
    }
  },
  created() {
    setTimeout(() => {
      this.showTransition = false;
    }, 1300);
  },
  mounted() {
    this.$store.dispatch("getAllProjects");
    if (this.loggedIn) {
      let decodedToken = jwt_decode(localStorage.getItem("user"));
      let tokenDateExpiration = new Date(decodedToken.exp * 1000);
      let actualDate = new Date();
      let expTime = this.dateDiff(actualDate, tokenDateExpiration);
      if (expTime.sec <= 0) {
        this.$store.dispatch("auth/logout");
        this.$router.push("/login");
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.container-fluid {
  min-height: 100vh;
  background-color: $dark-gray;
  position: relative;
  perspective: 1000px;
  .card-deck {
    width: 80%;
    margin: auto;
    .card {
      font-family: "Oswald", sans-serif;
      color: $dark-gray;
      @include box_shadow(0px, 0px, 10px, $yellow);
      border: 1px solid $yellow;
      &-project {
        svg, .card-title {
          color: $purple;
        }
        .card {
          @include box_shadow(0px, 0px, 5px, $purple);
        }
      
      }
      &-skill {
        svg, .card-title {
          color: $green;
        }
        .card {
          @include box_shadow(0px, 0px, 5px, $green);
        }
      }
      &-career {
        svg, .card-title {
          color: $light-blue;
        }
        .card {
          @include box_shadow(0px, 0px, 5px, $light-blue);
        }
      }
      &-presentation {
        svg, .card-title {
          color: $blue;
        }
      }
    }
  }
  .footer {
    height: 15vh!important;
  }
  .row {
    height: unset;
  }
}
</style>
