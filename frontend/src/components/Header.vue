<template>
    <b-row>
        <b-navbar toggleable="sm">
        <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav :style="{ '--link-color': linkColor, '--action-color-link': actionColorLink}">
                    <router-link to="/projects">Projets</router-link><span :style="{'--span-color': spanColor}"> | </span>
                    <router-link to="/experiences">Expériences</router-link><span :style="{'--span-color': spanColor}"> | </span> 
                    <router-link to="/skills">Compétences</router-link><span :style="{'--span-color': spanColor}"> | </span>
                    <router-link to="/career">Carrières</router-link><span :style="{'--span-color': spanColor}"> | </span> 
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>
        <h1 :style="{'--text-color': textColor}" class="">{{ title }}</h1>
    </b-row>
</template>

<script>
export default {
    name: "Header",
    props: {
        linkColor: String,
        spanColor: String,
        actionColorLink: String,
        textColor: String,
        title: String
    }
}
</script>

<style lang="scss" scoped>
.row {
    height: 20vh;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    .navbar {
        width: 100%;
        &-nav {
            padding: 1rem;
            margin: auto;
            text-align: center;
            a {
                position: relative;
                font-family: 'Oswald', sans-serif;
                color: var(--link-color);
                text-transform: uppercase;
                transition: ease-out 0.2s;
                &::after {
                    position: absolute;
                    content: " ";
                    top: 100%;
                    left: 0;
                    width: 100%;
                    height: 3px;
                    background: var(--action-color-link);
                    transform: scaleX(0);
                    transform-origin: right;
                    transition: transform 0.5s;
                }
                &:hover::after {
                    transform: scaleX(1);
                    transform-origin: left;
                }
                &:hover {
                    color: var(--action-color-link);
                }
            }
            .router-link-exact-active {
                color: var(--action-color-link);
                &:hover {
                    color: $white;
                }
            }
            span {
                padding: 0 1rem 0 1rem;
                color: var(--action-color-link);
                font-weight: bold;
            }
            .indicator
            {
                position: absolute;
                left: 5%;
                bottom: 0;
                width: 30px;
                height: 3px;
                background-color: #fff;
                border-radius: 5px;
                transition: 0.2s ease left;
            }
            &-collapse {
                flex-direction: column;
            }
        }
        button {
            color: $white;
            background-color: $green!important;
            border: 1px solid var(--text-color)!important;
        }
    }
    h1 {
    @include customFont;
    text-shadow: 0 1px 0 var(--text-color),
        0 2px 0 var(--text-color), 
        0 3px 0 var(--text-color), 
        0 4px 0 var(--text-color), 
        0 5px 0 var(--text-color),
        0 6px 0 var(--text-color),
        0 7px 0 var(--text-color), 
        0 8px 0 var(--text-color), 
        0 9px 0 var(--text-color),
        0 50px 30px rgba(109, 50, 124, 0.3);
    color: $white;            
    text-transform: uppercase;
    }
}
@media (min-width: 320px) {
    .row {
        height: 25vh;
        h1 {
            font-size: 1.8rem!important;            
        }
        .navbar {
            button {
                margin: auto!important;
                margin-top: 1rem!important;
            } 
            &-nav {
                a {
                    margin-bottom: 0.5rem;
                }
                span {
                    display: none;
                }
            }   
        } 
    }
}
@media (min-width: 576px) {
    .row {
        h1 {
            font-size: 2.2rem!important;
        }
        .navbar {
            &-nav {
                span {
                    display: block;
                }
            }   
        }  
    }
}
@media (min-width: 576px) {
    .row {
        h1 {
            font-size: 2.8rem!important;
        }
    }
} 
</style>