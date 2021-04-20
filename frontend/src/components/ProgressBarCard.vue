<template>
  <b-card :title="title" :style="{ '--color': color }">
    <b-card-text>
      <b-progress
        :style="{
          '--color': color,
          '--value': this.value + '%',
          '--url-icon': 'url(' + `'${urlIcon}'` +  ')'
        }"
        class="mt-4"
      >
        <b-progress-bar
          :value="value"
          max="100"
          :style="{ '--color': color }"
        ></b-progress-bar>
      </b-progress>
    </b-card-text>
  </b-card>
</template>

<script>
export default {
  name: "ProgressBarCard",
  props: {
    value: Number,
    title: String,
    color: String,
    urlIcon: String
  }
};
</script>

<style lang="scss" scoped>
.card {
  width: 100%;
  margin: 0;
  border: none;
  background: transparent;
  &-title {
    color: $white;
    font-family: "Oswald", sans-serif;
    text-align: left;
    animation: tracking-in-expand 0.7s cubic-bezier(0.215, 0.61, 0.355, 1) 1.3s
      both;
  }
  &-text {
    position: relative;
    .progress {
      background-color: $white;
      &:after {
        position: absolute;
        content: var(--url-icon);
        top: 0;
        left: var(--value);
        animation: flip-in-ver-left 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94)
          1.3s both;
      }
      &-bar {
        animation: scale-in-hor-left 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94)
          0.8s both;
        align-items: flex-end;
        background-image: src(var(--url-icon));
        background-color: var(--color);
      }
    }
  }
}
@keyframes scale-in-hor-left {
  0% {
    transform: scaleX(0);
    transform-origin: 0% 0%;
    opacity: 1;
  }
  100% {
    transform: scaleX(1);
    transform-origin: 0% 0%;
    opacity: 1;
  }
}
@keyframes flip-in-ver-left {
  0% {
    transform: translate(-50%, -50%) rotateY(80deg);
    opacity: 0;
  }
  100% {
    transform: translate(-50%, -50%) rotateY(0);
    opacity: 1;
  }
}
@keyframes tracking-in-expand {
  0% {
    letter-spacing: -0.5em;
    opacity: 0;
  }
  40% {
    opacity: 0.6;
  }
  100% {
    opacity: 1;
  }
}
@media (min-width: 320px) {
  .card {
    &-title {
      font-size: 1rem;
    }
    &-body {
      padding: 0.8rem;
    }
  }
}
@media (min-width: 576px) {
  .card {
    &-title {
      font-size: 1.3rem;
    }
    &-body {
      padding: 0.8rem;
    }
  }
}
@media (min-width: 576px) {
  .card {
    margin-bottom: 1rem;
    &-title {
      font-size: 1.3rem;
    }
    &-body {
      padding: 0.8rem;
    }
  }
}
</style>
