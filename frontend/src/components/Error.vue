<template>
  <b-jumbotron
    :header="'Une erreur ' + code + ' est survenue'"
    class="text-center mx-auto"
  >
    <hr />
    <h4>{{ message }}</h4>
  </b-jumbotron>
</template>

<script>
export default {
  name: "Error",
  props: {
    code: String,
    message: String
  }
};
</script>

<style lang="scss">
.jumbotron {
  font-family: "MontSerrat", sans-serif;
  color: white;
  border: none;
  background-color: transparent !important;
}
</style>
