<template>
<div> 
  <div id="alert">
    <AlertForm v-if="successMessage" v-show="oneProject.id" :message="successMessage" variant="success"/>
    <AlertForm v-if="errorMessage" v-show="oneProject.id" :message="errorMessage" variant="danger"/>
  </div>
  <h2 v-if="!oneProject.id" id="modifyForm-title" ref="titleForm" class="text-center fw-bold mt-5" >
    <p>Aucun <span class="font-weight-bold font-style-italic">Projet</span> sélectionné.</p>
    <p>Rendez-vous sur l'onglet 
      <span class="font-style-italic">"Liste des projets"</span> 
      pour sélectionné le projet que vous souhaitez modifier.
    </p>
  </h2>
  <h2 v-else id="modifyForm-title" class="text-center fw-bold my-5" >
    Modification du project "{{ currentName }}"
  </h2>
  <p class="mt-4 text-left" v-show="oneProject.id">
    ID du <span class="text-uppercase font-weight-bold">projet : </span>
    {{oneProject.id}}
  </p>
  <ValidationObserver ref="modifyForm" v-slot="{ handleSubmit }" v-show="oneProject.id || showForm">
    <b-form @submit.prevent="handleSubmit(onModify)" >
      <ValidationProvider ref="name" rules="required|min:2" name="Titre" v-slot="{ errors }">
        <b-form-group id="name" class="mb-5">
          <label for="input-name" class="text-uppercase">Nouveau titre du projet</label>
          <b-form-input 
            id="input-name" 
            v-model="modifyProject.name"
            ref="inputName" 
          >
          </b-form-input>
          <b-alert
            id="alert-name"
            class="mt-1"
            variant="danger"
            v-if="errors[0]"
            v-text="errors[0]"
            show>
          </b-alert>
        </b-form-group>
      </ValidationProvider>
      <hr>
      <ValidationProvider ref="description" rules="required|min:2" name="Description" v-slot="{ errors }">
        <b-form-group id="textarea" class="mb-5">
          <label for="input-name" class="text-uppercase">Nouvelle description du projet</label>
          <b-form-textarea
            id="input-textarea"
            v-model="modifyProject.description"
            size="lg">
            </b-form-textarea>
            <b-alert
              class="mt-1"
              variant="danger"
              v-if="errors[0]"
              v-text="errors[0]"
              show
            >
          </b-alert>
        </b-form-group>
      </ValidationProvider>
      <hr>
      <ValidationProvider ref="url" rules="required|url" name="Url" v-slot="{ errors }">
        <b-form-group id="url" class="mb-5">
          <label for="input-url" class="text-uppercase">Nouvelle Url du projet</label>
          <b-form-input
            id="input-url"
            v-model="modifyProject.url"
            >
          </b-form-input>
          <b-alert
            class="mt-1"
            variant="danger"
            v-if="errors[0]"
            v-text="errors[0]"
            show
          >
          </b-alert>
        </b-form-group>
      </ValidationProvider>
      <hr>
      <div >
        <h5 v-show="!modifyProject.imgStatic && oldImgStatic" class="text-left text-uppercase">Image du projet</h5>
        <b-img :src="oldImgStatic" fluid alt="Fluid image" class="mt-1" v-show="!modifyProject.imgStatic && oldImgStatic"></b-img>
      </div>
      <ValidationProvider ref="new-imgStatic" v-if="modifyProject" name="Image" v-slot="{ errors }">
        <b-form-group id="new-imgStatic" class="mt-3 mb-5">
          <label for="input-imgStatic" class="text-uppercase">Nouvelle image de présentation du projet</label>
          <b-form-file
            id="input-new-imgStatic"
            ref="file"
            name="new-imgStatic"
            v-model="modifyProject.imgStatic"
            browse-text="Parcourir"
            accept="image/*"
            placeholder="Choisir un fichier ou glisser-déposer ici"
            drop-placeholder="Choisir un fichier"
            @change="showPreview($event)"
          ></b-form-file>
          <b-alert
            class="mt-1"
            variant="danger"
            v-if="errors[0]"
            v-text="errors[0]"
            show
          >
          </b-alert>
          <div class="mt-3">Fichier sélectionné: {{ modifyProject.imgStatic ? modifyProject.imgStatic.name : '' }}</div>
          <b-img thumbnail fluid id="previewImage" v-show="previewImageUrl && modifyProject.imgStatic" :src="previewImageUrl"></b-img>
        </b-form-group>
      </ValidationProvider>
      <hr>
      <ValidationProvider ref="description-image" rules="required|min:2" name="Description de l'image" v-slot="{ errors }">
        <b-form-group id="altStatic" class="mb-5">
          <label for="input-altStatic" class="text-uppercase">Nouvelle description de l'image du projet</label>
          <b-form-input 
            id="input-altStatic" 
            v-model="modifyProject.altStatic"
            >
          </b-form-input>
          <b-alert
            class="mt-1"
            variant="danger"
            v-if="errors[0]"
            v-text="errors[0]"
            show
            dismissible>
          </b-alert>
        </b-form-group>
      </ValidationProvider>
      <hr>
      <ValidationProvider ref="creation-date" rules="required" name="Date de création " v-slot="{ errors }">
        <b-form-group id="creation-date" class="mb-5">
          <label for="input-creation-date" class="text-uppercase">Nouvelle date de création du projet</label>
          <b-form-datepicker 
            id="creation-date" 
            v-model="modifyProject.creationDate" 
            bg-variant="light" 
            class="mb-2"
          >
          </b-form-datepicker>
          <b-alert
            class="mt-1"
            variant="danger"
            v-if="errors[0]"
            v-text="errors[0]"
            show
            dismissible>
          </b-alert>
          <p>Nouvelle date de création: '{{ formatDate(modifyProject.creationDate) }}'</p>
        </b-form-group>
      </ValidationProvider>
      <div class="d-flex justify-content-center">
        <b-button type="submit" class="m-3 p-3 btn-modify" :disabled="loading" @click="$emit('showModifyProject')">
          <b-spinner v-show="loading" label="Spinning" class="pt-4 p"></b-spinner>
            <font-awesome-icon icon="edit"/>
            <span class="pl-2 pb-2">Modifier projet</span>
        </b-button>
        <b-button class="m-3 p-3 btn-delete" @click="$emit('onCancelModify'), onCancel">
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
import { mapActions, mapGetters } from "vuex";
import AlertForm from "@/components/form/AlertForm";
import formatDate from "../../services/formatDate";
import setFormWithFile from "../../mixins/formMixin";

export default {
  name: "UpdateProjectForm",
  components: { 
    ValidationProvider,
    ValidationObserver,
    AlertForm
  },
  data() {
    return {
      loading: false,
      projectId: null,
      modifyProject: {
        name: '',
        description: '',
        url: '',
        imgStatic: null,
        altStatic: '',
        creationDate: ''
      },
      oldImgStatic: '',
      currentName: '',
      previewImageUrl: null,
      successMessage: '',
      errorMessage: '',
      showForm: false 
    }
  },
  mixins : [ setFormWithFile ],
  computed: {
    ...mapGetters(["oneProject"]),    
  },
  methods: {
    ...mapActions(["updateProjectWithFile", "updateProjectWithoutFile", "resetStateProject"]),
    showPreview(event) {
      const file = event.target.files[0];
      if(file) {
        this.previewImageUrl = URL.createObjectURL(file);
        document.getElementById("previewImage").onload = function () {
          window.URL.revokeObjectURL(this.previewImageUrl);
        }
      }
    },
    onModify() {
      this.loading = true;
      this.$refs.modifyForm.validate()
        .then(isValid => {
          if (!isValid) {
            this.loading = false;
            return
          }
          if(!this.modifyProject.imgStatic) {
            // this.modifyProject.imgStatic = this.oldImgStatic;
            console.log(this.modifyProject);
            this.updateProjectWithoutFile({
              id: this.oneProject.id, 
              form: this.modifyProject
            })
            .then(() => {
              this.successMessage = 'Le projet ' + this.oneProject.id + ' a été modifier';
              this.loading = false;
              this.resetForm();
              document.getElementById("alert").scrollIntoView(); 
            })
            .catch((error) => {
              this.errorMessage = error.message;
            })
          } else {
            let fd = this.setFormWithFile(this.modifyProject.imgStatic, this.modifyProject)
            var object = {};
            fd.forEach(function(value, key){
                object[key] = value;
            });
            var jsonFormData = JSON.stringify(object);
            console.log(jsonFormData)
            this.updateProjectWithFile({
              id: this.oneProject.id, 
              formData: fd
            })
            .then(() => {
              this.successMessage = 'Le projet ' + this.oneProject.id + ' a été modifier';
              this.loading = false;
              this.resetForm();
              document.getElementById("alert").scrollIntoView();  
            })
            .catch((error) => {
              this.errorMessage = error.message;
            })
          }
      })
    },
    resetForm() {
      this.$refs.modifyForm.reset;
      this.modifyProject.name = ''
      this.modifyProject.description = ''
      this.modifyProject.url = ''
      this.modifyProject.imgStatic = null
      this.modifyProject.altStatic = ''
      this.modifyProject.creationDate = ''
      this.oldImgStatic = ''
    },
    onCancel: function() {
      this.onReset(event);
    },
    formatDate(date) {
      return formatDate(date);
    },
  },
  mounted() {
    if(this.oneProject.id) {
      this.modifyProject = this.oneProject;
      this.oldImgStatic = this.oneProject.imgStatic;
      this.modifyProject.imgStatic = null;
    }
  },
  
}
</script>

<style lang="scss" scoped>
.btn {
  &-modify {
    color: $white;
    background-color: $green;
    border: 1px solid $green;
    &:hover {
      color: $green;
      background-color: transparent;
      border: 1px solid $green;
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
}
.card {
  &-body {
    background-color: transparent; 
  }
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
form {
  width: 90%;
  margin: auto;
  padding: 1.5rem;
}
.form-group {
  label {
    font-size: 1.3rem;
    @include text-shadow(0px, 0px, 10px, $purple); 
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
hr{
  background-color: $purple;
  width: 60%;
}
.nav-link {
  color: $white!important;
}
.row {
  height: unset;
}
.tabs {
  font-family: "Oswald", sans-serif;
  letter-spacing: 1px;
}
</style>
