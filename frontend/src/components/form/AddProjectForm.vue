<template>
  <div>
  <div id="alert">
    <AlertForm v-if="successMessage" :message="successMessage" variant="success"/>
    <AlertForm v-if="errorMessage" :message="errorMessage" variant="danger"/>
  </div>
  <div class="text-center">
    <b-button class="m-3 p-3 btn-return" @click="$emit('onReturn')">
      <font-awesome-icon icon="arrow-left"/>
      <span class="pl-2 pb-2">Retour liste</span>
    </b-button>
  </div>
  <h2 id="modifyForm-title" class="text-center fw-bold my-5">
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
            @change="showPreview($event)"
          >
          </b-form-file>
        <b-alert
          variant="danger"
          v-if="errors[0]"
          v-text="errors[0]"
          show
          dismissible>
        </b-alert>
        <div class="mt-3">Fichier sélectionné: {{ newProject.imgStatic ? newProject.imgStatic.name : '' }}</div>
        <b-img thumbnail fluid id="previewImgStatic" v-show="previewImgStaticUrl && newProject.imgStatic" :src="previewImgStaticUrl"></b-img>
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
        <b-button type="submit" class="m-3 p-3 btn-add"  :disabled="loading" @click="$emit('addProject')">
          <b-spinner v-show="loading" label="Spinning" class="pt-4 p"></b-spinner>
          <font-awesome-icon icon="folder-plus"/><span class="pl-2 pb-2">Ajouter projet</span>
        </b-button>
        <b-button type="reset" class="m-3 p-3 btn-reset" @click="onReset">
          <font-awesome-icon icon="trash-alt"/><span class="pl-2">Réinitialiser formulaire</span>
        </b-button>
        <b-button class="m-3 p-3 btn-delete" @click="$emit('onCancel'), onCancel">
          <font-awesome-icon icon="times"/>
          <span class="pl-2 pb-2">Annuler</span>
        </b-button>
      </div>
    </b-form>
  </ValidationObserver>
</div>
</template>

<script>
import { ValidationProvider, ValidationObserver } from "vee-validate";
import { mapActions } from "vuex";
import AlertForm from "@/components/form/AlertForm";
import setFormWithFile from "../../mixins/formMixin";

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
      previewImgStaticUrl : ''
    }
  },
  mixins : [ setFormWithFile ],
  methods: {
    ...mapActions(["addProject"]),
    showPreview(event) {
      const file = event.target.files[0];
      if(file) {
        this.previewImgStaticUrl = URL.createObjectURL(file);
        document.getElementById("previewImgStatic").onload = function () {
          window.URL.revokeObjectURL(this.previewImgStaticUrl);
        }
      }
    },
    onCreate() {
      this.loading = true;
      this.$refs.addForm.validate()
        .then(isValid => {
          if (!isValid) {
            this.loading = false;
            return
          }
          let fd = this.setFormWithFile(this.newProject.imgStatic, this.newProject);    
        this.addProject(fd)
          .then(() => {
            this.successMessage = "Le projet a été ajouté !";
            document.getElementById("alert").scrollIntoView();
            this.loading = false;
            this.errorMessage = '';
            this.onReset(event);
          })
          .catch((error) => {
            this.errorMessage = error.data;
            document.getElementById("alert").scrollIntoView();
            this.loading = false;
            this.successMessage  = '';
          })
      });
    },
    onReset(event) {
      event.preventDefault()
      console.log("click reset");
      this.loading = false;
      this.newProject.name = ''
      this.newProject.description = ''
      this.newProject.url = ''
      this.newProject.imgStatic = null
      this.newProject.altStatic = ''
      this.newProject.creationDate = ''
    },
    onCancel() {
      this.$refs.addForm.reset
      this.loading = false;
      this.newProject.name = ''
      this.newProject.description = ''
      this.newProject.url = ''
      this.newProject.imgStatic = null
      this.newProject.altStatic = ''
      this.newProject.creationDate = ''
    }
  },
}
</script>

<style lang="scss" scoped>
.btn {
  &-add, &-return {
    color: $white;
    background-color: $purple;
    border: 1px solid $purple;
    &:hover {
      color: $purple;
      background-color: transparent;
      border: 1px solid $purple;
    }
  }
  &-delete {
    color: $white;
    background-color: $yellow;
    border: 1px solid $yellow;
    &:hover {
      color: $yellow;
      background-color: transparent;
      border: 1px solid $yellow;
    }
  }
  &-reset {
    color: $white;
    background-color: $red;
    border: 1px solid $red;
    &:hover {
      color: $red;
      background-color: transparent;
      border: 1px solid $red;
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
