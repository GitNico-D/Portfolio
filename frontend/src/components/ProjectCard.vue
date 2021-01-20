<template>
    <div class="cardflip">
        <b-card no-body :title="title" class="frontcard">
            <b-card-title>{{ title }}</b-card-title>
        </b-card>
        <b-card class="backcard">
            <b-card-text>{{ content }}</b-card-text>
        <b-button class="btn m-auto">Vers le site</b-button>
        </b-card>
    </div>
</template>

<script>
export default {
    name: "Project",
    props: {
        title: String,
        content: String
    }
}
</script>

<style lang="scss">
.cardflip {
    position: relative;
    .card-title {
        font-size: 2rem;
        margin: auto;
    }
    .frontcard,
    .backcard {
        display: block;
        transition-timing-function: cubic-bezier(.175, .885, .32, 1.275);
        transition-duration: 1s;
        transition-property: transform, opacity;
    }
    .frontcard {
        transform: rotateY(0deg);
        background: $purple;
    }
    .backcard {
        position: absolute;
        opacity: 0;
        top: 0px;
        left: 0px;
        width: 100%;
        height: 100%;
        transform: rotateY(-180deg);
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
    &.flip-vertical {
        .backcard {
            transform: rotateX(-180deg);
        }
        &:hover {
            .frontcard {
                transform: rotateX(180deg);
            }
            .backcard {
                transform: rotateX(0deg);
            }
        }
    }
}

// custom
.cardflip {
    position: relative;
    display: inline-block;
    margin-right: 2px;
    margin-bottom: 1em;
    width: 400px;
    .frontcard,
    .backcard {
        display: block;
        color: white;
        width: inherit;
        background-size: cover!important;
        background-position: center!important;
        height: 400px;
        padding: 1em 2em;
        background: $white;
        border-radius: 10px;
        p {
            font-size: 0.9125rem;
            line-height: 160%;
            color: #999;
        }
    }
}
// .card {
//     border: none!important;
//     background: $white!important;
//     width: 32rem;
//     height: 20rem;
//     transition:.4s;
//     margin: 1rem;
//     flex-grow: 4;
//     justify-content: space-between;
//     align-items: center;
//     &-body {
//         background: $white;
//         @include box-shadow(0px, 0px, 10px, $white);
//         padding: 0!important;
//     }
//     &-text {
//         // width: 32rem;
//         // height: 20rem;
//         padding: 1rem;
//         opacity: 0;
//     }
//     &:hover {
//         @include box-shadow(0px, 0px, 20px, $purple);
//         .card-body {
//             padding: 0!important;
//             // z-index: 10;
//             // @include box-shadow(0px, 0px, 20px, $purple);
//         }
//         .card-text {
//             opacity: 1;
//             background-color: $white;
//             transition: opacity ease-in-out 1s;
//             margin-top: 10px;
//         }
//     }
//     &-title {
//         font-size: 2.5rem;
//         color: $dark-gray;
//         align-items: center; 
//     }
//     .btn {
//         text-decoration:none;
//         color: black;
//         box-sizing: border-box;
//         padding: 10px;
//         margin: 15px 0 0;
//         display: inline-block;
//         &:hover {
//             background: #333 ;
//             color: whitesmoke; 
//             box-shadow: inset 0px 0px 10px rgba(0,0,0,0.5);
//         }
//     }    
// }

</style>