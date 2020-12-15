<template>
    <div>
        <b-button size="md" variant="info">
            {{ action }}
        </b-button>
    </div>
</template>

<script>
export default {
    name: "BottomButton",
    props: {
        action : String
    }    
}
</script>