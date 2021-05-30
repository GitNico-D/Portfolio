<template>
  <div>
    <b-alert :variant="variant" show>
      {{ message }}
    </b-alert>
  </div>
</template>

<script>
export default {
  name: "AlertForm",
  props: {
    message: {
      type: [String, Object]
    },
    variant: String
  }
};
</script>

<style></style>
