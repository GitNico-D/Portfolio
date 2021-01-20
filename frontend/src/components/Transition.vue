<template>
    <div :class="directionAnimation">
    <div class="slider-green" >
        <div class="slider-purple"></div>
    </div>
    </div>
</template>

<script>
export default {
    name: "Transition",
    props: {
        directionAnimation: String
    },
    data() {
        return {
            hide: true
        }
    },
    mounted() {
        setTimeout(() => {
            this.hide = false;
        },1500);
    },
}
</script>

<style lang="scss">
.up {
    .slider {
        &-green {
            background: $green;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            transform: translateY(0px);
            animation: ease-in-out 1.5s slideUpGreen;
        }
        &-purple {
            background: $purple;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            transform: translateY(100px);
            animation: ease-in-out 1.5s slideUpPurple;
            transition-delay: 0.5s;
        }
        @keyframes slideUpGreen { 
            from { 
                transform: translateY(0%);
            }
            to  { 
                transform: translateY(-110%);
            }
        }       
        @keyframes slideUpPurple { 
            from { 
                transform: translateY(100%);
                height: 100%;
                }
            to  { 
                transform: translateY(-110%);
                height: 0%;
            }
        }
    }
}
.up {
    .slider {
        &-green {
            transform: translateY(0px);
            animation: ease-in-out 1.5s slideRightGreen;
        }
        &-purple {
            animation: ease-in-out 1.5s slideRightPurple;
            transition-delay: 0.5s;
        }
        @keyframes slideRightGreen { 
            from { 
                transform: translateY(0%);
            }
            to  { 
                transform: translateY(-110%);
            }
        }       
        @keyframes slideRightPurple { 
            from { 
                transform: translateY(100%);
                height: 100%;
                }
            to  { 
                transform: translateY(-110%);
                height: 0%;
            }
        }
    }
}
</style>