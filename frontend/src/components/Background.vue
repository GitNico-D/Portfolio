<template>
    <div text-variant="white">
      <h1 class="jumbotron-text" text-variant="white">
        {{ msg }}
      </h1>
    </div>
</template>

<script>
export default {
    name: "Background",
    props: {
        msg: String
    }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss">
.jumbotron {
  margin: 0!important;
}
</style>