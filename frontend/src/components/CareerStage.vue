<template>
    <b-row class="career my-5">
        <b-col cols="12" sm="6">
            <h2 class="me-5">{{ date }}</h2>     
        </b-col>
        <b-col cols="12" sm="6" class="rotateCard">
            <b-card :title="title" :style="{'--color': color}">
                <b-card-text>
                    <h4 class="mt-2">{{ company }}</h4>
                    <p class="mt-2">{{ description }} Lorem Ipsum is simply dummy text of the printing 
                        and typesetting industry. Lorem Ipsum has been the industry's standard dummy
                        text ever since the 1500s, when an unknown printer took a galley of type and 
                        scrambled it to make a type specimen book.
                    </p>
                </b-card-text>
            </b-card>    
            <b-card no-body></b-card>
        </b-col>
    </b-row>   
</template>

<script>
export default {
    name: "CareerStage",
    props: {
        date: String,
        title: String,
        description: String,
        company: String,
        color: String
    }
}
</script>

<style lang="scss" scoped>
.rotateCard {
    transform: rotateY(-10deg);
    transform-origin: right;
}
h2 {
    text-align: right;
    color: $white;
    font-family: "MontSerrat", sans-serif;
    font-weight: 600;
    text-transform: uppercase;
    animation: focus-in-contract 0.7s cubic-bezier(0.250, 0.460, 0.450, 0.940) 1.5s both;
    margin-top: 5.5rem;
}
.card {
    font-family: "Oswald", sans-serif;
    background-color: transparent;
    border: 2px solid var(--color);
    color: $white;
    @include box_shadow(0px, 0px, 15px, var(--color));
    animation: slide-in-right 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) 1.5s both;
    &-title {
        font-family: "MontSerrat", sans-serif;
        font-weight: 600;
        text-transform: uppercase;
        border: 2px solid $white;
        padding: 1.5rem;
        @include box_shadow(0px, 0px, 15px, $white);
    }
    &-text {
        h4 {
            font-weight: bold;
            text-transform: uppercase;
            text-align: left;
        }
        p {
            text-align: justify;
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
    .rotateCard {
        transform : unset;
    }
    h2 {
        font-size: 1.1rem;
        margin-top: 1rem;
    }
}
@media (min-width: 576px) {
    .rotateCard {
        transform: rotateY(-10deg);
        transform-origin: right;
    }
    h2 {
        font-size: 1.5rem;
        margin-top: 2.5rem;
    }
}
</style>