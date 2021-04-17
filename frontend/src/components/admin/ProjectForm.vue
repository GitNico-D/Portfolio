<template>
  <b-row class="justify-content-center mt-5">
    <b-col cols md="12" lg="8" >
      <b-tabs
        active-nav-item-class="font-weight-bold text-uppercase text-success"
        active-tab-class="text-left text-white"
        align="center"
        class="mt-5"
        fill
        v-model="tabIndex">
        <b-tab class="mt-5 justify-content-center" lazy>
          <template #title>
            <font-awesome-icon icon="folder-plus" size="2x" class="pt-2 pr-2"/>
            Listes de tous les <span class="font-weight-bold font-style-italic">Projets</span>
          </template> 
          <h2 id="modifyForm-title" class="text-center fw-bold my-5">
            Tous les <span class="font-weight-bold font-style-italic">Projets</span>
          </h2>
          <div>
            <b-button @click="refreshTab" variant="info" class="m-2 btn-add"> 
              <font-awesome-icon icon="sync" class="mr-2" spin/>Rafraichir
            </b-button>
            <div id="alertModify">
              <AlertForm v-if="successMessage" :message="successMessage" variant="success"/>
              <AlertForm v-if="errorMessage" :message="errorMessage" variant="danger"/>
            </div>
            <div class="text-right mb-4">
              <Button action="Ajouter Projet" :color="projectColor" icon="plus" v-on:action="toAddProjectForm"/>
            </div>
            <b-table id="table-list" class="text-center" responsive hover no-collpase bordered dark :items="allProjects" :fields="fields">
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
                <Button action="Modifier" :color="projectColor" icon="edit" class="m-1" v-on:action="toModifyForm(row.item.id)"/>
                <Button action="Détail du projet" :color="detailButtonColor" icon="database" class="m-1" v-on:action="row.toggleDetails"/>
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
                    <p>Ajouté le : {{formatDate(row.item.createdAt)}}</p>
                    <p>Mise à jour le : {{formatDate(row.item.updatedAt)}}</p>
                  </b-card-body>
                    <b-card-text>
                      {{row.item.description }}
                    </b-card-text>
                    <Button action="Modifier" :color="projectColor" icon="edit" class="m-1" v-on:action="toModifyForm(row.item.id)"/>
                    <Button action="Supprimer" :color="deleteButtonColor" icon="trash-alt" class="m-1" v-on:action="onDelete(row.item.id)"/>
                  </b-card>
                </template>
            </b-table>
          </div>            
        </b-tab>
        <b-tab class="mt-5 justify-content-center">
          <template #title>
            <font-awesome-icon icon="folder-plus" size="2x" class="pt-2 pr-2"/>
            <span>Ajouter un nouveau projet</span>
          </template> 
          <AddProjectForm v-on:addProject="refreshTab" v-on:onReturn="returnToList"/>
        </b-tab>
        <b-tab class="mt-3 justify-content-center" lazy>
          <template #title>
            <font-awesome-icon icon="edit" size="2x" class="pt-2 pr-2"/>
            <span v-if="!projectId">Modifier le projet</span>
            <span v-else>Modification du projet {{ oneProject.id }}</span>
          </template>           
          <UpdateProjectForm v-on:onCancelModify="onCancelModify" v-on:onReturn="returnToList" v-on:showModifyProject="showModifyProject"/>
        </b-tab>
      </b-tabs>
    </b-col>
  </b-row>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import AlertForm from "@/components/form/AlertForm";
import AddProjectForm from "@/components/form/AddProjectForm"
import Button from "@/components/Button";
import UpdateProjectForm from "@/components/form/UpdateProjectForm"
import formatDate from "../../services/formatDate";

export default {
  name: "ProjectForm",
  components: { 
    AlertForm,
    AddProjectForm,
    UpdateProjectForm,
    Button
  },
  data() {
    return {
      projectColor : "#6d327c",
      detailButtonColor: "#BE8C2E",
      deleteButtonColor: "#ef233c",
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
      items: [],
      tabIndex: 0
    }
  },
  computed: {
    ...mapGetters(["oneProject", "allProjects"]),
  },
  methods: {
    ...mapActions(["getAllProjects", "deleteProject", "getProject", "resetStateProject"]),
    formatDate(date) {
      return formatDate(date);
    },
    refreshTab() {
      this.$store.dispatch("getAllProjects");
      // setTimeout(() => {
      //   this.tabIndex = 0;
      // }, 5000);
      // this.errorMessage = '';
      // this.successMessage = '';
    },
    onDelete(id) {
      this.deleteProject(id) 
        .then(() => {
          this.successMessage = 'Le projet ' + id + ' a bien été supprimé !';
          this.showProjectCard = false;
          this.$store.dispatch("getAllProjects");
          this.errorMessage = '';
          document.getElementById("alertModify").scrollIntoView(); 
        })
        .catch((error) => {   
          if(error.code == "404") {
            this.errorMessage = 'Le projet ' + id + ' n\'existe pas !';
            this.successMessage = '';
            this.showProjectCard = false;       
          }  
        }
      )
    },
    toModifyForm(data){
      this.projectId = data;
      this.getProject(this.projectId)
        .then(() => { 
          this.tabIndex = 2;
        })
        .catch((error) => {   
          if(error.code == "404") {
            this.errorMessage = 'Le projet ' + this.projectId  + ' n\'existe pas !';
            this.successMessage = '';
            this.showProjectCard = false;       
          }  
        })
    },
    toAddProjectForm() {
      this.tabIndex = 1
    },
    returnToList() {
      this.tabIndex = 0;
    },
    showModifyProject() {
      this.$store.dispatch("getAllProjects");
    },
    onCancelModify() {
      this.tabIndex = 0;
      this.resetStateProject()
    },
  }
}
</script>

<style lang="scss" scoped>
.btn {
  &-modify, &-add {
    background-color: $purple; 
    color: $white;
    border: 1px solid $purple;
    &:hover {
      color: $purple;
      background-color: transparent;
      border: 1px solid $purple;
    } 
    &:focus, &:active {
      color: $purple;
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
