<template>
    <b-nav :style="{ '--link-color': linkColor, '--link-color-active': actoveLink}">
        <router-link to="/"></router-link>
        <router-link to="/projects">Projets </router-link> |
        <router-link to="/experiences">Expériences |</router-link> | 
        <router-link to="/skills">Compétences </router-link> | 
        <router-link to="/career">Carrières</router-link> | 
    </b-nav>    
</template>

<script>
export default {
    name: "MenuNavigation",
    props: {
        linkColor: String,
        activeLink: String
    }
}
</script>

<style lang="scss">
.nav {
	padding: 30px;
}
.nav a {
	font-weight: bold;
	color: var(--link-color);
}
.nav a.router-link-exact-active {
	color: var(--link-color-active);
}
</style>