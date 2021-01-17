<template>
    <b-nav :style="{ '--link-color': linkColor, '--action-color-link': actionColorLink}">
        <router-link to="/"></router-link>
        <router-link to="/projects">Projets</router-link><span :style="{'--span-color': spanColor}"> | </span>
        <router-link to="/experiences">Expériences</router-link><span :style="{'--span-color': spanColor}"> | </span> 
        <router-link to="/skills">Compétences</router-link><span :style="{'--span-color': spanColor}"> | </span>
        <router-link to="/career">Carrières</router-link><span :style="{'--span-color': spanColor}"> | </span> 
        <div class="active-indicator"></div>
    </b-nav>    
</template>

<script>
export default {
    name: "MenuNavigation",
    props: {
        linkColor: String,
        spanColor: String,
        actionColorLink: String
    }
}
</script>

<style lang="scss">
.nav {
    padding: 1rem;
    margin-left: 1rem;
    a {
        position: relative;
        font-family: 'Oswald', sans-serif;
        font-size: 1rem;
        line-height: 1.6rem;        
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
}
</style>