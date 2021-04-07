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
            <span>Récupérer un projet</span>
          </template> 
          <h2 id="modifyForm-title" class="text-center fw-bold my-5">
            Pour récupérer un <span class="font-weight-bold font-style-italic">Projet</span> 
            existant entrer son ID dans le champ ci-dessous
          </h2>
          <ValidationObserver ref="recoverForm" v-slot="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(fetchProject)" >
              <ValidationProvider ref="id" rules="required|numeric" name="ID du projet" v-slot="{ errors }">
                <b-form-group id="id">
                  <label for="input-id" class="text-uppercase">ID du projet</label>
                  <b-form-input 
                    id="input-id" 
                    v-model="projectId"
                    placeholder="Entrer ID" 
                    required>
                  </b-form-input>
                  <b-alert
                    variant="danger"
                    v-if="errors[0]"
                    v-text="errors[0]"
                    show
                  >
                  </b-alert>
                </b-form-group>
              </ValidationProvider>
              <div class="d-flex justify-content-center">
                <b-button type="submit" variant="success" class="m-3" :disabled="loading">
                  <b-spinner v-show="loading" label="Spinning" class="pt-4"></b-spinner>
                  <span class="pl-2 pb-2">Récupérer projet {{ projectId }}</span>
                </b-button>
              </div>
            </b-form>
            <div id="alertModify">
              <AlertForm v-if="successMessage" :message="successMessage" variant="success"/>
              <AlertForm v-if="errorMessage" :message="errorMessage" variant="danger"/>
            </div>
            <b-card
              :title="oneProject.name + ' ' + oneProject.id"
              :img-src="oneProject.imgStatic"
              :img-alt="oneProject.altStatic"
              img-top
              class="mt-2 text-dark text-center"
              v-show="showProjectCard && oneProject.id"
            >
            <b-card-body class="text-left fst-italic">
              <p>Ajouté le : {{oneProject.createdAt}}</p>
              <p>Mise à jour le : {{oneProject.updatedAt}}</p>
            </b-card-body>
              <b-card-text>
                {{oneProject.description }}
              </b-card-text>
              <b-button variant="primary" class="m-2" @click="toModifyForm">Modifier</b-button>
              <b-button variant="danger" class="m-2" @click="onDelete">Supprimer</b-button>
              <b-button type="reset" variant="info" class="m-2" @click="toFetchProject">
                  Récupérer un autre projet
              </b-button>
            </b-card>
          </ValidationObserver>
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
import { ValidationProvider, ValidationObserver } from "vee-validate";
import { mapActions, mapGetters } from "vuex";
import AlertForm from "@/components/form/AlertForm";
import AddProjectForm from "@/components/form/AddProjectForm"
import UpdateProjectForm from "@/components/form/UpdateProjectForm"
// import { setFormWithFile } from "../mixins/formMixin";

export default {
  name: "AllProjectForm",
  components: { 
    ValidationProvider,
    ValidationObserver,
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
      projectId: ''
    }
  },
  // mixins : [ setFormWithFile ],
  computed: {
    ...mapGetters(["oneProject"])
  },
  methods: {
    ...mapActions(["deleteProject", "getProject", "resetStateProject"]),
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
    toModifyForm() {
      console.log(document.getElementById("__BVID__62___BV_tab_button__"));
      document.getElementById("__BVID__62___BV_tab_button__").classList.add('active');
    }
  }
}
</script>

<style lang="scss" scoped>
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
