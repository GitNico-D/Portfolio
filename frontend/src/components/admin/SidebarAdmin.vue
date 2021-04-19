<template>
  <div>
    <b-button v-b-toggle.sidebar class="btn-toggle position-absolute">
      <font-awesome-icon icon="angle-double-right" size="2x" />
    </b-button>
    <b-sidebar id="sidebar" aria-labelledby="sidebar" no-header backdrop>
      <template #default="{ hide }">
        <div class="p-3">
          <h4 class="sidebar-title my-2 font-weight-b">Administrateur</h4>
          <hr />
          <div class="my-5">
            <font-awesome-icon icon="user-shield" size="6x" />
          </div>
          <b-list-group-item
            button
            :style="{ '--bg-color': '#BE8C2E' }"
            class="my-3 btn-overview"
            @click="
              {
                $emit('returnToOverview', '#BE8C2E');
              }
            "
            v-b-toggle.sidebar
          >
            Tableau de bord
          </b-list-group-item>
          <b-list-group>
            <b-list-group-item
              button
              :style="{ '--bg-color': '#6d327c' }"
              class="my-3 btn-project"
              @click="
                {
                  $emit('showProjectForm', '#6d327c');
                }
              "
              v-b-toggle.sidebar
            >
              Section Projet
            </b-list-group-item>
            <b-list-group-item
              button
              :style="{ '--bg-color': '#00a1ba' }"
              class="my-3 btn-career"
              @click="
                {
                  $emit('showCareerForm', '#00a1ba');
                }
              "
              v-b-toggle.sidebar
            >
              Section Carrières
            </b-list-group-item>
            <b-list-group-item
              button
              :style="{ '--bg-color': '#36C486' }"
              class="my-3 btn-skill"
              @click="
                {
                  $emit('showSkillForm', '#36C486');
                }
              "
              v-b-toggle.sidebar
            >
              Section Compétences
            </b-list-group-item>
            <b-list-group-item
              button
              :style="{ '--bg-color': '#485DA6' }"
              class="my-3 btn-presentation"
              @click="$emit('showPresentationForm', '#485DA6')"
              v-b-toggle.sidebar
            >
              Section Présentation
            </b-list-group-item>
          </b-list-group>
          <b-button variant="primary" class="mt-5 btn-close" block @click="hide"
            >Fermer</b-button
          >
        </div>
      </template>
    </b-sidebar>
  </div>
</template>

<script>
export default {
  name: "Siderbar"
};
</script>

<style lang="scss" scoped>
.sidebar {
  background: $dark_gray;
  &-title {
    font-family: "Montserrat", sans-serif;
  }
}
.list-group-item {
  color: $dark-gray !important;
  font-family: "Oswald", sans-serif;
  &.active {
    background: var(--bg-color) !important;
    color: $white !important;
    border: none;
  }
  &-action {
    border-radius: unset !important;
    border: 1px solid $dark_gray !important;
    &:active,
    &:focus {
      color: $white !important;
      border: none;
      background: var(--bg-color) !important;
    }
  }
}
.btn {
  &-toggle {
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    background-color: transparent;
    border-left: none;
    @include box_shadow(4px, 4px, 1px, $white);
    &:hover {
      background: $white;
      color: $dark-gray;
      @include box_shadow(0px, 0px, 6px, $white);
    }
    &:focus {
      background-color: transparent;
      color: $white;
      border-color: $white;
      @include box_shadow(0px, 0px, 6px, $white);
    }
  }
  &-close {
    background: $dark-gray !important;
    border: 1px solid $dark-gray;
    &:hover {
      background: $white !important;
      border: 1px solid $dark-gray;
      color: $dark-gray;
    }
  }
  &-overview,
  &-project,
  &-career,
  &-skill,
  &-presentation {
    &:hover {
      background-color: var(--bg-color);
      color: $white !important;
    }
  }
}
</style>
