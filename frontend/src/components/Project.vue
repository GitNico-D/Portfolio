<template>
    <b-card :title=title>
        <b-card-text>
            {{ content }}
            <b-button class="btn m-auto">Vers le site</b-button>
        </b-card-text>
    </b-card>
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
    background: $dark-gray!important;
    width:400px;
    height: 200px;
    transition:.4s;
    &-body {
        background: $dark-gray;
        @include box-shadow(0px, 0px, 20px, $purple);
        padding: 0!important;
    }
    &-text {
        height: 250px;
        width:400px;
        padding: 1rem;
        opacity: 0;
    }
    &:hover {
        .card-body {
            background: $dark-gray;
            padding: 0!important;
                transition: all ease-in-out .5s;
                transform: translateY(-125px);
        }
        .card-text {
            opacity: 1;
            background-color: $white;
            transition: all ease-in-out .5s;
            transform: translateY(160px);
        }
    }
    &-title {
        font-size: 1.5rem;
        color: white;
        text-align: center; 
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