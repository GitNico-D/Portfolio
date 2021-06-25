<template>
  <div class="circle-box position-absolute">
    <div class="circle circle-one" :style="{'--circle-color': circleColor}"></div>
    <div class="circle circle-two" :style="{'--circle-color': circleColor}"></div>
    <div class="circle circle-three" :style="{'--circle-color': circleColor}">
      <div class="circle circle-four" :style="{'--circle-color': circleColor}"></div>
    </div>
    <div class="circle circle-five" :style="{'--circle-color': circleColor}"></div>
    <div class="circle circle-six" :style="{'--circle-color': circleColor}"></div>
    <div class="circle circle-seven" :style="{'--circle-color': circleColor}"></div>
  </div>
</template>

<script>
export default {
  name: "CircleBackground",
  props: {
    circleColor: String
  }
}
</script>

<style lang="scss">
.circle-box {
  height: 100vh;
  width: 100%;
}
.circle {
  position: absolute;
  width: 100%;
  border-radius: 100%;
  animation: circles 9.5s linear infinite;
  &-one {
    background-color: var(--circle-color);
    width: 10vw;
    height: 10vw;
    top: 44%;
    left: 50%;
    z-index: -2;
    transform-style: preserve-3d;
    animation-duration: 15s;
    filter: blur(7px);
  }
  &-two {
    background-color: var(--circle-color);
    border-radius: 100%;
    width: 30vw;
    height: 30vw;
    top: 20%;
    left: -20%;
    z-index: -2;
    @include box_shadow(0px, 0px, 100px, var(--circle-color));
    transform-style: preserve-3d;
    animation-duration: 6s;
    filter: blur(3px);
  }
  &-three {
    border: 25px solid var(--circle-color);
    width: 15vw;
    height: 15vw;
    top: 10%;
    right: 5%;
    z-index: -2;
    transform-style: preserve-3d;
    @include box_shadow(0px, 0px, 50px, var(--circle-color));
    animation-duration: 30s;
    filter: blur(10px);
  }
  &-four {
    background-color: var(--circle-color);
    width: 2vw;
    height: 2vw;
    top: 25%;
    left: 70%;
    z-index: -2;
    transform-style: preserve-3d;
    animation-duration: 5s;
  }
  &-five {
    border: 25px solid var(--circle-color);
    width: 10vw;
    height: 10vw;
    top: 60%;
    left: 20%;
    z-index: -2;
    transform-style: preserve-3d;
    animation-duration: 10s;
    filter: blur(3px);
  }
  &-six {
    background-color: var(--circle-color);
    width: 3vw;
    height: 3vw;
    top: 25%;
    left: 40%;
    z-index: -2;
    @include box_shadow(0px, 0px, 50px, var(--circle-color));
  }
  &-seven {
    background-color: var(--circle-color);
    width: 8vw;
    height: 8vw;
    top: 80%;
    right: 20%;
    z-index: -2;
    @include box_shadow(0px, 0px, 75px, var(--circle-color));
    transform-style: preserve-3d;
    filter: blur(1px);
  }
  @keyframes circles {
    from {
      transform: translateY(450%);
    }
    to {
      transform: translateY(calc(-100vh + -100%)) translateX(75%);
    }
  }
}
</style>