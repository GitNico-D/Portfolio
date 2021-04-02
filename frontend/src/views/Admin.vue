<template>
  <b-container fluid>
    <Header :color="pageColor" class="header" :title="sectionSelected"/>
    <BackgroundPage :circleColor="pageColor" />
    <AdminPresentation v-show="showOverview" />
    <SidebarAdmin 
      v-on:showProjectForm="showProjectForm"
      v-on:showCareerForm="showCareerForm"
      v-on:returnToOverview="returnToOverview"
      />
    <ProjectForm v-show="displayProjectForm"/>
    <CareerForm v-show="displayCareerForm"/>
    <h2 class="text-center text-white mb-4" v-show="showOverview">Aperçu</h2>
    <b-row>
      <b-card-group deck v-show="showOverview">
        <b-card title="Project" img-src="https://picsum.photos/300/300/?image=41" img-alt="Image" img-top>
          <b-card-text>
            {{allProjects}}
          </b-card-text>
          <template #footer>
            <small class="text-muted">Last updated 3 mins ago</small>
          </template>
        </b-card>
        <b-card title="Title" img-src="https://picsum.photos/300/300/?image=41" img-alt="Image" img-top>
          <b-card-text>
            This card has supporting text below as a natural lead-in to additional content.
          </b-card-text>
          <template #footer>
            <small class="text-muted">Last updated 3 mins ago</small>
          </template>
        </b-card>
        <b-card title="Title" img-src="https://picsum.photos/300/300/?image=41" img-alt="Image" img-top>
          <b-card-text>
            This is a wider card with supporting text below as a natural lead-in to additional content.
            This card has even longer content than the first to show that equal height action.
          </b-card-text>
          <template #footer>
            <small class="text-muted">Last updated 3 mins ago</small>
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
import SidebarAdmin from "@/components/admin/SidebarAdmin.vue";
import AdminPresentation from "@/components/admin/AdminPresentation.vue";
import ProjectForm from "@/components/form/ProjectForm.vue";
import CareerForm from "@/components/admin/CareerForm.vue";
import HomePageLink from "@/components/HomePageLink.vue";
import { mapGetters } from "vuex";
import jwt_decode from "jwt-decode";

export default {
  components: {
    Header,
    BackgroundPage,
    SidebarAdmin,
    HomePageLink,
    AdminPresentation,
    ProjectForm,
    CareerForm

  },
  data() {
    return {
      pageColor: "#BE8C2E",
      displayProjectForm: false,
      displayCareerForm: false,
      displayPresentationForm: false,
      displaySkillForm: false,
      showOverview: true,
      sectionSelected: 'Tableau de bord'
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
    }
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
  }
  .footer {
    height: 15vh!important;
  }
  .row {
    height: unset;
  }
}
</style>
