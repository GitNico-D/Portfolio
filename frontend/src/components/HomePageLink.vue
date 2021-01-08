<template>
    <router-link :to=url :class=direction>
        <span class="the-arrow -left">
            <span class="shaft"></span>
        </span>
        <span class="main">
            <span class="text">{{ action }}</span>
            <span class="the-arrow -right">
                <span class="shaft"></span>
            </span>
        </span>
    </router-link> 
</template>

<script>
export default {
    name: "HomePageLink",
    props: {
        action: String,
        url: String,
        direction: String
    }
}
</script>

<style lang="scss">

//The Arrow rightToLeft
.animated-arrowRtl {
    display: inline-block;
    color: $green;
    font-size: 2.25em;
    position: relative;
    transition: all 0.2s;
    .main {
        display: flex;
        align-items: center;
        transition: all 0.2s;
        .text {
            font-family: "Oswald", sans-serif;
            margin: 0 $text-arrow-space 0 0;
            line-height: 1;
        }
        .the-arrow {
            position: relative;
        }
    }
    &:hover {
        color: $white;  
        .main {
            transform: translateX($shaft-width + $text-arrow-space);            
            .the-arrow.-right {
                .shaft {
                    width: 0;
                    transform: translateX(200%);
                    transition-delay: 0;                    
                    &:before,
                    &:after {
                        width: 0;
                        transition-delay: 0;
                        transition: all 0.1s;
                    }
                    &:before {
                        transform: rotate(0);
                    }
                    &:after {
                        transform: rotate(0);
                    }
                }
            }
        }
    }
    .the-arrow {
        width: $shaft-width;
        transition: all 0.2s;
        &.-right {
            top: 6px;
            .shaft {
                width: $shaft-width;
                transition-delay: 0.2s;
                &:before,
                &:after { 
                    width: $arrow-head-width;
                    transition-delay: 0.3s;
                    transition: all 0.5s;
                }        
                &:before {
                    transform: rotate(40deg);
                }
                
                &:after {
                    transform: rotate(-40deg);
                }
            }
        }
        .shaft {
            background-color: $green;
            display: block;
            height: $shaft-thickness;
            position: relative;
            transition: all 0.2s;
            transition-delay: 0;
            will-change: transform;
            &:before,
            &:after {
                background-color: $green;
                content: '';
                display: block;
                height: $arrow-head-thickness;
                position: absolute;
                top: 0;
                right: 0;
                transition: all 0.2s;
                transition-delay: 0;
            }
            &:before {
                transform-origin: top right;
            }
            &:after {
                transform-origin: bottom right;
            }
        }
    }    
}
.animated-arrowLtr {
    display: inline-block;
    color: $green;
    font-size: 2.25em;
    position: relative;
    transition: all 0.2s;
    .main {
        display: flex;
        align-items: center;
        transition: all 0.2s;
        .text {
            font-family: "Oswald", sans-serif;
            margin: 0 0 0 $text-arrow-space;
            line-height: 1;
        }
        .the-arrow {
            position: relative;
        }
    }
    &:hover {
        color: $white;  
        .main {
            transform: translateX($text-arrow-space - $shaft-width);
            .the-arrow.-right {
                .shaft {
                    width: $shaft-width;
                    transition-delay: 0.1s;
                    background-color: $white;
                    &:before,
                    &:after {
                        width: $arrow-head-width;
                        transition-delay: 0.1s;
                        background-color: $white;
                    }
                    &:before {
                        transform: rotate(40deg);
                    }

                    &:after {
                        transform: rotate(-40deg);
                    }
                }                
            }
        }
    }
}

</style>