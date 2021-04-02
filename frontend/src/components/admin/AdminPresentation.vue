<template>
  <div>
  <b-jumbotron class="m-auto mb-3 text-white">
    <template #lead>
      Dans la zone d'administration vous avez la possibilité de gérér les ressources présentes sur l'API.
      Vous pouvez créer une nouvelle ressource, la modifier, la visionner ainsi que la supprimer.
      
    </template>
    <hr class="my-4">
    <p>
      Pour se rendre sur la section souhaitée, ouvrez la sidebar symbolisé par les flèches blanches et sélectionné la section de resource que vous souhaitez gérer.
    </p>
  </b-jumbotron>
</div>
</template>

<script>
export default {
  name: "AdminPresentation"
}
</script>

<style lang="scss" scoped>
.jumbotron {
  width: 60%;
  background: transparent!important;
  font-family: "MontSerrat", sans-serif;
}
hr {
  background-color: $white;
}

</style>