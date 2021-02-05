<template>
    <b-row :class="parity">
        <b-col cols="12" md="6">
            <b-card :title="title" :style="{'--color': color}">
                <b-card-text>
                    <h4 class="mt-4">{{ company }}</h4>
                    <p class="mt-4">{{ description }} Lorem Ipsum is simply dummy text of the printing 
                        and typesetting industry. Lorem Ipsum has been the industry's standard dummy
                        text ever since the 1500s, when an unknown printer took a galley of type and 
                        scrambled it to make a type specimen book.
                    </p>
                </b-card-text>
            </b-card>    
        </b-col>
        <b-col cols="12" md="6" class="career-date">
            <h2 class="career-date-one"><span>{{ startDate }}</span> - <span>{{ endDate }}</span></h2>  
            <p class="career-date-second"><span>{{ startDate }}</span> - <span>{{ endDate }}</span></p>
        </b-col>
    </b-row>   
</template>

<script>
export default {
    name: "CareerStage",
    props: {
        startDate: String,
        endDate: String,
        title: String,
        description: String,
        company: String,
        color: String,
        parity: String
    }
}
</script>

<style lang="scss" scoped>
.row {
    width: 90%;
    perspective: 1000px;
    }
h2 {
    color: $white;
    font-family: "MontSerrat", sans-serif;
    font-weight: 600;
    text-transform: uppercase;
    animation: focus-in-contract 0.7s cubic-bezier(0.250, 0.460, 0.450, 0.940) 1.5s both;
}
.card {
    font-family: "Oswald", sans-serif;
    background-color: transparent;
    border-radius: 0;
    border: 0;
    color: $dark_gray;
    perspective: 1000px;
    &-title {
        font-family: "MontSerrat", sans-serif;
        color: $white;
        font-weight: 600;
        text-transform: uppercase;
        border: 2px solid $white;
        padding: 1.5rem;
        @include box_shadow(0px, 0px, 5px, var(--color)); 
        z-index: 5;
    }
    &:before {
        content: "";
        position: absolute;
        background-color: $white;
        transform: rotateZ(-5deg);
        z-index: -1;
        width: 100%;
        height: 100%;
        @include box_shadow(0px, 0px, 10px, var(--color)); 
    }
    &:after {
        content: "";
        position: absolute;
        background-color: var(--color);
        width: 100%;
        height: 100%;
        z-index: -1;
        left: 2%;
        bottom: 5%;
        transform: rotateZ(4deg);
        @include box-shadow (0px, 0px, 10px, var(--color));
    }
    &-text {
        h4 {
            font-weight: bold;
            color: $white;
            text-transform: uppercase;
        }
        p {
            text-align: justify;
            color: $white;
        }
    }
}
.card {
    &:before, &:after {
        mix-blend-mode: multiply;
    }
}
.career {
    &-date {
        mix-blend-mode: multiply;
        position: relative;
        color: $white;
        &-second {
            font-family: "MontSerrat", sans-serif;
            text-transform: uppercase;
            font-size: 5rem;
            font-weight: 900;
            color: $light-blue;
            opacity: 0.3;
            z-index: -1;
            position: absolute;
            transform: translateY(-30%);
        }
    }
}
.odd {
    margin: 3rem auto 6rem auto;
    align-items: center;
    .card {
        animation: slide-in-left 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) 1s both;
        transition: all 1s ease;
        &-text {
            h4 {
                text-align: right;
            }
        }
    } 
    &:hover {
        cursor: default;
        .card {
            &:after {
                transition: all 0.2s ease;
                box-shadow: 5px 7px 2px var(--color);
                left: 0;
                bottom: 0;
            }
            &-title {
                border: none;
                transition: all 0.5s ease;
                color: $white;
                background-color: var(--color);
                box-shadow: 5px 7px 2px $white,
                            0px 0px 15px var(--color);
            }
        }
    }
    .career {
        &-date {
            &-second {
                top: 0%;
                left: 5%;
            }
        }
    }    
}
.even {
    margin: 3rem auto 6rem auto; 
    align-items: center;
    .card {
        animation: slide-in-right 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) 1s both;
        &-text {
            h4 {
                text-align: left;
            }
        }
    }
    &:hover {
        .card {
            &:after {
                transition: all 0.2s ease;
                box-shadow: -5px 7px 2px $white;
                left: 0;
                bottom: 0;
            }
            &-title {
                border: none;
                transition: all 0.5s ease;
                color: $white;
                background-color: var(--color);
                box-shadow: -5px 7px 2px $white,
                            0px 0px 15px var(--color);
            }
        }
    }
    .career {
        &-date {
            &-second {
                top: 0%;
                right: 5%;
            }
        }
    }
}
@keyframes focus-in-contract {
    0% {
        letter-spacing: 1em;
        filter: blur(12px);
        opacity: 0;
    }
    100% {
        filter: blur(0px);
        opacity: 1;
    }
}
@keyframes slide-in-left {
    0% {
        transform: translateX(-500px);
        opacity: 0;
    }
    100% {
        transform: translateX(0);
        opacity: 1;
    }
}
@keyframes slide-in-right {
    0% {
        transform: translateX(1000px);
        opacity: 0;
    }
    100% {
        transform: translateX(0);
        opacity: 1;
    }
}

@media (min-width: 320px) {
    .even, .odd {
        flex-direction: column-reverse;
        .rotateCard {
            transform: unset;
        }
        h2 {
            font-size: 1.5rem;
        }
        .card {
            &-title {
                transform: unset;                
            }  
            &-body {
                transform: unset;
            }
            &:before {
                transform: unset;
            }
            &:after {
                transform: unset;
                left: 0;
                bottom: 0;
            }
        }
        &:hover {
            transform: unset;
            box-shadow: unset;
        }        
    }
    .odd {
        width: 100%;
        &:hover {
            .card {
                &-title {
                    transform: unset;
                }
            }
        }
        h2 {
            text-align: right;
        }
        .career {
            &-date {
                &-second {
                    top: 0%;
                    left: 30%;
                    font-size: 2rem;
                }
            }
        }
    }
    .even {
        width: 100%;
        &:hover {
            .card {
                &-title {
                    transform: unset;
                }
            }
        }
        h2 {
            text-align: left;
        } 
        .career {
            &-date {
                &-second {
                    top: 0%;
                    right: 28%;
                    font-size: 2rem;
                }
            }
        }         
    }
}
@media (min-width: 576px) {
    .odd {
        .card {
            &-title {
                position: absolute; 
                width: 65%;
                top: 0;    
                left: 0;  
                transform: translate(-2%, -50%);
            }
        }
        &:hover {
            .card {
                &-title {
                    transform: translate(-2%, -50%);
                }
            }
        }
        h2 {
            text-align: right;
        }
        .career {
            &-date {
                &-second {
                    left: 65%;
                    font-size: 1.8rem;
                }
            }
        }
    }
    .even {
        .card {
            &-title {
                position: absolute; 
                width: 65%;
                top: 0;    
                right: 0;  
                transform: translate(2%, -50%);
            }
        }
        &:hover {
            .card {
                &-title {
                    transform: translate(2%, -50%);
                }
            }
        }
        h2 {
            text-align: left;
        }
        .career {
            &-date {
                &-second {
                    right: 65%;
                    font-size: 1.8rem;
                }
            }
        }
    }
    h2 {
        font-size: 1.5rem;
    }
}
@media (min-width: 768px) {
    .odd {
        width: 95%;
        flex-direction: row;
        h2 {
            text-align: left;
            font-size: 2rem;
        }
        .card {
            &:after {
                transform: rotateZ(4deg);
            }
            &:before {
                transform: rotateZ(-5deg);
            }
            &-body {
                transform: rotateZ(4deg);
            }
            &-title {
                width: 50%;
                margin: auto;
                transform: translate(-10%, -50%);
            }
        }
        &:hover {
            cursor: default;
            .card {
                &-title {
                    transition: all 0.2s ease;
                    transform: translate(-10%, -50%) rotateZ(0deg);
                }  
                &-body {
                    transition: all 0.2s ease;
                    transform: rotateZ(0deg);
                }
                &:before {
                    transition: all 0.2s ease;
                    transform: rotateZ(0deg);
                }
                &:after {
                    transform: rotateZ(0deg);
                }
            }
        }
        .career {
            &-date {
                &-second {
                    left: 8%;
                    font-size: 3rem;
                }
            }
        }
    }
    .even {
        width: 95%;
        flex-direction: row-reverse;
        .card {
            &-title {
                width: 50%;
                margin: auto;
                transform: translate(10%, -50%);
                color: $white;
                border: 2px solid $white;
            }
            &:before {
                transform: rotateZ(5deg);
            }
            &:after {
                transform: rotateZ(-4deg);
            }
            &-body {
                transform: rotateZ(-4deg);
            }
        }
        .career {
            &-date {
                &-second {
                    right: 8%;
                    font-size: 3rem;
                }
            }
        }
        &:hover {
            cursor: default;
            .card {
                &-title {
                    transition: all 0.2s ease;
                    transform: translate(10%, -50%) rotateZ(0deg);
                }  
                &-body {
                    transition: all 0.2s ease;
                    transform: rotateZ(0deg);
                }
                &:before {
                    transition: all 0.2s ease;
                    transform: rotateZ(0deg);
                }
                &:after {
                    transform: rotateZ(0deg);
                }
            }
        }
        h2 {
            text-align: right;
            font-size: 2.5rem;
        }
    }
}
@media (min-width: 992px) {
    .odd {
        width: 85%;
        h2 {
            font-size: 3rem;
        }
    }
    .even {
        width: 85%;
        h2 {
            font-size: 3rem;
        }
    }
}
</style>