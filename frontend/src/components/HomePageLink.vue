<template>
    <router-link :to=url :class=direction>
        <span class="the-arrow">
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
            letter-spacing: 3px;
            text-shadow: 0px 0px 3px $green;
            &:hover {
                text-shadow: 0px 0px 3px $white;
            }
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
            will-change: transform;
            &:hover {
                box-shadow: 0px 0px 10px $green;
            }
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
            margin: 0 0 0 ($shaft-width + $text-arrow-space) ;
            line-height: 1;
            letter-spacing: 3px;
            text-shadow: 0px 0px 3px $green;
            &:hover {
                text-shadow: 0px 0px 3px $white;
            }
        }
        .the-arrow {
            position: absolute;
            top: 50%;
        }
    }
    &:hover {
        color: $white;  
        .main {
            transform: translateX(-($shaft-width + $text-arrow-space));            
            .the-arrow.-right {
                width: $shaft-width;
                transition: all 0.2s;
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
        &.-right {
            top: 24px;
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
            will-change: transform;
            &:hover {
                box-shadow: 0px 0px 10px $green;
            }
            &:before,
            &:after {
                background-color: $green;
                content: '';
                display: block;
                height: $arrow-head-thickness;
                position: absolute;
                top: 0;
                left: 0;
                transition: all 0.2s;
            }
            &:before {
                transform-origin: bottom left;
            }
            &:after {
                transform-origin: top left;
            }
        }
    } 
}
</style>