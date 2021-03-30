<template>
  <div>
  <b-jumbotron class="m-auto">
    <template #header>Administration</template>
    <template #lead>
      Dans la zone d'administration vous avez la possibilité de gérér les ressources présentes sur l'API.
      Vous pouvez créer une nouvelle ressource, la modifier, la visionner ainsi que la supprimer.
      
    </template>
    <hr class="my-4">
    <p>
      Pour celà ouvrer la barre de coté symbolisé par les flèches blanches et sélectionné la section de resource que vous souhaitez modifier.
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
  width: 80%;
  font-family: "MontSerrat", sans-serif;
}

</style>