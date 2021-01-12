<template>
    <b-card :title={title}>
        <div class="face face1">
            <div class="content">           
                <h3>{{ title }}</h3>
            </div>
        </div>
        <div class="face face2">
            <b-card-text class="content">
                <p> {{ content }} </p>
                <router-link class="btn">Read More</router-link>
            </b-card-text>
        </div>
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
    width:300px;
    height: 200px;
    .card-body {
        .face {
            transition:.4s;
            
        .face1 {
            position: relative;
            background: $dark-gray;
            display: flex;
            justify-content: center;
            align-content:center;
            align-items: center;
            z-index: 1;
            transform: translateY(100px);
            .content {
                opacity: .2;
                transition:  0.5s;
                text-align: center;
                h3 {
                    font-size: 1em;
                    color: white;
                    text-align: center; 
                }
                a {
                    transition: .5s;
                }
            }
            &:hover {
                opacity: 1;
            }
            &:hover {
                transform: translateY(0);
                box-shadow:
                inset 0 0 60px whitesmoke,
                inset 20px 0 80px #f0f,
                inset -20px 0 80px #0ff,
                inset 20px 0 300px #f0f,
                inset -20px 0 300px #0ff,
                0 0 50px #fff,
                -10px 0 80px #f0f,
                10px 0 80px #0ff;
            }
            }
        } 
        .face2 {
            position: relative;
            background: whitesmoke;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            box-sizing: border-box;
            box-shadow: 0 20px 50px rgba(0,0,0,.8);
            transform: translateY(-100px);
            &:hover {
                transform: translateY(0);
            }
            .content {
                p, a {
                    font-size: 10pt;
                    margin: 0 ;
                    padding: 0;
                    color:#333;
                }
                a {
                    text-decoration:none;
                    color: black;
                    box-sizing: border-box;
                    outline : 1px dashed #333;
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
        }
    }
}

</style>