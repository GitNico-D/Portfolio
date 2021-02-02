<template>
    <b-row :class="parity" class="my-5" >
        <b-col cols="12" md="6" class="rotateCard">
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
        <b-col cols="12" md="6">
            <h2 class="me-5">{{ date }}</h2>     
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
        color: String,
        parity: String
    }
}
</script>

<style lang="scss" scoped>
.row {
    width: 90%;
    perspective: 1000px;
    transform-style: preserve-3d;}
h2 {
    color: $white;
    font-family: "MontSerrat", sans-serif;
    font-weight: 600;
    text-transform: uppercase;
    margin-top: 5.5rem;
    animation: focus-in-contract 0.7s cubic-bezier(0.250, 0.460, 0.450, 0.940) 1.5s both;
}

.card {
    font-family: "Oswald", sans-serif;
    background-color: $white;
    border: 2px solid var(--color);
    color: $dark_gray;
    @include box_shadow(0px, 0px, 15px, var(--color));
    transition: .5s all ease;
    perspective: 1000px;
    &-title {
        font-family: "MontSerrat", sans-serif;
        font-weight: 600;
        text-transform: uppercase;
        border: 2px solid var(--color);
        padding: 1.5rem;
        @include box_shadow(0px, 0px, 5px, var(--color)); 
        
    }
    &-text {
        h4 {
            font-weight: bold;
            text-transform: uppercase;
        }
        p {
            text-align: justify;
        }
    }
    &:hover {
        .card-body {
            transition: 0.5s all ease;
        .card-title {
            border: 2px solid $white;
            transition: 0.5s all ease;
            color: $white;
            background-color: var(--color);
        }   
    }
    }

}
.odd {
    margin: auto;
    .rotateCard {
        transform-origin: left;
        transition: 0.5s all ease;
        &:hover {
            transform: none;
            transition: 0.5s all ease;
        }
    }
    .card {
        animation: slide-in-left 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) 1s both;
        &-title {
            color: $white;
            background-color: var(--color);
            border: 2px solid $white;
            @include box_shadow(0px, 0px, 15px, $dark_gray);
        }
        &-text {
            h4 {
                text-align: right;
            }
        }
    }       
}
.even {
    margin:auto; 
    .rotateCard {
        transform-style: preserve-3d;
        transform-origin: right;
        transition: 0.5s all ease;
        &:hover {
            transform: none;
            transition: 0.5s all ease;
        }
    }
    .card {
        animation: slide-in-right 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) 1s both;
        &-title {
            color: $white;
            background-color: var(--color);
            border: 2px solid $white;
            @include box_shadow(0px, 0px, 15px, $dark_gray);
        }
        &-text {
            h4 {
                text-align: left;
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
            transform : unset;
        }
        h2 {
            font-size: 1.1rem;
            margin-top: 1rem;
        }
    }
    .odd {
        width: 100%;
        .card {
            &-title {
                transform: unset;
            }
        }
        h2 {
            text-align: right;
        }
    }
    .even {
        width: 100%;
        .card {
            &-title { 
                transform: unset;
            }
        }
        h2 {
            text-align: left;
        }
    }
}
@media (min-width: 576px) {
    .rotateCard {
        transform: rotateY(15deg);
        transform-origin: left;
    }
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
        h2 {
            text-align: right;
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
        h2 {
            text-align: left;
        }
    }
    h2 {
        font-size: 1.5rem;
        margin-top: 4.5rem;
    }
}
@media (min-width: 768px) {
    .odd {
        width: 95%;
        flex-direction: row;
        .rotateCard {
            transform: rotateY(15deg);
        }
        h2 {
            text-align: left;
            font-size: 2rem;
            margin-top: 2rem;
        }
        .card {
            &-title {
                width: 50%;
                margin: auto;
                transform: translate(-10%, -50%);
            }
        }
    }
    .even {
        width: 95%;
        flex-direction: row-reverse;
        .rotateCard {
            transform: rotateY(-15deg);
        }
        .card {
            &-title {
                width: 50%;
                margin: auto;
                transform: translate(10%, -50%);
            }
        }
        h2 {
            text-align: right;
            font-size: 2rem;
            margin-top: 2rem;
        }
    }
}
@media (min-width: 992px) {
    h2 {
        font-size: 2rem;
        margin-top: 4.5rem;
    }
}
@media (min-width: 992px) {
    .odd {
        width: 85%;
        flex-direction: row;
        .rotateCard {
            transform: rotateY(15deg);
        }
        h2 {
            text-align: left;
            font-size: 2rem;
            margin-top: 2rem;
        }
        .card {
            &-title {
                width: 50%;
                margin: auto;
                transform: translate(-10%, -50%);
            }
        }
    }
    .even {
        width: 85%;
        flex-direction: row-reverse;
        .rotateCard {
            transform: rotateY(-15deg);
        }
        .card {
            &-title {
                width: 50%;
                margin: auto;
                transform: translate(10%, -50%);
            }
        }
        h2 {
            text-align: right;
            font-size: 2rem;
            margin-top: 2rem;
        }
    }
    h2 {
        font-size: 2rem;
        margin-top: 4.5rem;
    }
}
</style>