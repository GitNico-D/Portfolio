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
};
</script>

<style></style>
