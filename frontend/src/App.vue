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
  methods: {
    dateDiff(date1, date2) {
      var diff = {}                           
      var tmp = date2 - date1;
      tmp = Math.floor(tmp/1000);             
      diff.sec = tmp % 60;                    

      tmp = Math.floor((tmp-diff.sec)/60);   
      diff.min = tmp % 60;                   
  
      tmp = Math.floor((tmp-diff.min)/60);    
      diff.hour = tmp % 24;                   
  
      tmp = Math.floor((tmp-diff.hour)/24);
      diff.day = tmp;
  
      return diff;
    }
  },
  mounted() {
    if(this.loggedIn) {
      let decodedToken = jwt_decode(localStorage.getItem("user"));
      let tokenDateExpiration = new Date(decodedToken.exp * 1000);
      let actualDate = new Date();
      let expTime = this.dateDiff(actualDate, tokenDateExpiration)
      if (expTime.sec <= 0) {
        this.$store.dispatch("auth/logout");
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
