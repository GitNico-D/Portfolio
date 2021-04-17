<template>
  <div>
  <div id="alert">
    <AlertForm v-if="successMessage" :message="successMessage" variant="success"/>
    <AlertForm v-if="errorMessage" :message="errorMessage" variant="danger"/>
  </div>
  <div class="text-center">
    <Button :color="careerColor" action="Retour liste" icon="arrow-left" class="m-3 p-3" v-on:action="$emit('onReturn'), onReturn()"/>
  </div>
  <h2 id="modifyForm-title" class="text-center fw-bold my-5">
    Remplisser le formulaire ci-dessous pour ajouter une nouvelle 
    <span class="font-weight-bold font-style-italic">Étape de carrière !</span>
  </h2>
  <ValidationObserver ref="addForm" v-slot="{ handleSubmit }">
    <b-form @submit.prevent="handleSubmit(onCreate)">
      <ValidationProvider ref="name" rules="required|min:2|max:100" name="Titre" v-slot="{ errors }">
        <b-form-group id="name">
          <label for="input-name" class="text-uppercase">Titre de l'étape de carrière</label>
          <b-form-input 
            id="input-name" 
            v-model="newCareer.name" 
            placeholder="Entrer un nom">
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
          <label for="input-textarea" class="text-uppercase">Description de l'étape de carrière</label>
          <b-form-textarea
            id="input-textarea"
            v-model="newCareer.description"
            placeholder="Entrer une description"
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
      <ValidationProvider ref="company" rules="required|min:2|max:50" name="Société" v-slot="{ errors }">
        <b-form-group id="company" class="mt-4">
          <label for="input-company" class="text-uppercase">Société de l'étape de carrière</label>
          <b-form-input
            id="input-company"
            v-model="newCareer.company"
            placeholder="Entrer un nom">
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
      <ValidationProvider ref="logo-company" rules="required" name="Logo" v-slot="{ errors }">
        <b-form-group id="logo-company" class="mt-4">
          <label for="input-logo-company" class="text-uppercase">Logo de la société</label>
          <b-form-file
            id="input-logo-company"
            name="logo-company"
            v-model="newCareer.logoCompany"
            :state="Boolean(newCareer.logoCompany)"
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
        <div class="mt-3">Fichier sélectionné: {{ newCareer.logoCompany ? newCareer.logoCompany.name : '' }}</div>
        <b-img thumbnail fluid id="previewLogoCompany" v-show="previewLogoCompanyUrl && newCareer.logoCompany" :src="previewLogoCompanyUrl"></b-img>
        </b-form-group>
      </ValidationProvider>
      <ValidationProvider ref="start-date" rules="required" name="Date de création" v-slot="{ errors }">
        <b-form-group id="start-date" class="mt-4">
          <label for="input-start-date" class="text-uppercase">Date de début de l'étape de carrière</label>
          <b-form-datepicker id="start-date" v-model="newCareer.startDate" class="mb-2" placeholder="Choisir une date"></b-form-datepicker>
          <p>Date de début: '{{ newCareer.startDate }}'</p>
        </b-form-group>
          <b-alert
            variant="danger"
            v-if="errors[0]"
            v-text="errors[0]"
            show
            dismissible>
          </b-alert>
      </ValidationProvider>
      <ValidationProvider ref="end-date" rules="required" name="Date de création" v-slot="{ errors }">
        <b-form-group id="end-date" class="mt-4">
          <label for="input-end-date" class="text-uppercase">Date de fin de l'étape de carrière</label>
          <b-form-datepicker id="end-date" v-model="newCareer.endDate" class="mb-2" placeholder="Choisir une date"></b-form-datepicker>
          <p>Date de fin: '{{ newCareer.endDate }}'</p>
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
        <b-button type="submit" class="m-3 p-3 btn-add" :disabled="loading" @click="$emit('addCareerStage'), resetForm()">
          <b-spinner v-show="loading" label="Spinning" class="pl-2"></b-spinner>
          <font-awesome-icon icon="folder-plus"/>
          <span class="pl-2">Ajouter étape de carrière</span>
        </b-button>
        <Button :color="resetButtonColor" action="Réinitialiser formulaire" icon="trash-alt" class="m-3 p-3" v-on:action="resetForm"/>
        <Button :color="cancelButtonColor" action="Annuler" icon="times" class="m-3 p-3" v-on:action="$emit('onCancelAdd'), resetForm()"/>
      </div>
    </b-form>
    <b-card class="mt-3" header="Form Data Result">
      <pre class="m-0">{{ newCareer }}</pre>
    </b-card>
  </ValidationObserver>
</div>
</template>

<script>
import { ValidationProvider, ValidationObserver } from "vee-validate";
import { mapActions } from "vuex";
import AlertForm from "@/components/form/AlertForm";
import Button from "@/components/Button"
import setFormWithFile from "../../mixins/formMixin";

export default {
  name: "AddCareerForm",
  components: { 
    ValidationProvider,
    ValidationObserver,
    AlertForm,
    Button
  },
  data() {
    return {
      careerColor: "#00a1ba",
      cancelButtonColor: "#BE8C2E",
      resetButtonColor: "#ef233c",
      newCareer: {
        name: '',
        description: '',
        company: '',
        logoCompany: null,
        startDate: '',
        endDate: ''
      },
      loading: false,
      successMessage: '',
      errorMessage: '',
      previewLogoCompanyUrl: ''
    }
  },
  mixins : [ setFormWithFile ],
  methods: {
    ...mapActions(["addCareerStage"]),
    showPreview(event) {
      const file = event.target.files[0];
      if(file) {
        this.previewLogoCompanyUrl = URL.createObjectURL(file);
        document.getElementById("previewLogoCompany").onload = function () {
          window.URL.revokeObjectURL(this.previewLogoCompanyUrl);
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
          let fd = this.setFormWithFile(this.newCareer.icon, this.newCareer)       
        this.addCareerStage(fd)
          .then(() => {
            this.successMessage = "L'étape de carrière a été ajoutée !";
            document.getElementById("alert").scrollIntoView();
            this.loading = false;
            this.errorMessage = '';
            this.resetForm();
          })
          .catch((error) => {
            this.errorMessage = error.data[0].message;
            document.getElementById("alert").scrollIntoView();
            this.loading = false;
            this.successMessage  = '';
          })
      });
    },
    resetForm(){
      this.$refs.addForm.reset();
      this.loading = false;
      this.newCareer.name = ''
      this.newCareer.description = ''
      this.newCareer.company = ''
      this.newCareer.logoCompany = null
      this.newCareer.startDate = ''
      this.newCareer.endDate = ''
      this.previewLogoCompanyUrl = ''
    },
    onReturn() {
      this.successMessage = ''
      this.errorMessage = ''
    }
  },
  
}
</script>

<style lang="scss" scoped>
.btn {
  &-add {
    color: $white;
    background-color: $light-blue;
    border: 1px solid $light-blue;
    &:hover {
      color: $light-blue;
      background-color: transparent;
      border: 1px solid $light-blue;
    }
    &:focus, &:active {
      color: $white!important;
      box-shadow: unset;
      border: 1px solid $light-blue;
      background-color: $light-blue;
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
