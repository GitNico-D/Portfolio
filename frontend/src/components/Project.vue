<template>
    <!-- <div class="cache"> -->
        <b-card :title=title>
            <b-card-text>
                {{ content }}
                <b-button class="btn m-auto">Vers le site</b-button>
            </b-card-text>
        </b-card>
    <!-- </div> -->
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
.card {
    border: none!important;
    background: $white!important;
    width: 32rem;
    height: 20rem;
    transition:.4s;
    margin: 1rem;
    flex-grow: 4;
    justify-content: space-between;
    align-items: center;
    &-body {
        background: $white;
        @include box-shadow(0px, 0px, 10px, $white);
        padding: 0!important;
    }
    &-text {
        // width: 32rem;
        // height: 20rem;
        padding: 1rem;
        opacity: 0;
    }
    &:hover {
        @include box-shadow(0px, 0px, 20px, $purple);
        .card-body {
            padding: 0!important;
            // z-index: 10;
            // @include box-shadow(0px, 0px, 20px, $purple);
        }
        .card-text {
            opacity: 1;
            background-color: $white;
            transition: opacity ease-in-out 1s;
            margin-top: 10px;
        }
    }
    &-title {
        font-size: 2.5rem;
        color: $dark-gray;
        align-items: center; 
    }
    .btn {
        text-decoration:none;
        color: black;
        box-sizing: border-box;
        padding: 10px;
        margin: 15px 0 0;
        display: inline-block;
        &:hover {
            background: #333 ;
            color: whitesmoke; 
            box-shadow: inset 0px 0px 10px rgba(0,0,0,0.5);
        }
    }    
}

</style>