<template>
  <b-link
    :href="socialLink"
    :style="{
      '--color-one': colorOne,
      '--color-two': colorTwo,
      '--url-icon': 'url(' + `'${logoIcon}'` +  ')'
    }"
    class="btn m-1 p-2"
  >
    {{ name }}
  </b-link>
</template>

<script>
export default {
  name: "Button",
  props: {
    name: String,
    socialLink: String,
    colorOne: String,
    colorTwo: String,
    logoIcon: String
  }
};
</script>

<style lang="scss" scoped>
.btn {
  color: $white;
  background-color: var(--color-one);
  border: 2px solid var(--color-one);
  transition: transform 0.2s ease;
  position: relative;
  &:before {
    content: "";
    position: absolute;
    transition: transform 0.2s ease;
    transform: rotate(0deg);
  }
  &:hover {
    color: var(--color-two);
    background-color: var(--color-one);
    box-shadow: 0 0 10px var(--color-two);
    transform: scale(1.2);
    transition: transform 0.2s ease;
    &:before {
      content: "";
      transition: transform 0.2s ease;
      position: absolute;
      background: var(--url-icon) no-repeat;
      top: -20%;
      left: 55%;
      transform: rotate(12deg) scale(1.2);
      width: 100%;
      height: 100%;
    }
  }
}
</style>
