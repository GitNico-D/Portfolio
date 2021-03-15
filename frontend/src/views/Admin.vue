<template>
  <b-container fluid>
    <Header title="Page Administrateur" color="#485DA6" class="header" />
    <BackgroundPage circleColor="#485DA6" />
  </b-container>
</template>

<script>
import Header from "@/components/Header.vue";
import BackgroundPage from "@/components/BackgroundPage.vue";

export default {
  components: {
    Header,
    BackgroundPage
  }
};
</script>

<style></style>
