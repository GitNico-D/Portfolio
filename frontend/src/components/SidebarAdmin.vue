<template>
  <div>
    <b-button v-b-toggle.sidebar>Toggle Sidebar</b-button>
    <b-sidebar id="sidebar" aria-labelledby="sidebar" no-header shadow>
      <template #default="{ hide }">
        <div class="p-3">
          <h4 class="sidebar-title my-2 font-weight-b">Administrateur</h4>
          <hr>
          <div class="my-5"><font-awesome-icon icon="user-shield" size="6x"/></div>
          <p>
            Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis
            in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.
          </p>
          <nav class="mb-4">
            <b-nav vertical>
              <b-nav-item type="button" active @click="hide">Active</b-nav-item>
              <b-nav-item href="#link-1" @click="hide">Link</b-nav-item>
              <b-nav-item href="#link-2" @click="hide">Another Link</b-nav-item>
            </b-nav>
          </nav>
          <b-button variant="primary" block @click="hide">Close Sidebar</b-button>
        </div>
      </template>
    </b-sidebar>
  </div>
</template>

<script>
export default {
  name: "Siderbar"
}
</script>

<style lang="scss">
.sidebar {
  background: $dark_gray;
  &-title{
    font-family: "Montserrat", sans-serif;

  }
}

</style>