<template>
    <b-container fluid>
        <Header title="Presentation" color="#485DA6" class="header"/>
        <BackgroundPage circleColor="#485DA6"/>
        <Transition v-show="showTransition" directionAnimation="left"/>
        <b-row class="presentation justify-content-center">
            <b-col cols="3">
                <b-card img-src="https://picsum.photos/600/300/?image=25" img-top>
                    <b-card-title>  
                        <span class="first">{{ firstName }}</span> <span class="last">{{ lastName }}</span>
                    </b-card-title>
                    <hr>
                    <b-card-text>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        <div class="d-flex justify-content-around my-3">
                            <Button name="GitHub" href="https://github.com/GitNico-D" colorOne="#485DA6" colorTwo="#FF9C66" :logoIcon="require('../assets/logo-github.svg')"/>
                            <Button name="GitHub" href="https://github.com/GitNico-D" colorOne="#FF9C66" colorTwo="#485DA6" :logoIcon="require('../assets/logo-github.svg')"/>
                            <Button name="GitHub" href="https://github.com/GitNico-D" colorOne="#485DA6" colorTwo="#FF9C66" :logoIcon="require('../assets/logo-github.svg')"/>
                        </div>
                    </b-card-text>
                </b-card>
            </b-col>
            <b-col cols="5" class="presentation-text">
                <div>
                    <h5 class="text-right text-uppercase">Lorem Ipsum</h5>
                    <p class="presentation-text-first text-justify">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                        Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                        when an unknown printer took a galley of type and scrambled it to make a type specimen book
                    </p>
                    <div class="presentation-text-separator"></div>
                    <h5 class="text-left text-uppercase pt-4">Lorem Ipsum</h5>
                    <p class="presentation-text-second text-justify">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                        Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                        when an unknown printer took a galley of type and scrambled it to make a type specimen book
                    </p>
                    <div class="presentation-text-separator"></div>
                    <h5 class="text-right text-uppercase">Lorem Ipsum</h5>
                    <p class="presentation-text-first text-justify">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                        Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                        when an unknown printer took a galley of type and scrambled it to make a type specimen book
                    </p>
                </div>
            </b-col>
        </b-row>
        <b-row class="bottom">
            <HomePageLink action="Retour" url="/" direction="animated-arrowRtl" class="link link-bottom" textColor="#485DA6"/>
        </b-row> 
    </b-container>
</template>

<script>
import BackgroundPage from '@/components/BackgroundPage.vue'
import Header from '@/components/Header.vue'
import HomePageLink from '@/components/HomePageLink.vue'
import Transition from "@/components/Transition.vue"
import Button from '@/components/Button.vue'

export default {
    components: {
        BackgroundPage,
        Header,
        HomePageLink,
        Transition,
        Button
    },
    data() {
        return {
            showTransition: true,  
            firstName: "Nicolas",
            lastName: "Dubief"  
        }
    },
    methods: {
        actionTransition () {
            this.showTransition = true;
            setTimeout(() => {
                this.showTransition = false;
            },1300);
        }
    },
    created() {
        setTimeout(() => {
            this.showTransition = false;
        },1300);
    }
}
</script>

<style lang="scss" scoped>
.header {
    height: 12vh;
}
.presentation {
    padding-top: 10rem;
    .card {
        &-title {
            font-family: "MontSerrat", sans-serif;
            font-size:2.5rem;
            text-transform: uppercase;
            .first {
                color: $blue;
                margin-right: 5rem;
            }
            .last {
                font-weight: 600;
                color: $orange;
                margin-left: 5rem;
            }
        }
        &-body {
            margin-top: 5rem;
            &:before {
                position: absolute;
                content: "";
                border: 8px solid rgba(72, 93, 166, 0.2);
                top: 5%;
                left: 5%;
                width: 100%;
                @include box_shadow(0px, 0px, 15px, $blue);
                height: 100%;
                z-index: -1;
            }
            &-text {
                    &:after {
                        position: absolute;
                    content: "";
                    background-color: $white;
                    top: 80%;
                    left: 5%;
                    width: 90%;
                    border-radius: 10px;
                    height: 50%;
                    z-index: 1;
                }
            }
        }
        &-img-top {
            position: absolute;
            transform: translate(-50%, -50%);
            width: 100%;
            z-index: 3;
            @include box_shadow(0px, 0px, 25px, $blue);
        }
    }
    &-text {
        color : $white;
        font-family: "Oswald", sans-serif;
        border-left-width: 1px; 
        border-left-style: solid;
        border-image: linear-gradient(0deg, rgba(72,93,166,1) 0%, rgba(72,93,166,0) 100%);
        &-first {
            border-right: 1px solid $orange;
            padding: 1rem;
            margin: 2.5rem 0 5rem 0;
        }
        &-second {
            border-left: 1px solid $orange;
            padding: 1rem;
            margin: 2.5rem 0 0 5rem;
        }
        &-separator {
            width: 100%;
            height: 2px;
            background-color: $blue;
            box-shadow: 0px 0px 20px $blue;
        }
    }
}
.bottom {
    height: 8vh;
}

</style>