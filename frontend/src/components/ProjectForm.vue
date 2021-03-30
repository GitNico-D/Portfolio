<template>
  <b-row class="justify-content-center my-4">
    <b-col cols="8">
      <b-tabs
        active-nav-item-class="font-weight-bold text-uppercase text-success"
        active-tab-class="text-left text-white"
        align="center"
        class="mt-5"
        fill
      >
        <b-tab class="mt-5 justify-content-center">
          <template #title>
            <font-awesome-icon icon="folder-plus" size="2x" class="pt-2 pr-2"/>
            <span>Ajouter un nouveau projet</span>
          </template> 
          <div id="alert">
            <b-alert 
              variant="success"
              v-show="successMessage"
              v-text="successMessage"
              show>
            </b-alert>
            <b-alert
              variant="danger"
              v-show="errorMessage"
              v-text="errorMessage"
              show>
            </b-alert>
          </div>
          <ValidationObserver ref="addForm" v-slot="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(onSubmit)" @reset="onReset" >
              <ValidationProvider ref="name" rules="required|min:2" name="Titre" v-slot="{ errors }">
                <b-form-group id="name" label="Titre du projet" label-for="input-name" class="mt-4">
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
                <b-form-group id="textarea" label="Description du projet" label-for="input-textarea" class="mt-4">
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
              <ValidationProvider ref="url" rules="required" name="Url" v-slot="{ errors }">
                <b-form-group id="url" label="Url du projet" label-for="input-url" class="mt-4">
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
              <ValidationProvider ref="imgStatic" rules="" name="Image" v-slot="{ errors }">
                <b-form-group id="imgStatic" label="Image de présentation du projet" label-for="input-imgStatic" class="mt-4">
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
              <ValidationProvider ref="description-image" rules="required" name="Description de l'image" v-slot="{ errors }">
                <b-form-group id="altStatic" label="Description de l'image du projet" label-for="input-altStatic" class="mt-4">
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
                <b-form-group id="creation-date" label="Date de création du projet" label-for="input-creation-date" class="mt-4">
                  <b-form-datepicker id="creation-date" v-model="newProject.creationDate" class="mb-2"></b-form-datepicker>
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
                <b-button type="reset" variant="danger" class="m-3 p-3">
                  Réinitialiser formulaire
                </b-button>
              </div>
              
            </b-form>
          </ValidationObserver>
        </b-tab>
        <b-tab class="mt-3 justify-content-center">
          <template #title>
            <font-awesome-icon icon="edit" size="2x" class="pt-2 pr-2"/>
            <span>Modifier un projet</span>
          </template> 
          <ValidationObserver ref="modifyForm" v-slot="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(modifyProject)" @reset="onReset">
              <ValidationProvider ref="id" rules="required|numeric" name="ID du projet" v-slot="{ errors }">
                <b-form-group id="id" label="ID du projet" label-for="input-id" class="mt-4">
                  <b-form-input 
                    id="input-id" 
                    v-model="modifyForm.id"
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
            </b-form>
          </ValidationObserver>
        </b-tab>
      </b-tabs>
    </b-col>
  </b-row>
</template>

<script>
import { ValidationProvider, ValidationObserver } from "vee-validate";
import { mapActions, mapGetters } from "vuex";
// import { setFormWithFile } from "../mixins/formMixin";

export default {
  name: "ProjectForm",
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
      modifyForm: {
        id: ''
      },
      successMessage: '',
      errorMessage: ''
    }
  },
  // mixins : [ setFormWithFile ],
  components: { 
    ValidationProvider,
    ValidationObserver
  },
  methods: {
    ...mapActions(["addProject"]),
    onSubmit() {
      this.loading = true;
      this.$refs.addForm.validate()
        .then(isValid => {
          if (!isValid) {
            this.loading = false;
            return
          }
          let fd = new FormData();
          fd.append('imgStatic', this.newProject.imgStatic)
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
          })
          .catch((error) => {          
            if(error) {
              this.errorMessage = error;
              this.loading = false;
            }  
          })
      });
    },
    onReset(event) {
      event.preventDefault()
      this.newProject.name = ''
      this.newProject.description = ''
      this.newProject.imgStatic = null
      this.newProject.altStatic = ''
      this.newProject.creationDate = ''
      this.successMessage = ''
      this.errorMessage = ''
    }
  },
  computed: {
    ...mapGetters([])
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
  border:  1px solid $white;
}
.nav-link {
  color: $white!important;
}
.tabs {
  font-family: "Oswald", sans-serif;
  letter-spacing: 1px;
}
</style>
