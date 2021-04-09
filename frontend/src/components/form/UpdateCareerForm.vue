<template>
<div> 
  <div id="alert">
    <AlertForm v-if="successMessage" v-show="oneProject.id" :message="successMessage" variant="success"/>
    <AlertForm v-if="errorMessage" v-show="oneProject.id" :message="errorMessage" variant="danger"/>
  </div>
  <h2 v-if="!oneProject.id" id="modifyForm-title" class="text-center fw-bold mt-5" >
    <p>Aucun <span class="font-weight-bold font-style-italic">Projet</span> sélectionné.</p>
    <p>Rendez-vous sur l'onglet 
      <span class="font-style-italic">"Liste des projets"</span> 
      pour sélectionné le projet que vous souhaitez modifier.
    </p>
  </h2>
  <h2 v-else id="modifyForm-title" class="text-center fw-bold my-5" >
    Modification du project "{{ oneProject.name }}"
  </h2>
  <p class="mt-4 text-left" v-show="oneProject.id">
    ID du <span class="text-uppercase font-weight-bold">projet : </span>
    {{oneProject.id}}
  </p>
  <ValidationObserver ref="modifyForm" v-slot="{ handleSubmit }" v-show="oneProject.id || showForm">
    <b-form @submit.prevent="handleSubmit(onModify)" @reset.prevent="onReset" >
      <ValidationProvider ref="name" rules="required|min:2" name="Titre" v-slot="{ errors }">
        <b-form-group id="name" class="mt-4">
          <label for="input-name" class="text-uppercase">Nouveau titre du projet</label>
          <b-form-input 
            id="input-name" 
            v-model="modifyProject.name"
          >
          </b-form-input>
          <b-alert
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
        <b-form-group id="textarea" class="mt-4">
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
        <b-form-group id="url" class="mt-4">
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
      <div>
        <h5 class="text-left text-uppercase">Image du projet</h5>
        <b-img :src="oneProject.imgStatic" fluid alt="Fluid image" class="mt-1" v-show="!modifyProject.imgStatic"></b-img>
      </div>
      <ValidationProvider ref="new-imgStatic" rules="" name="Image" v-slot="{ errors }">
        <b-form-group id="new-imgStatic" class="mt-4">
          <label for="input-imgStatic" class="text-uppercase">Nouvelle image de présentation du projet</label>
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
          class="mt-1"
          variant="danger"
          v-if="errors[0]"
          v-text="errors[0]"
          show
        >
        </b-alert>
        <div class="mt-3">Fichier sélectionné: {{ modifyProject.imgStatic ? modifyProject.imgStatic.name : '' }}</div>
        </b-form-group>
      </ValidationProvider>
      <hr>
      <ValidationProvider ref="description-image" rules="required|min:2" name="Description de l'image" v-slot="{ errors }">
        <b-form-group id="altStatic" class="mt-4">
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
        <b-form-group id="creation-date" class="mt-4">
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
          <p>Nouvelle date de création: '{{ modifyProject.creationDate }}'</p>
        </b-form-group>
      </ValidationProvider>
      <div class="d-flex justify-content-center">
        <b-button type="submit" variant="success" class="m-3 p-3" :disabled="loading">
          <b-spinner v-show="loading" label="Spinning" class="pt-4 p"></b-spinner>
          <span class="pl-2 pb-2">Modifier projet {{ projectId }}</span>
        </b-button>
        <b-button type="reset" variant="danger" class="m-3 p-3" @click="onReset">
          Réinitialiser formulaire
        </b-button>
        <b-button variant="warning" class="m-3 p-3" @click="onCancel">
          Annuler
        </b-button>
      </div>
    </b-form>
    <b-card class="mt-3" header="Form Data Result">
      <pre class="m-0">{{ modifyProject }}</pre>
    </b-card>
    <b-card class="mt-3" header="Form Data Result">
      <pre class="m-0">{{ oneProject }}</pre>
    </b-card>
  </ValidationObserver>
</div>
</template>

<script>
import { ValidationProvider, ValidationObserver } from "vee-validate";
import { mapActions, mapGetters } from "vuex";
import AlertForm from "@/components/form/AlertForm";
// import formatDate from "../../services/formatDate";
// import { setFormWithFile } from "../mixins/formMixin";

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
      successMessage: '',
      errorMessage: '',
      showForm: false 
    }
  },
  // mixins : [ setFormWithFile ],
  computed: {
    ...mapGetters(["oneProject"]),
  },
  methods: {
    ...mapActions(["updateProjectWithFile", "updateProjectWithoutFile", "resetStateProject"]),
    formatDate() {
      const options = {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric"
      };
      let formatDate = new Date(this.oneProject.creationDate).toLocaleDateString(
        undefined,
        options
      );
      return formatDate.charAt(0).toUpperCase() + formatDate.slice(1);
    },
    onModify() {
      this.loading = true;
      this.$refs.modifyForm.validate()
        .then(isValid => {
          if (!isValid) {
            this.loading = false;
            return
          }
          if(this.statusImage == "not_change") {
            this.modifyProject.imgStatic = this.oldImgStatic;
            this.updateProjectWithoutFile({
              id: this.projectId, 
              form: this.modifyProject
            })
            .then(() => {
              this.successMessage = 'Le projet ' + this.projectId + ' a été modifier';
              this.loading = false;
              document.getElementById("alert").scrollIntoView();  
            })
            .catch((error) => {
              this.errorMessage = error.message;
            })
          } else {
            let fd = new FormData();
            fd.append('imgStatic', this.modifyProject.imgStatic);
            Object.entries(this.modifyProject).forEach(
              ([key, value]) => {
                if (value !== null && value !== '') {
                  fd.append(`${key}`, value);
                }
              },
            );
            this.updateProjectWithFile({
              id: this.projectId, 
              formData: fd
            })
            .then(() => {
              this.successMessage = 'Le projet ' + this.projectId + ' a été modifier';
              this.loading = false;
              document.getElementById("alert").scrollIntoView();  
            })
            .catch((error) => {
              this.errorMessage = error.message;
            })
          }
      })
    },
    fillForm(){
      this.recoverForm = false;
      this.modifyForm = true;
      this.showProjectCard =false;
      document.getElementById("modifyForm-title").scrollIntoView();
    },
    toFetchProject() {

    },
    onReset(event) {
      event.preventDefault()
      this.modifyProject.name = ''
      this.modifyProject.description = ''
      this.modifyProject.url = ''
      this.modifyProject.imgStatic = null
      this.modifyProject.altStatic = ''
      this.modifyProject.creationDate = ''
      this.successMessage = ''
      this.errorMessage = ''
    },
    onCancel: function() {
      console.log("click");
      this.resetStateProject();
      this.onReset(event);
      this.showForm = false;
      this.successMessage = ''
    }
  },
  mounted() {
    if(this.oneProject.id) {
      this.modifyProject = this.oneProject;
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
  label {
    font-size: 1.3rem;
    @include text-shadow(0px, 0px, 10px, $purple); 
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
  width: 80%;
}
.nav-link {
  color: $white!important;
}
.tabs {
  font-family: "Oswald", sans-serif;
  letter-spacing: 1px;
}
</style>
