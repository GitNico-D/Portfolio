<template>
	<b-button size="md" variant="info">
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

<style>

</style>