<template>
  <div>
  <div id="alert">
    <AlertForm v-if="successMessage" :message="successMessage" variant="success"/>
    <AlertForm v-if="errorMessage" :message="errorMessage" variant="danger"/>
  </div>
  <h2 id="modifyForm-title" class="text-center fw-bold mt-5">
    Remplisser le formulaire ci-dessous pour ajouter un nouveau 
    <span class="font-weight-bold font-style-italic">Projet !</span>
  </h2>
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
</div>
</template>

<script>
import { ValidationProvider, ValidationObserver } from "vee-validate";
import { mapActions } from "vuex";
import AlertForm from "@/components/form/AlertForm";
// import { setFormWithFile } from "../mixins/formMixin";

export default {
  name: "AddProjectForm",
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
      successMessage: '',
      errorMessage: '',
    }
  },
  // mixins : [ setFormWithFile ],
  methods: {
    ...mapActions(["addProject"]),
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
            this.errorMessage = '';
          })
          .catch((error) => {
            this.errorMessage = error.data[0];
            document.getElementById("alert").scrollIntoView();
            this.loading = false;
            this.successMessage  = '';
          })
      });
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
      this.successMessage = ''
      this.errorMessage = ''
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
