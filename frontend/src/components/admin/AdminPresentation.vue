<template>
  <div>
    <b-jumbotron class="m-auto mb-3 text-white">
      <template #lead>
        Dans la zone d'administration vous avez la possibilité de gérér les
        ressources présentes sur l'API. Vous pouvez créer une nouvelle
        ressource, la modifier, la visionner ainsi que la supprimer.
      </template>
      <hr class="my-4" />
      <p class="jumbotron-body">
        Pour se rendre sur la section souhaitée, ouvrez la sidebar symbolisé par
        les flèches blanches et sélectionné la section de resource que vous
        souhaitez gérer.
      </p>
    </b-jumbotron>
  </div>
</template>

<script>
export default {
  name: "AdminPresentation"
};
</script>

<style lang="scss" scoped>
.jumbotron {
  width: 60%;
  background: transparent !important;
  font-family: "MontSerrat", sans-serif;
}
hr {
  background-color: $white;
}
@media(min-width: 320px) {
  .jumbotron {
    width: 100%;
    .lead {
      font-size: 0.9rem;
    }
    &-body {
      font-size: 0.7rem;
    }
  }
}
@media(min-width: 576px) {
  .jumbotron {
    width: 85%;
    .lead {
      font-size: 1rem;
    }
    &-body {
      font-size: 0.9rem;
    }
  }
}
@media(min-width: 768px) {
  .jumbotron {
    width: 70%;
    .lead {
      font-size: 1.2rem;
    }
    &-body {
      font-size: 1.1rem;
    }
  }
}
</style>
