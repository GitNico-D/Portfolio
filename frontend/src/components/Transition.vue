<template>
  <div :class="directionAnimation">
    <div class="slider-green">
      <div class="slider-purple"></div>
    </div>
    <div class="slider-green">
      <div class="slider-purple"></div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Transition",
  props: {
    directionAnimation: String
  }
};
</script>

<style lang="scss">
.slider {
  &-green {
    background: $green;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 255;
  }
  &-purple {
    background: $purple;
    position: fixed;
    width: 100%;
    height: 100%;
    z-index: 255;
  }
}
.up {
  .slider-green {
    animation: ease-in-out 1.5s slideUpGreen;
  }
  .slider-purple {
    animation: ease-in-out 1.5s slideUpPurple;
    transition-delay: 0.5s;
  }
  @keyframes slideUpGreen {
    from {
      transform: translateY(0%);
      filter: blur(5px);
    }
    to {
      transform: translateY(-110%);
      filter: blur(0px);
    }
  }
  @keyframes slideUpPurple {
    from {
      transform: translateY(100%);
      height: 100%;
      filter: blur(10px);
    }
    to {
      transform: translateY(-110%);
      height: 0%;
      filter: blur(0px);
    }
  }
}
.right {
  .slider {
    &-green {
      animation: ease-in-out 1.3s slideRightGreen;
    }
    &-purple {
      animation: ease-in-out 1.4s slideRightPurple;
      transition-delay: 0.5s;
    }
    @keyframes slideRightGreen {
      from {
        transform: translateX(0%);
        filter: blur(5px);
      }
      to {
        transform: translateX(-110%);
        filter: blur(0);
      }
    }
    @keyframes slideRightPurple {
      from {
        transform: translateX(100%);
        filter: blur(10px);
      }
      to {
        transform: translateX(-110%);
        filter: blur(0);
      }
    }
  }
}
.left {
  .slider {
    &-green {
      animation: ease-in-out 1.5s slideLeftGreen;
    }
    &-purple {
      animation: ease-in-out 1.5s slideLeftPurple;
      transition-delay: 0.5s;
    }
    @keyframes slideLeftGreen {
      from {
        transform: translateX(0%);
        filter: blur(5px);
      }
      to {
        transform: translateX(110%);
        filter: blur(0);
      }
    }
    @keyframes slideLeftPurple {
      from {
        transform: translateX(-110%);
        filter: blur(10px);
      }
      to {
        transform: translateX(100%);
        filter: blur(0);
      }
    }
  }
}
.down {
  .slider-green {
    animation: ease-in-out 1.5s slideDownGreen;
  }
  .slider-purple {
    animation: ease-in-out 1.3s slideDownPurple;
    transition-delay: 0.5s;
  }
  @keyframes slideDownGreen {
    from {
      transform: translateY(0%);
      filter: blur(5px);
    }
    to {
      transform: translateY(110%);
      filter: blur(0px);
    }
  }
  @keyframes slideDownPurple {
    from {
      transform: translateY(-100%);
      height: 100%;
      filter: blur(10px);
    }
    to {
      transform: translateY(110%);
      height: 0%;
      filter: blur(0px);
    }
  }
}
</style>
