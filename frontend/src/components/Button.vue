<template>
  <b-button
    :style="{
      '--color': color,
    }"
    class="btn m-1 p-2">
    {{action}}
  </b-button>
</template>

<script>
export default {
  name: "Button",
  props: {
    color: String,
    action: String
  }
}
</script>

<style lang="scss" scoped>
.btn {
  color: $white;
  background-color: var(--color);
  border: 1px solid var(--color);
  &:hover {
    color: var(--color);
    background-color: transparent;
    border: 1px solid var(--color);
  }
}
</style>