<template>
  <b-row class="justify-content-center mt-5">
    <b-col cols md="10" lg="9" class="padding-col-md">
      <b-tabs
        active-nav-item-class="font-weight-bold text-uppercase text-success"
        active-tab-class="text-left text-white"
        align="center"
        class="mt-5"
        fill
        v-model="tabIndex"
        small
      >
        <b-tab class="mt-5 justify-content-center" lazy>
          <template #title>
            <font-awesome-icon icon="folder-plus" size="2x" class="pt-2 pr-2"/>
            Listes de tous les
            <span class="font-weight-bold font-style-italic">Projets</span>
          </template>
          <h2 id="modifyForm-title" class="text-center fw-bold my-5 tab-project-title">
            Tous les
            <span class="font-weight-bold font-style-italic">Projets</span>
          </h2>
          <div>
            <div class="btn-refresh-position">
              <b-button @click="refreshTab" variant="info" class="m-2 btn-add">
                <font-awesome-icon icon="sync" class="mr-2" spin />Rafraichir
              </b-button>
            </div>
            <div id="alertModify">
              <AlertForm
                v-if="successMessage"
                :message="successMessage"
                variant="success"
              />
              <AlertForm
                v-if="errorMessage"
                :message="errorMessage"
                variant="danger"
              />
            </div>
            <div class="btn-add-position mb-4">
              <Button
                action="Ajouter Projet"
                :color="projectColor"
                icon="plus"
                v-on:action="toProjectForm(null, 'create')"
              />
            </div>
            <b-table
              id="table-list"
              class="text-center"
              responsive
              hover
              no-collpase
              bordered
              dark
              :items="allProjects"
              :fields="fields"
              stacked="sm"
            >
              <b-thead class="p-5"></b-thead>
              <template #cell(creationDate)="data">
                {{ formatDate(data.value) }}
              </template>
              <template #cell(createdAt)="data">
                {{ formatDate(data.value) }}
              </template>
              <template #cell(updatedAt)="data">
                {{ formatDate(data.value) }}
              </template>
              <template #cell(actions)="row">
                <Button
                  action="Modifier"
                  :color="projectColor"
                  icon="edit"
                  class="m-1"
                  v-on:action="toProjectForm(row.item.id, 'update')"
                />
                <Button
                  action="Détail du projet"
                  :color="detailButtonColor"
                  icon="database"
                  class="m-1"
                  v-on:action="row.toggleDetails"
                />
              </template>
              <template #row-details="row" class="m-auto">
                <b-card
                  :title="row.item.name"
                  :img-src="row.item.imgStatic"
                  :img-alt="row.item.altStatic"
                  img-top
                  class="mt-2 text-dark text-center"
                >
                  <b-card-body class="text-left fst-italic">
                    <p>Ajouté le : {{ formatDate(row.item.createdAt) }}</p>
                    <p>Mise à jour le : {{ formatDate(row.item.updatedAt) }}</p>
                  </b-card-body>
                  <b-card-text>
                    {{ row.item.description }}
                  </b-card-text>
                  <Button
                    action="Modifier"
                    :color="projectColor"
                    icon="edit"
                    class="m-1"
                    v-on:action="toProjectForm(row.item.id, 'update')"
                  />
                  <Button
                    action="Supprimer"
                    :color="deleteButtonColor"
                    icon="trash-alt"
                    class="m-1"
                    v-on:action="onDelete(row.item.id)"
                  />
                </b-card>
              </template>
            </b-table>
          </div>
        </b-tab>
        <b-tab class="mt-5 justify-content-center">
          <template v-if="!projectId" #title>
            <font-awesome-icon icon="folder-plus" size="2x" class="pt-2 pr-2" />
            <span>Ajouter un nouveau projet</span>
          </template>
          <template v-else #title>
            <font-awesome-icon icon="edit" size="2x" class="pt-2 pr-2" />
            <span>Modification du projet {{ oneProject.id }}</span>
          </template>
          <ProjectForm
            :methodAction="methodAction"
            v-on:onAction="showProjects"
            v-on:onCancel="onCancel"
            v-on:onReturn="returnToList"
          />
        </b-tab>
      </b-tabs>
    </b-col>
  </b-row>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import AlertForm from "@/components/form/AlertForm";
import ProjectForm from "@/components/form/ProjectForm";
import Button from "@/components/Button";
import formatDate from "../../services/formatDate";

export default {
  name: "ProjectList",
  components: {
    AlertForm,
    ProjectForm,
    Button
  },
  data() {
    return {
      projectColor: "#6d327c",
      detailButtonColor: "#BE8C2E",
      deleteButtonColor: "#ef233c",
      loading: false,
      showProjectCard: false,
      successMessage: "",
      errorMessage: "",
      projectId: "",
      methodAction: "",
      fields: [
        {
          key: "id",
          label: "Id"
        },
        {
          key: "name",
          label: "Nom"
        },
        {
          key: "creationDate",
          label: "Date de création"
        },
        {
          key: "createdAt",
          label: "Date d'ajout"
        },
        {
          key: "updatedAt",
          label: "Date de modification"
        },
        {
          key: "actions",
          label: "Actions"
        }
      ],
      items: [],
      tabIndex: 0
    };
  },
  computed: {
    ...mapGetters(["oneProject", "allProjects"])
  },
  methods: {
    ...mapActions([
      "getAllProjects",
      "deleteProject",
      "getProject",
      "resetStateProject"
    ]),
    formatDate(date) {
      return formatDate(date);
    },
    //Refresh button to reset page, form data and retrieve the new data added
    refreshTab() {
      this.$store.dispatch("getAllProjects");
      this.successMessage = "";
      this.errorMessage = "";
      this.resetStateProject()
      this.methodAction = ''
      this.projectId = ''
    },
    //Delete the project defined by the id
    onDelete(id) {
      this.deleteProject(id)
        .then(() => {
          this.successMessage = "Le projet " + id + " a bien été supprimé !";
          this.showProjectCard = false;
          this.$store.dispatch("getAllProjects");
          this.errorMessage = "";
          document.getElementById("alertModify").scrollIntoView();
        })
        .catch(error => {
          if (error.data[0]) {
            this.errorMessage = error.data[0].message;
          } else {
            this.errorMessage = error.data.message;
          }
          this.successMessage = "";
        });
    },
    //Render the project form according to the method action = 'create' ou 'update'
    //In case of update the id of the project, in case of create project id set to null
    toProjectForm(id, methodAction) {
      this.projectId = id;
      this.methodAction = methodAction;
      if (methodAction == "create") {
        this.tabIndex = 1;
      } else {
        this.getProject(this.projectId)
          .then(() => {
            this.tabIndex = 1;
          })
          .catch(error => {
            if (error.data[0]) {
              this.errorMessage = error.data[0].message;
            } else {
              this.errorMessage = error.data.message;
            }
            this.successMessage = "";
          });
      }
    },
    //On action of the project form button, return to the tab project list
    returnToList() {
      this.tabIndex = 0;
    },
    //On action of the project form button, reset or update some data
    showProjects() {
      this.$store.dispatch("getAllProjects");
      this.successMessage = "";
      this.errorMessage = "";
      this.methodAction = ''
      this.projectId = ''
    },
    //On action of the project form button, reset some data
    onCancel() {
      this.tabIndex = 0;
      this.projectId = "";
      this.resetStateProject();
    }
  }
};
</script>

<style lang="scss" scoped>
.btn {
  &-modify,
  &-add {
    background-color: $purple;
    color: $white;
    border: 1px solid $purple;
    &:hover {
      color: $purple;
      background-color: transparent;
      border: 1px solid $purple;
    }
    &:focus,
    &:active {
      color: $white;
      box-shadow: unset;
      border: 1px solid $purple;
      background-color: $purple;
    }
  }
}
.card {
  &-body {
    background-color: transparent;
  }
}
.row {
  height: unset;
}
.nav-link {
  color: $white !important;
}
.tabs {
  font-family: "Oswald", sans-serif;
  letter-spacing: 1px;
}
@media (min-width: 320px) {
  .btn {
    &-refresh {
      &-position {
        text-align: center;
      }
    }
    &-add {
      &-position {
        text-align: center;
      }
    }
  }
  .padding-col-md {
    padding-right: 2.1rem;
    padding-left: 2.1rem;
  }
  .tab-project-title {
    font-size: 1.2rem;
  }
}
@media (min-width: 576px) {
  .btn {
    &-refresh {
      &-position {
        text-align: left;
      }
    }
    &-add {
      &-position {
        text-align: right;
      }
    }
  }
  .padding-col-md {
    padding-right: 2.1rem;
    padding-left: 2.1rem;
  }
  .tab-project-title {
    font-size: 1.5rem;
  }
}
@media (min-width: 768px) {
  .btn {
    &-refresh {
      &-position {
        text-align: left;
      }
    }
    &-add {
      &-position {
        text-align: right;
      }
    }
  }
  .padding-col-md {
    padding-right: inherit;
    padding-left: inherit;
  }
  .tab-project-title {
    font-size: 2rem;
  }
}
</style>
