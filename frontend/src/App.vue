<template>
  <div id="app">
    <router-view />
  </div>
</template>

<script>
import jwt_decode from "jwt-decode";

export default {
  computed: {
    loggedIn() {
      return this.$store.state.auth.status.loggedIn;
    }
  },
  beforeCreate() {
    if(this.loggedIn) {
      let decodedToken = jwt_decode(localStorage.getItem("user"));
      let tokenDateExpiration = new Date(decodedToken.exp * 1000);
      let actualDate = new Date();
      let timeDifference = tokenDateExpiration - actualDate;
      console.log(new Date(timeDifference).getHours() + " heures");
      if (timeDifference === 0) {
        this.$store.dispatch("auth/logout");
        this.$router.push("/login");
      }
    }
  }
}
</script>


<style lang="scss">
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

#nav {
  padding: 30px;
  a {
    font-weight: bold;
    color: #2c3e50;
    &.router-link-exact-active {
      color: #42b983;
    }
  }
}
</style>
