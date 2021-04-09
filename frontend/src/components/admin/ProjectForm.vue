<template>
  <b-row class="justify-content-center mt-5">
    <b-col cols md="12" lg="8" >
      <b-tabs
        active-nav-item-class="font-weight-bold text-uppercase text-success"
        active-tab-class="text-left text-white"
        align="center"
        class="mt-5"
        fill>
        <b-tab class="mt-5 justify-content-center">
          <template #title>
            <font-awesome-icon icon="folder-plus" size="2x" class="pt-2 pr-2"/>
            <span>Listes de tous les Projets</span>
          </template> 
          <h2 id="modifyForm-title" class="text-center fw-bold my-5">
            Tous les <span class="font-weight-bold font-style-italic">Projets</span>
          </h2>
          <div>
            <b-table responsive hover no-collpase bordered dark :items="allProjects" :fields="fields">
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
                <b-button variant="info" @click="toModifyForm" class="m-1 p-2 btn-modify">
                  <font-awesome-icon icon="edit"/> Modifier
                </b-button>
                <b-button variant="info" @click="row.toggleDetails" class="m-1 p-2 btn-details">
                  <font-awesome-icon icon="database" /><span class="pl-2">Détail du projet</span>
                </b-button>
              </template>
                <template #row-details="row">
                  <b-card
                    :title="row.item.name"
                    :img-src="row.item.imgStatic"
                    :img-alt="row.item.altStatic"
                    img-top
                    class="mt-2 text-dark text-center"
                  >
                  <b-card-body class="text-left fst-italic">
                    <p>Ajouté le : {{row.item.createdAt}}</p>
                    <p>Mise à jour le : {{formatDate(row.item.updatedAt)}}</p>
                  </b-card-body>
                    <b-card-text>
                      {{row.item.description }}
                    </b-card-text>
                    <b-button variant="danger" class="m-2" @click="onDelete">Supprimer</b-button>
                  </b-card>
                </template>
            </b-table>
          </div>
            <div id="alertModify">
              <AlertForm v-if="successMessage" :message="successMessage" variant="success"/>
              <AlertForm v-if="errorMessage" :message="errorMessage" variant="danger"/>
            </div>
        </b-tab>
        <b-tab class="mt-5 justify-content-center">
          <template #title>
            <font-awesome-icon icon="folder-plus" size="2x" class="pt-2 pr-2"/>
            <span>Ajouter un nouveau projet</span>
          </template> 
          <AddProjectForm />
        </b-tab>
        <b-tab class="mt-3 justify-content-center">
          <template #title>
            <font-awesome-icon icon="edit" size="2x" class="pt-2 pr-2"/>
            <span v-if="!projectId">Modifier un projet</span>
            <span v-else>Modifier le projet {{ oneProject.id }}</span>
          </template>           
          <UpdateProjectForm />
        </b-tab>
      </b-tabs>
    </b-col>
  </b-row>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import AlertForm from "@/components/form/AlertForm";
import AddProjectForm from "@/components/form/AddProjectForm"
import UpdateProjectForm from "@/components/form/UpdateProjectForm"
import formatDate from "../../services/formatDate";
// import { setFormWithFile } from "../mixins/formMixin";

export default {
  name: "ProjectForm",
  components: { 
    AlertForm,
    AddProjectForm,
    UpdateProjectForm
  },
  data() {
    return {
      loading: false,
      showProjectCard: false,
      successMessage: '',
      errorMessage: '',
      projectId: '',
      fields: [
        {
          key: 'id',
          label: 'Id',
        },
        { 
          key: "name",
          label: "Nom",
        },
        {
          key: "creationDate",
          label: "Date de création"
        },
        {
          key: "createdAt",
          label: "Date d'ajout",
        },
        {
          key: "updatedAt",
          label: "Date de modification",
        },
        {
          key: 'actions', 
          label: 'Actions' 
        }
      ],
      items: []
    }
  },
  // mixins : [ setFormWithFile ],
  computed: {
    ...mapGetters(["oneProject", "allProjects"]),
  },
  methods: {
    ...mapActions(["deleteProject", "getProject", "resetStateProject"]),
    formatDate(date) {
      return formatDate(date);
    },
    fetchProject() {      
      this.getProject(this.projectId)
        .then(() => {
          this.successMessage = 'Voici le projet ' + this.projectId + ' !' 
          this.showProjectCard = true;
          console.log(this.showProjectCard);
          document.getElementById("alertModify").scrollIntoView();  
          this.errorMessage = '';
        })
        .catch((error) => {   
          console.log(this.projectId);
          if(error.code == "404") {
            this.errorMessage = 'Le projet ' + this.projectId  + ' n\'existe pas !';
            this.successMessage = '';
            this.loading = false;
            this.showProjectCard = false;       
          }  
        })
    },
    onDelete() {
      console.log(this.projectId);
      this.deleteProject(this.projectId) 
        .then(() => {
          console.log(this.projectId);
          this.successMessage = 'Le projet ' + this.projectId  + ' a bien été supprimé !';
          this.showProjectCard = false;
          this.resetStateProject();
          document.getElementById("alertModify").scrollIntoView(); 
        })
        .catch((error) => {   
          if(error.code == "404") {
            this.errorMessage = 'Le projet ' + this.projectId  + ' n\'existe pas !';
            this.successMessage = '';
            this.loading = false;
            this.showProjectCard = false;       
          }  
        }
      )
    },
    toFetchProject() {
      this.showProjectCard = false;
      document.getElementById("modifyForm-title").scrollIntoView(); 
      this.resetStateProject();
      this.successMessage = '';
    },
  }
}
</script>

<style lang="scss" scoped>
table {
  color: $white;
  tr {
    padding: 1rem;
  }
  .table-hover {
    tbody {
      tr {
        &:hover {
          color: $purple!important;
        }
      }
    }
  }
}
.btn {
  &-modify {
    background-color: $purple; 
    color: $white;
    border: 1px solid $purple;
    &:hover {
      color: $white;
      background-color: transparent;
      border: 1px solid $purple;
    } 
    &:focus, :active {
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
form {
  width: 90%;
  margin: auto;
  padding: 1.5rem;
}
.form-group {
  margin-bottom: 2rem;
}
.custom-file-label {
  background-color: transparent!important;
  color: $white;
  border: unset;
  border-bottom: 1px solid $white;
  border-radius: unset;
  &:focus {
    @include box_shadow(0px, 0px, 5px, $purple);
    background-color: transparent;
    border-bottom: 1px solid $purple;
  }
}
.form-control {
  background-color: transparent;
  color: $white;
  border: unset;
  border-bottom: 1px solid $white;
  border-radius: unset;
  &:focus {
    @include box_shadow(0px, 0px, 5px, $purple);
    background-color: transparent;
    border-bottom: 1px solid $purple;
    color: $white;
  }
}
.nav-link {
  color: $white!important;
}
.tabs {
  font-family: "Oswald", sans-serif;
  letter-spacing: 1px;
}
</style>
