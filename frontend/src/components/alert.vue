<template>
<div>
  <b-alert 
    variant="success"
    v-show="successMessage"
    v-text="successMessage"
    fade>
  </b-alert>
  <b-alert
    variant="danger"
    v-show="errorMessage"
    v-text="errorMessage"
    show
    dismissible>
  </b-alert>
</div>
</template>

<script>
export default {
  name: "alertForm",
  props: {
    
  }
}
</script>

<style>

</style>