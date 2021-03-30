<template>
  <b-container fluid>
    <Header  :color="pageColor" class="header" />
    <BackgroundPage :circleColor="pageColor" />
    <AdminPresentation />
    <SidebarAdmin 
      v-on:showProjectForm="showProjectForm"
      v-on:showCareerForm="showCareerForm"
      />
    <ProjectForm v-show="displayProjectForm"/>
    <CareerForm v-show="displayCareerForm"/>
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
import SidebarAdmin from "@/components/SidebarAdmin.vue";
import AdminPresentation from "@/components/admin/AdminPresentation.vue";
import ProjectForm from "@/components/admin/ProjectForm.vue";
import CareerForm from "@/components/admin/CareerForm.vue";
import HomePageLink from "@/components/HomePageLink.vue";
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
      pageColor: "red",
      displayProjectForm: false,
      displayCareerForm: false,
      displayPresentationForm: false,
      displaySkillForm: false
    }
  },
  computed: {
    loggedIn() {
      return this.$store.state.auth.status.loggedIn;
    },
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
    showProjectForm: function(color) {
      this.pageColor = color;
      this.displayProjectForm = true;
      this.displayCareerForm = false;
      this.displayPresentationForm = false;
      this.displaySkillForm = false;
    },
    showCareerForm: function(color) {
      this.pageColor = color;
      this.displayCareerForm = true;
      this.displayPresentationForm = false;
      this.displaySkillForm = false;
      this.displayProjectForm = false;
    },
    showPresentationForm: function(color) {
      this.pageColor = color;
      this.displayCareerForm = false;
      this.displayPresentationForm = false;
      this.displaySkillForm = false;
      this.displayProjectForm = false;
    },
    showSkillForm: function(color) {
      this.pageColor = color;
      this.displayCareerForm = false;
      this.displayPresentationForm = false;
      this.displaySkillForm = true;
      this.displayProjectForm = false;
    }
  },
  mounted() {
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
  .row {
    height: unset;
  }
  .footer {
    height: 15vh;
  }
}
</style>
