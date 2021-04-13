<template>
  <b-container fluid>
    <Header :color="pageColor" class="header" :title="sectionSelected"/>
    <BackgroundPage :circleColor="pageColor" />
    <Transition v-show="showTransition" directionAnimation="down" />
    <AdminPresentation v-show="showOverview" />
    <SidebarAdmin 
      v-on:showProjectForm="showProjectForm"
      v-on:showCareerForm="showCareerForm"
      v-on:showSkillForm="showSkillForm"
      v-on:showPresentationForm="showPresentationForm"
      v-on:returnToOverview="returnToOverview"
      />
    <ProjectForm v-show="displayProjectForm"/>
    <CareerForm v-show="displayCareerForm"/>
    <SkillForm v-show="displaySkillForm"/>
    <PresentationForm v-show="displayPresentationForm"/>
    <h2 class="text-center text-white mb-4 text-uppercase font-weight-bold" v-show="showOverview">Aperçu</h2>
      <b-row v-show="showOverview" class="overview justify-content-around flex-wrap">
        <b-col col lg="6" md="8" sm="8">
          <b-card class="card-project mb-3">
            <b-card-title class="text-uppercase font-weight-bold">Projets</b-card-title>
            <hr>
            <font-awesome-icon icon="laptop-code" size="9x" class="py-2"/>
            <hr>
            <b-card-text class="my-4">
              Il y a un total de <span class="text-justify font-weight-bold">{{allProjects.length}}</span> projets présent sur le site.
              <hr>
              <p class="text-left"><u><i>Dernier projet ajouté</i></u> :
                <span v-for="(project, index) in allProjects" :key="index">
                  <b-card v-if="index === allProjects.length - 1" :title="project.name" :sub-title="formatDate(project.createdAt)" class="mt-3">{{project.name}}</b-card>
                </span>
              </p>
              <p class="text-left" v-if="lastUpdatedProject"><u><i>Dernier projet modifié</i></u> :
                  <b-card :title="lastUpdatedProject.name" :sub-title="formatDate(lastUpdatedProject.updatedAt)" class="mt-3">{{lastUpdatedProject.name}}</b-card>
              </p>
            </b-card-text>
            <template #footer>
            </template>
          </b-card>
        </b-col>
        <b-col col lg="6" md="8" sm="8">
          <b-card class="card-skill mb-3">
            <b-card-title class="text-uppercase font-weight-bold">Compétences</b-card-title>
            <hr>
            <font-awesome-icon icon="chart-pie" size="9x" class="py-2"/>
            <hr>
            <b-card-text class="my-4">
              Il y a un total de <span class="text-justify font-weight-bold">{{allSkills.length}}</span> 
              compétences répartie dans 
              <span class="text-justify font-weight-bold">{{allCategories.length}}</span> 
              catégories.
              <hr>
              <p class="text-left"><u><i>Dernière compétence ajoutée</i></u> :
                <span v-for="(skill, index) in allSkills" :key="index">
                  <b-card v-if="index === allSkills.length - 1" :title="skill.name" :sub-title="formatDate(skill.createdAt)" class="mt-3">{{skill.name}}</b-card>
                </span>
              </p>
              <p class="text-left" v-if="lastUpdatedSkill"><u><i>Dernière compétence modifiée</i></u> :
                <b-card :title="lastUpdatedSkill.name" :sub-title="formatDate(lastUpdatedSkill.updatedAt)" class="mt-3">{{lastUpdatedSkill.name}}</b-card>
              </p>
            </b-card-text>
            <template #footer>
            </template>
          </b-card>
        </b-col>
        <b-col col lg="6" md="8" sm="8">
          <b-card class="card-career mb-3">
            <b-card-title class="text-uppercase font-weight-bold">Carrières</b-card-title>
            <hr>
            <font-awesome-icon icon="laptop-code" size="9x" class="py-2"/>
            <hr>
            <b-card-text class="my-4">
              Il y a un total de 
              <span class="font-weight-bold">{{allCareerStages.length}}</span>
              étapes de carrières ajoutées sur le site.
              <hr>
              <p class="text-left"><u><i>Dernière étape de carrière ajoutée</i></u> :
                <span v-for="(careerStage, index) in allCareerStages" :key="index">
                  <b-card v-if="index === allCareerStages.length - 1" :title="careerStage.name" :sub-title="formatDate(careerStage.createdAt)" class="mt-3">{{careerStage.name}}</b-card>
                </span>
              </p>
              <p class="text-left" v-if="lastUpdatedCareerStage"><u><i>Dernière étape de carrière modifiée</i></u> :
                  <b-card :title="lastUpdatedCareerStage.name" :sub-title="formatDate(lastUpdatedCareerStage.updatedAt)" class="mt-3">{{lastUpdatedCareerStage.name}}</b-card>
              </p>
            </b-card-text>
            <template #footer>
            </template>
          </b-card>
        </b-col>
        <b-col col lg="6" md="8" sm="8">
          <b-card class="card-presentation mb-3">
            <b-card-title class="text-uppercase font-weight-bold">Présentation</b-card-title>
            <hr>
            <font-awesome-icon icon="address-book" size="9x" class="py-2"/>
            <hr>
            <b-card-text class="my-4" v-if="onePresentation">
              Il y a une <span class="font-weight-bold">présentation</span>
              <hr>
              <div class="d-flex flex-column text-left">
                <p class="text-left" v-if="onePresentation"><u><i>Date d'ajout </i></u>:</p> 
                <p class="m-auto">{{formatDate(onePresentation.createdAt)}}</p>                
                <p class="text-left mt-3" v-if="onePresentation"><u><i>Dernière modification </i></u>:</p> 
                <p class="m-auto">{{formatDate(onePresentation.updatedAt)}}</p>
              </div>
            </b-card-text>
            <template #footer>
            </template>
          </b-card>
        </b-col>
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
import ProjectForm from "@/components/admin/ProjectForm.vue";
import CareerForm from "@/components/admin/CareerForm.vue";
import SkillForm from "@/components/admin/SkillForm.vue";
import PresentationForm from "@/components/admin/PresentationForm.vue";
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
    ProjectForm,
    SkillForm,
    PresentationForm

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
    // Verified if user logged in
    loggedIn() {
      return this.$store.state.auth.status.loggedIn;
    },
    ...mapGetters(["allProjects", "allCareerStages", "allSkills", "allCategories", "onePresentation"]),
    // Search the last Project Resource updated
    lastUpdatedProject() {
      let dateDiffArray = [];
      let lastProjectUpdated;
      this.allProjects.forEach(project => {
        dateDiffArray.push(new Date(project.updatedAt).getTime());
        if(new Date(project.updatedAt).getTime() == Math.max(...dateDiffArray)) {
          lastProjectUpdated = project;
        }
      });
      return lastProjectUpdated;
    },
     // Search the last Career Stage Resource updated
    lastUpdatedCareerStage() {
      let dateDiffArray = [];
      let lastCareerStageUpdated;
      this.allCareerStages.forEach(careerStage => {
        dateDiffArray.push(new Date(careerStage.updatedAt).getTime());
        if(new Date(careerStage.updatedAt).getTime() == Math.max(...dateDiffArray)) {
          lastCareerStageUpdated = careerStage;
        }
      });
      return lastCareerStageUpdated;
    },
     // Search the last Skill Resource updated
    lastUpdatedSkill() {
      let dateDiffArray = [];
      let lastSkillUpdated;
      this.allSkills.forEach(skill => {
        dateDiffArray.push(new Date(skill.updatedAt).getTime());
        if(new Date(skill.updatedAt).getTime() == Math.max(...dateDiffArray)) {
          lastSkillUpdated = skill;
        }
      });
      return lastSkillUpdated;
    }    
  },
  methods: {
    // DateDiff used to know the time beetween "Now" and the expiration time of the jwt_token
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
    // Show preview and hide all other forms based on sidebar click button action,
    // and change color according to the section
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
      this.showOverview = false;
      this.sectionSelected = "Section carrière"
    },
    showPresentationForm: function(color) {
      this.pageColor = color;
      this.displayCareerForm = false;
      this.displayPresentationForm = true;
      this.displaySkillForm = false;
      this.displayProjectForm = false;
      this.showOverview = false;
      this.sectionSelected = "Section presentation"
    },
    showSkillForm: function(color) {
      this.pageColor = color;
      this.displayCareerForm = false;
      this.displayPresentationForm = false;
      this.displaySkillForm = true;
      this.displayProjectForm = false;
      this.showOverview = false;
      this.sectionSelected = "Section compétence"
    },
    // Action the transition slide component
    actionTransition() {
      this.showTransition = true;
      setTimeout(() => {
        this.showTransition = false;
      }, 1300);
    },
    // Format a date to WeekDay Day Month (ex: Monday 15 March) 
    formatDate(date) {
      const options = {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric"
      };
      let formatDate = new Date(date).toLocaleDateString(
        undefined,
        options
      );
      return formatDate.charAt(0).toUpperCase() + formatDate.slice(1);
    }
  },
  // Hide the transition slide 
  created() {
    setTimeout(() => {
      this.showTransition = false;
    }, 1300);
  },
  // Dispatch all store getters and verifying expiration time of the jwt_token
  mounted() {
    this.$store.dispatch("getAllProjects");
    this.$store.dispatch("getAllCareerStage");
    this.$store.dispatch("getAllSkills");
    this.$store.dispatch("getAllCategories");
    this.$store.dispatch("getPresentation");
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
.btn {
  &-project {
    color: $white;
    background-color: $purple;
    border: 1px solid $purple;
    &:hover {
      color: $purple;
      background-color: transparent;
      border: 1px solid $purple;
    }
  }
}
.container-fluid {
  min-height: 100vh;
  background-color: $dark-gray;
  position: relative;
  perspective: 1000px;
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
  .overview {
    width: 80%;
    margin: auto;
  }
  .footer {
    height: 15vh!important;
  }
  .row {
    height: unset;
  }
}
</style>
