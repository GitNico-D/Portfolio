<template>
  <div
    class="circlebackground position-absolute rounded-circle"
    :style="{ '--circle-color': circleColor }"
  ></div>
</template>

<script>
export default {
  name: "BackgroundPage",
  props: {
    circleColor: String
  }
};
</script>

<style lang="scss">
.circlebackground {
  top: 50%;
  left: 50%;
  border: 0px solid var(--circle-color);
  opacity: 1;
  width: 45vw;
  height: 45vw;
  @include box_shadow(0px, 0px, 55px, var(--circle-color));
  animation: scale-up-center 0.8s cubic-bezier(0.39, 0.575, 0.565, 1) 1.2s both;
  z-index: 100;
}
@keyframes scale-up-center {
  0% {
    transform: translate(-50%, -50%) scale(0);
  }
  100% {
    transform: translate(-50%, -50%) scale(1);
  }
}
</style>
