<template>
  <b-row class="justify-content-center mt-5">
    <b-col cols="8">
      <b-tabs
        active-nav-item-class="font-weight-bold text-uppercase text-success"
        active-tab-class="text-left text-white"
        align="center"
        class="mt-5"
        fill>
        <b-tab class="mt-5 justify-content-center">
          <template #title>
            <font-awesome-icon icon="folder-plus" size="2x" class="pt-2 pr-2"/>
            <span>Ajouter un nouveau projet</span>
          </template> 
          <div id="alert">
            <AlertForm v-if="successMessage" :message="successMessage" variant="success"/>
            <AlertForm v-if="errorMessage" :message="errorMessage" variant="danger"/>
          </div>
          <ValidationObserver ref="addForm" v-slot="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(onCreate)" @reset.prevent="onReset" >
              <ValidationProvider ref="name" rules="required|min:2" name="Titre" v-slot="{ errors }">
                <b-form-group id="name">
                  <label for="input-name" class="text-uppercase">Titre du projet</label>
                  <b-form-input 
                    id="input-name" 
                    v-model="newProject.name" 
                    placeholder="Entrer nom du projet">
                  </b-form-input>
                  <b-alert
                    variant="danger"
                    v-if="errors[0]"
                    v-text="errors[0]"
                    show>
                  </b-alert>
                </b-form-group>
              </ValidationProvider>
              <ValidationProvider ref="description" rules="required|min:2" name="Description" v-slot="{ errors }">
                <b-form-group id="textarea">
                  <label for="input-textarea" class="text-uppercase">Description du projet</label>
                  <b-form-textarea
                    id="input-textarea"
                    v-model="newProject.description"
                    placeholder="Entrer description"
                    size="lg">
                    </b-form-textarea>
                  <b-alert
                    variant="danger"
                    v-if="errors[0]"
                    v-text="errors[0]"
                    show
                    dismissible>
                  </b-alert>
                </b-form-group>
              </ValidationProvider>
              <ValidationProvider ref="url" rules="required|url" name="Url" v-slot="{ errors }">
                <b-form-group id="url" class="mt-4">
                  <label for="input-url" class="text-uppercase">Url du projet</label>
                  <b-form-input
                    id="input-url"
                    v-model="newProject.url"
                    placeholder="Entrer url du projet">
                  </b-form-input>
                  <b-alert
                    variant="danger"
                    v-if="errors[0]"
                    v-text="errors[0]"
                    show
                    dismissible>
                  </b-alert>
                </b-form-group>
              </ValidationProvider>
              <ValidationProvider ref="imgStatic" rules="required" name="Image" v-slot="{ errors }">
                <b-form-group id="imgStatic" class="mt-4">
                  <label for="input-imgStatic" class="text-uppercase">Image de présentation du projet</label>
                  <b-form-file
                    id="input-imgStatic"
                    name="imgStatic"
                    v-model="newProject.imgStatic"
                    :state="Boolean(newProject.imgStatic)"
                    browse-text="Parcourir"
                    placeholder="Choisir un fichier ou glisser-déposer ici"
                    drop-placeholder="Choisir un fichier"
                  ></b-form-file>
                <b-alert
                  variant="danger"
                  v-if="errors[0]"
                  v-text="errors[0]"
                  show
                  dismissible>
                </b-alert>
                <div class="mt-3">Fichier sélectionné: {{ newProject.imgStatic ? newProject.imgStatic.name : '' }}</div>
                
                </b-form-group>
              </ValidationProvider>
              <ValidationProvider ref="description-image" rules="required|min:2" name="Description de l'image" v-slot="{ errors }">
                <b-form-group id="altStatic" class="mt-5 text">
                  <label for="input-altStatic" class="text-uppercase">Description de l'image du projet</label>
                  <b-form-input 
                    id="input-altStatic" 
                    v-model="newProject.altStatic" 
                    placeholder="Entrer description" 
                    >
                  </b-form-input>
                  <b-alert
                    variant="danger"
                    v-if="errors[0]"
                    v-text="errors[0]"
                    show
                    dismissible>
                  </b-alert>
                </b-form-group>
              </ValidationProvider>
              <ValidationProvider ref="creation-date" rules="required" name="Date de création " v-slot="{ errors }">
                <b-form-group id="creation-date" class="mt-4">
                  <label for="input-creation-date" class="text-uppercase">Date de création du projet</label>
                  <b-form-datepicker id="creation-date" v-model="newProject.creationDate" class="mb-2" placeholder="Choisir une date"></b-form-datepicker>
                  <p>Date de création: '{{ newProject.creationDate }}'</p>
                </b-form-group>
                  <b-alert
                    variant="danger"
                    v-if="errors[0]"
                    v-text="errors[0]"
                    show
                    dismissible>
                  </b-alert>
              </ValidationProvider>
              <div class="d-flex justify-content-center">
                <b-button type="submit" variant="success" class="m-3 p-3" :disabled="loading">
                  <b-spinner v-show="loading" label="Spinning" class="pt-4 p"></b-spinner>
                  <span class="pl-2 pb-2">Ajouter projet</span>
                </b-button>
                <b-button type="reset" variant="danger" class="m-3 p-3" @click="onReset">
                  Réinitialiser formulaire
                </b-button>
              </div>
            </b-form>
            <b-card class="mt-3" header="Form Data Result">
              <pre class="m-0">{{ newProject }}</pre>
            </b-card>
          </ValidationObserver>
        </b-tab>
        <b-tab class="mt-3 justify-content-center">
          <template #title>
            <font-awesome-icon icon="edit" size="2x" class="pt-2 pr-2"/>
            <span>Modifier un projet</span>
          </template> 
          <ValidationObserver ref="recoverForm" v-slot="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(recoverProject)" v-show="recoverForm">
              <ValidationProvider ref="id" rules="required|numeric" name="ID du projet" v-slot="{ errors }">
                <b-form-group id="id" label="ID du projet" label-for="input-id" class="mt-4 text-uppercase">
                  <b-form-input 
                    id="input-id" 
                    v-model="modifyProject.id"
                    placeholder="Entrer ID" 
                    required>
                  </b-form-input>
                  <b-alert
                    variant="danger"
                    v-if="errors[0]"
                    v-text="errors[0]"
                    show
                    dismissible>
                  </b-alert>
                </b-form-group>
              </ValidationProvider>
              <div class="d-flex justify-content-center">
                <b-button type="submit" variant="success" class="m-3" :disabled="loading">
                  <b-spinner v-show="loading" label="Spinning" class="pt-4"></b-spinner>
                  <span class="pl-2 pb-2">Récupérer projet {{ modifyProject.id }}</span>
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
              v-show="showProjectCard"
            >
            <b-card-body class="text-left fst-italic">
              <p>Ajouté le : {{oneProject.createdAt}}</p>
              <p>Mise à jour le : {{oneProject.updatedAt}}</p>
            </b-card-body>
              <b-card-text>
                {{oneProject.description }}
              </b-card-text>
              <b-button variant="primary" class="m-2" @click="fillForm">Modifier</b-button>
              <b-button variant="danger" class="m-2" @click="onDelete">Supprimer</b-button>
            </b-card>
          </ValidationObserver>
          <h2 id="modifyForm-title" class="text-center fw-bold mt-5" v-show="modifyForm">Modification du project {{ oneProject.id }}</h2>
          <ValidationObserver ref="modifyForm" v-slot="{ handleSubmit }" v-show="modifyForm">
            <b-form @submit.prevent="handleSubmit(onModify)" @reset.prevent="onReset" >
              <ValidationProvider ref="name" rules="required|min:2" name="Titre" v-slot="{ errors }">
                <b-form-group id="name" label="Nouveau titre du projet" label-for="input-name" class="mt-4">
                  <b-form-input 
                    id="input-name" 
                    v-model="modifyProject.name"
                    value="gfgfgf">
                  </b-form-input>
                  <b-alert
                    variant="danger"
                    v-if="errors[0]"
                    v-text="errors[0]"
                    show>
                  </b-alert>
                </b-form-group>
              </ValidationProvider>
              <ValidationProvider ref="description" rules="required|min:2" name="Description" v-slot="{ errors }">
                <b-form-group id="textarea" label="Nouvelle description du projet" label-for="input-textarea" class="mt-4">
                  <b-form-textarea
                    id="input-textarea"
                    v-model="modifyProject.description"
                    size="lg">
                    </b-form-textarea>
                  <b-alert
                    variant="danger"
                    v-if="errors[0]"
                    v-text="errors[0]"
                    show
                    dismissible>
                  </b-alert>
                </b-form-group>
              </ValidationProvider>
              <ValidationProvider ref="url" rules="required|url" name="Url" v-slot="{ errors }">
                <b-form-group id="url" label="Nouvelle Url du projet" label-for="input-url" class="mt-4">
                  <b-form-input
                    id="input-url"
                    v-model="modifyProject.url"
                    :placeholder="oneProject.url">
                  </b-form-input>
                  <b-alert
                    variant="danger"
                    v-if="errors[0]"
                    v-text="errors[0]"
                    show
                    dismissible>
                  </b-alert>
                </b-form-group>
              </ValidationProvider>
              <ValidationProvider name="image-name" v-slot="{ errors }">
                <b-form-group id="image" label="Image du projet" label-for="input-image" class="mt-4" v-show="checkboxStatus == 'not_change'">
                  <b-form-input
                    id="input-image"
                    :placeholder="oneProject.imgStatic"
                    size="lg">
                    </b-form-input>
                  <b-alert
                    variant="danger"
                    v-if="errors[0]"
                    v-text="errors[0]"
                    show
                    dismissible
                  >
                  </b-alert>
                  <b-img :src="oneProject.imgStatic" fluid alt="Fluid image"></b-img>
                </b-form-group>
              </ValidationProvider>
              <b-form-checkbox
                id="checkbox-1"
                name="checkbox-1"
                v-model="checkboxStatus"
                value="change"
                unchecked-value="not_change"
              >
                Modifier l'image du projet
              </b-form-checkbox>
              <ValidationProvider ref="new-imgStatic" rules="required" name="Image" v-slot="{ errors }">
                <b-form-group id="new-imgStatic" label="Nouvelle image de présentation du projet" label-for="input-new-imgStatic" class="mt-4" v-show="checkboxStatus == 'change'">
                  <b-form-file
                    id="input-new-imgStatic"
                    name="new-imgStatic"
                    v-model="modifyProject.imgStatic"
                    :state="Boolean(modifyProject.imgStatic)"
                    browse-text="Parcourir"
                    placeholder="Choisir un fichier ou glisser-déposer ici"
                    drop-placeholder="Choisir un fichier"
                  ></b-form-file>
                <b-alert
                  variant="danger"
                  v-if="errors[0]"
                  v-text="errors[0]"
                  show
                  dismissible>
                </b-alert>
                <div class="mt-3">Fichier sélectionné: {{ modifyProject.imgStatic ? modifyProject.imgStatic.name : '' }}</div>
                </b-form-group>
              </ValidationProvider>
              <ValidationProvider ref="description-image" rules="required|min:2" name="Description de l'image" v-slot="{ errors }">
                <b-form-group id="altStatic" label="Nouvelle description de l'image du projet" label-for="input-altStatic" class="mt-4">
                  <b-form-input 
                    id="input-altStatic" 
                    v-model="modifyProject.altStatic" 
                    :placeholder="oneProject.altStatic"
                    >
                  </b-form-input>
                  <b-alert
                    variant="danger"
                    v-if="errors[0]"
                    v-text="errors[0]"
                    show
                    dismissible>
                  </b-alert>
                </b-form-group>
              </ValidationProvider>
              <ValidationProvider ref="creation-date" rules="required" name="Date de création " v-slot="{ errors }">
                <b-form-group id="creation-date" label="Date de création du projet" label-for="input-creation-date" class="mt-4">
                  <b-form-datepicker id="creation-date" v-model="modifyProject.creationDate" :placeholder="oneProject.creationDate" class="mb-2"></b-form-datepicker>
                  <p>Nouvelle date de création: '{{ modifyProject.creationDate }}'</p>
                </b-form-group>
                  <b-alert
                    variant="danger"
                    v-if="errors[0]"
                    v-text="errors[0]"
                    show
                    dismissible>
                  </b-alert>
              </ValidationProvider>
              <div class="d-flex justify-content-center">
                <b-button type="submit" variant="success" class="m-3 p-3" :disabled="loading">
                  <b-spinner v-show="loading" label="Spinning" class="pt-4 p"></b-spinner>
                  <span class="pl-2 pb-2">Modifier projet {{ modifyProject.id }}</span>
                </b-button>
                <b-button type="reset" variant="danger" class="m-3 p-3" @click="onReset">
                  Réinitialiser formulaire
                </b-button>
                <b-button type="reset" variant="info" class="m-3 p-3 text-center" @click="toRecover">
                    Modifier une autre projet
                  </b-button>
              </div>
            </b-form>
            <b-card class="mt-3" header="Form Data Result">
              <pre class="m-0">{{ modifyProject }}</pre>
            </b-card>
          </ValidationObserver>
        </b-tab>
      </b-tabs>
    </b-col>
  </b-row>
</template>

<script>
import { ValidationProvider, ValidationObserver } from "vee-validate";
import { mapActions, mapGetters } from "vuex";
import AlertForm from "@/components/form/AlertForm";
// import { setFormWithFile } from "../mixins/formMixin";

export default {
  name: "ProjectForm",
  components: { 
    ValidationProvider,
    ValidationObserver,
    AlertForm
  },
  data() {
    return {
      newProject: {
        name: '',
        description: '',
        imgStatic: null,
        altStatic: '',
        creationDate: ''
      },
      loading: false,
      showProjectCard: false,
      modifyProject: {
        id: '',
        name: '',
        description: '',
        imgStatic: null,
        altStatic: '',
        creationDate: ''
      },
      project: {},
      successMessage: '',
      errorMessage: '',
      recoverForm: true,
      modifyForm: false,
      checkboxStatus: "not_change" 
    }
  },
  // mixins : [ setFormWithFile ],
  computed: {
    ...mapGetters(["oneProject"])
  },
  methods: {
    ...mapActions([
        "addProject", "updateProject", "deleteProject", "getProject"
        ]),
    onCreate() {
      this.loading = true;
      this.$refs.addForm.validate()
        .then(isValid => {
          if (!isValid) {
            this.loading = false;
            return
          }
          let fd = new FormData();
          fd.append('imgStatic', this.newProject.imgStatic)
          console.log(fd);
          Object.entries(this.newProject).forEach(
            ([key, value]) => {
              if (value !== null && value !== '') {
                fd.append(`${key}`, value);
              }
            },
          );          
        this.addProject(fd)
          .then(() => {
            this.successMessage = "Le projet a été ajouté !";
            document.getElementById("alert").scrollIntoView();
            this.loading = false;
            // this.errorMessage = '';
          })
          .catch((error) => {
            this.errorMessage = error.data[0];
            document.getElementById("alert").scrollIntoView();
            this.loading = false;
          })
      });
    },
    onModify() {
      this.loading = true;
      this.$refs.modifyForm.validate()
        .then(isValid => {
          if (!isValid) {
            this.loading = false;
            return
          }
          let fd = new FormData();
          fd.append('imgStatic', this.modifyProject.imgStatic);
          console.log(fd);
          Object.entries(this.modifyProject).forEach(
            ([key, value]) => {
              if (value !== null && value !== '') {
                fd.append(`${key}`, value);
              }
            },
          ); 
      this.updateProject(this.modifyProject.id, fd)
        .then(() => {
          this.successMessage = 'Le projet ' + this.modifyProject.id + ' a été modifier'
          document.getElementById("alertModify").scrollIntoView();  
        })
        .catch((error) => {
          this.errorMessage = error.data[0];
        })
      });
    },
    recoverProject() {      
      this.getProject(this.modifyProject.id)
        .then(() => {
          this.successMessage = 'Voici le projet ' + this.modifyProject.id + ' !' 
          this.showProjectCard = true;
          console.log(this.showProjectCard);
          document.getElementById("alertModify").scrollIntoView();  
          // this.errorMessage = '';
        })
        .catch((error) => {   
          if(error.code == "404") {
            this.errorMessage = 'Le projet ' + this.modifyProject.id  + ' n\'existe pas !';
            this.successMessage = '';
            this.loading = false;
            this.showProjectCard = false;       
          }  
        })
    },
    onDelete() {
      console.log(this.modifyProject.id);
      this.deleteProject(this.modifyProject.id) 
        .then((response) => {
          console.log(response);
          this.successMessage = response.message ;
            this.showProjectCard = true;
            this.errorMessage = '';
          if(response) {
            document.getElementById("alertModify").scrollIntoView(); 
          }
        })
        .catch((error) => {   
          if(error.code == "404") {
            this.errorMessage = 'Le projet ' + this.modifyProject.id  + ' n\'existe pas !';
            this.successMessage = '';
            this.loading = false;
            this.showProjectCard = false;       
          }  
        }
      )
    },
    fillForm(){
      this.recoverForm = false;
      this.modifyForm = true;
      this.showProjectCard =false;
      document.getElementById("modifyForm-title").scrollIntoView();
    },
    toRecover() {
      this.recoverForm = true;
      this.modifyForm = false;
    },
    onReset(event) {
      event.preventDefault()
      console.log("click reset");
      this.newProject.name = ''
      this.newProject.description = ''
      this.newProject.url = ''
      this.newProject.imgStatic = null
      this.newProject.altStatic = ''
      this.newProject.creationDate = ''
      // this.successMessage = ''
      // this.errorMessage = ''
    }
  },
  
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
