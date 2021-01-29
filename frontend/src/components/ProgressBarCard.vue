<template>
    <b-card :title="title" :style="{'--color': color}">
        <b-card-text>
            <b-progress  show-value :style="{'--color': color, '--value': this.value + '%'}" >                
                <b-progress-bar :value="value" max="100" :style="{'--color': color}" class=""></b-progress-bar>
            </b-progress>
        </b-card-text>
    </b-card>
</template>

<script>
export default {
    name: "ProgressBarCard",
    props: {
        value: Number,
        title: String,
        color: String,
        urlIcon: String
    }
}
</script>

<style lang="scss" scoped>
.card {
    width: 100%;
    margin: 0;
    border: none;
    background: transparent;
    &-title {
        color: $white;
        font-family: "Oswald", sans-serif;
        text-align: left;
    }
    &-text {
        position: relative;
        .progress {
            background-color: $white;
                &:after {
                    position: absolute;
                    content: url("../assets/logo-html-5.png");
                    transform: translate(-50%, -50%);
                    top: 0;
                    left: var(--value);
                }
            &-bar {
                align-items: flex-end;
                background-color: var(--color);
            }
        }
    }
}
@media (min-width: 320px) {
    .card {
        &-title {
            font-size: 1rem;
        }
        &-body {
            padding: 0.8rem;
        }
    }
}
@media (min-width: 576px) {
    .card {
        &-title {
            font-size: 1.3rem;
        }
        &-body {
            padding: 0.8rem;
        }
    }
}
@media (min-width: 576px) {
    .card {
        margin-bottom: 1rem;
        &-title {
            font-size: 1.3rem;
        }
        &-body {
            padding: 0.8rem;
        }
    }
}
</style>