<template>
  <b-button :style="{'--color': color,}" class="btn" @click="$emit('action')">
    <font-awesome-icon :icon="icon" class="mr-2"/>{{action}}
  </b-button>
</template>

<script>
export default {
  name: "Button",
  props: {
    color: String,
    action: String,
    icon: {}
  }
}
</script>

<style lang="scss" scoped>
.btn {
  color: $white;
  background-color: var(--color);
  border: 1px solid var(--color);
  &:hover, &:active {
    color: var(--color);
    background-color: transparent;
    border: 1px solid var(--color);
  }
  &:focus, &:active {
    color: $white;
    box-shadow: unset;
    border: 1px solid var(--color);
    background-color: var(--color);
  }
}
</style>