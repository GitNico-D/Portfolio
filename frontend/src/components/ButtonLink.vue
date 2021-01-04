<template>
	<b-button size="lg" class="customButton">
			{{ action }}
	</b-button>
</template>

<script>
export default {
	name: "ButtonLink",
	props: {
		action: String,
		url: String
	}
}
</script>

<style lang="scss">

.customButton {
	border-radius: 50px!important;
	border: 1px solid $light-blue!important;
	width: 180px;
	height: 50px;
	letter-spacing: 0.050rem;
	background-color: $light-blue!important;
	box-shadow: 10px 10px 14px 1px rgba(00,00,00,0.2);
	font-size: 0.9rem!important;
	text-transform: uppercase;
	cursor: pointer;
	&:hover {
		box-shadow: unset;
	}
}
</style>