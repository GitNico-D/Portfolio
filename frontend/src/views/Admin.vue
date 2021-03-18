<template>
  <b-container fluid>
    <Header title="Page Administrateur" color="#485DA6" class="header" />
    <BackgroundPage circleColor="#485DA6" />
  </b-container>
</template>

<script>
import Header from "@/components/Header.vue";
import BackgroundPage from "@/components/BackgroundPage.vue";
import jwt_decode from "jwt-decode";

export default {
  components: {
    Header,
    BackgroundPage
  },
  computed: {
    loggedIn() {
      return this.$store.state.auth.status.loggedIn;
    }
  },
  created() {
    if(this.loggedIn) {
      let decodedToken = jwt_decode(localStorage.getItem("user"));
      let tokenDateExpiration = new Date(decodedToken.exp * 1000);
      let actualDate = new Date();
      let timeDifference = tokenDateExpiration - actualDate;
      if (timeDifference === 0) {
        this.$store.dispatch("auth/logout");
        this.$router.push("/login");
      }
      console.log(new Date(timeDifference).getHours() + " heures");
      console.log(new Date(timeDifference).getMinutes() + " minutes");
      console.log(new Date(timeDifference).getSeconds() + " secondes");
      }
  }
};
</script>

<style></style>
