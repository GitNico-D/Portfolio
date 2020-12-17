<template>
	<div id="app">
		<nav id="nav">
			<router-link to="/">Homepage | </router-link>
			<router-link to="/about">About</router-link>
		</nav>
	<router-view />
	</div>
</template>

<style lang="scss">
#app {
	font-family: Avenir, Helvetica, Arial, sans-serif;
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
	text-align: center;
	color: #2c3e50;
}

body {
	background-image: linear-gradient(to right top, #6d327c, #485DA6, #00a1ba, #00BF98, #36C486);

}

#nav {
	padding: 30px;
	a {
		font-weight: bold;
		color: #2c3e50;
		&.router-link-exact-active {
			color: #42b983;
		}
	}
}
</style>
