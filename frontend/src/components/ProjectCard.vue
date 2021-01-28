<template>
    <div class="cardflip mb-3">
        <b-card no-body :title="title" class="frontcard">
            <b-card-title class="fs-1">{{ title }}</b-card-title>
        </b-card>
        <b-card class="backcard">
            <b-card-text>{{ content }}</b-card-text>
            <b-button class="btn">Vers le site</b-button>
        </b-card>
    </div>
</template>

<script>
export default {
    name: "Project",
    props: {
        title: String,
        content: String,
        color: String,
        url: String
    }
}
</script>

<style lang="scss">
.cardflip {
    font-family: 'Oswald', sans-serif;
    .card-title {
        color: $purple;       
        text-transform: uppercase;
        @include special-text-shadow;
    }
    .frontcard,
    .backcard {
        transition-timing-function: cubic-bezier(.175, .885, .32, 1.275);
        transition-duration: 1s;
        transition-property: transform, opacity;
        align-items: center;
        justify-content: center;
        color: white;
        width: inherit;
        background-size: cover!important;
        background-position: center!important;
        height: 25rem;
        padding: 1em 2em;
        background: $white;
        border-radius: 10px;
        .card-text {
            font-size: 1.1rem;
            line-height: 2rem;
            color: $purple;
            margin: auto;
        }
    }
    .frontcard {
        transform: rotateY(0deg);
        @include box_shadow(0px, 0px, 5px, $white);
        background: $white;
    }
    .backcard {
        position: absolute;
        opacity: 0;
        top: 0px;
        left: 0px;
        transform: rotateY(-180deg);
        @include box_shadow(0px, 0px, 30px, $purple);
        @include box_shadow(0px, 0px, 1px, $purple);
        .card-body {
            display: flex;
            flex-direction: column;
            .btn {
                color: $purple!important;
                background-color: transparent!important;
                border: 1px solid $purple!important;
                transform: translateZ(100px);
                &:hover {
                    color: $white!important;
                    background-color: $purple!important;
                    @include box_shadow(0px, 0px, 10px, $purple); 
                }
            }
        }
    }
    &:hover {
        .frontcard {
            transform: rotateY(180deg);
        }
        .backcard {
            opacity: 1;
            transform: rotateY(0deg);
        }
    }
}

@media (min-width: 320px) {
    .cardflip {
        width: 100%;
        margin: 1rem;
    }
}
@media (min-width: 576px) {
    .cardflip {
        width: 100%;
        margin: 1rem 3rem 1rem 3rem;
    }
}
@media (min-width: 992px) {
    .cardflip {
        width: 40rem;
        margin: 1rem;
    }
}
</style>