<template>
<div> 
  <div id="alert">
    <AlertForm v-if="successMessage" v-show="oneCareer.id" :message="successMessage" variant="success"/>
    <AlertForm v-if="errorMessage" v-show="oneCareer.id" :message="errorMessage" variant="danger"/>
  </div>
  <div class="text-center">
    <Button :color="careerColor" action="Retour liste" icon="arrow-left" class="m-3 p-3" v-on:action="$emit('onReturn'), onReturn()"/>
  </div>
  <h2 v-if="!oneCareer.id" id="modifyForm-title" ref="titleForm" class="text-center fw-bold mt-5" >
    <p>Aucun <span class="font-weight-bold font-style-italic">Étape de carrière </span> sélectionné.</p>
    <p>Rendez-vous sur l'onglet 
      <span class="font-style-italic">"Liste des étapes de carrière "</span> 
      pour sélectionné l'étape de carrière que vous souhaitez modifier.
    </p>
  </h2>
  <h2 v-else id="modifyForm-title" class="text-center fw-bold my-5" >
    Modification du CareerStage 
    <p class="my-2"><span class="font-weight-bold font-style-italic">"{{ currentName }}"</span></p>
  </h2>
  <p class="mt-4 text-left" v-show="oneCareer.id">
    ID de <span class="text-uppercase font-weight-bold">l'étape de carrière : </span>
    {{oneCareer.id}}
  </p>
  <ValidationObserver ref="modifyForm" v-slot="{ handleSubmit }" v-show="oneCareer.id || showForm">
    <b-form @submit.prevent="handleSubmit(onModify)" >
      <ValidationProvider ref="name" rules="required|min:2|max:100" name="Intitulé" v-slot="{ errors }">
        <b-form-group id="name" class="mb-5">
          <label for="input-name" class="text-uppercase">Nouveau intitulé de l'étape de carrière </label>
          <b-form-input 
            id="input-name" 
            v-model="modifyCareerStage.name"
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
          <label for="input-name" class="text-uppercase">Nouvelle description de l'étape de carrière</label>
          <b-form-textarea
            id="input-textarea"
            v-model="modifyCareerStage.description"
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
      <ValidationProvider ref="company" rules="required|min:2|max:50" name="Société" v-slot="{ errors }">
        <b-form-group id="company" class="mb-5">
          <label for="input-company" class="text-uppercase">Nouvelle société de l'étape de carrière</label>
          <b-form-input
            id="input-company"
            v-model="modifyCareerStage.company"
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
        <h5 v-show="!modifyCareerStage.logoCompany && oldLogoCompany" class="text-left text-uppercase">Logo de la société</h5>
        <b-img :src="oldLogoCompany" fluid alt="Fluid image" class="mt-1" v-show="!modifyCareerStage.logoCompany && oldLogoCompany"></b-img>
      </div>
      <ValidationProvider ref="new-logoCompany" name="Image" v-slot="{ errors }">
        <b-form-group id="new-logoCompany" class="mt-3 mb-5">
          <label for="input-logoCompany" class="text-uppercase">Nouveau logo de la société</label>
          <b-form-file
            id="input-new-logoCompany"
            ref="file"
            name="new-logoCompany"
            v-model="modifyCareerStage.logoCompany"
            browse-text="Parcourir"
            accept="image/*"
            placeholder="Choisir un fichier ou glisser-déposer ici"
            drop-placeholder="Choisir un fichier"
            @change="showPreview($event)"
          >{{modifyCareerStage.logoCompany}}</b-form-file>
          <b-alert
            class="mt-1"
            variant="danger"
            v-if="errors[0]"
            v-text="errors[0]"
            show
          >
          </b-alert>
          <div class="mt-3">Fichier sélectionné: {{ modifyCareerStage.logoCompany ? modifyCareerStage.logoCompany.name : '' }}</div>
          <b-img thumbnail fluid id="previewLogoCompany" v-show="previewLogoCompanyUrl && modifyCareerStage.logoCompany" :src="previewLogoCompanyUrl"></b-img>
        </b-form-group>
      </ValidationProvider>
      <ValidationProvider ref="start-date" rules="required" name="Date de début" v-slot="{ errors }">
        <b-form-group id="start-date" class="mb-5">
          <label for="input-start-date" class="text-uppercase">Nouvelle date de début de l'étape de carrière</label>
          <b-form-datepicker 
            id="start-date" 
            v-model="modifyCareerStage.startDate" 
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
          <p>Nouvelle date de début: '{{ formatDate(modifyCareerStage.startDate) }}'</p>
        </b-form-group>
      </ValidationProvider>
      <ValidationProvider ref="end-date" rules="required" name="Date de début" v-slot="{ errors }">
        <b-form-group id="end-date" class="mb-5">
          <label for="input-end-date" class="text-uppercase">Nouvelle date de fin de l'étape de carrière</label>
          <b-form-datepicker 
            id="end-date" 
            v-model="modifyCareerStage.endDate" 
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
          <p>Nouvelle date de fin: '{{ formatDate(modifyCareerStage.endDate) }}'</p>
        </b-form-group>
      </ValidationProvider>
      <div class="d-flex justify-content-center">
        <b-button type="submit" class="m-3 p-3 btn-modify" :disabled="loading" @click="$emit('showmodifyCareerStage')">
          <b-spinner v-show="loading" label="Spinning" class="mr-2"></b-spinner>
            <font-awesome-icon icon="edit"/>
            <span class="pl-2 pb-2">Modifier Carrière</span>
        </b-button>
        <Button action="Annuler" :color="cancelButtonColor" icon="times" class="m-3 p-3" v-on:action="$emit('onCancelModify'), resetForm()"/>
      </div>
    </b-form>
  </ValidationObserver>
</div>
</template>

<script>
import { ValidationProvider, ValidationObserver } from "vee-validate";
import { mapActions, mapGetters } from "vuex";
import AlertForm from "@/components/form/AlertForm";
import Button from "@/components/Button"
import formatDate from "../../services/formatDate";
import setFormWithFile from "../../mixins/formMixin";

export default {
  name: "UpdateCareerStageForm",
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
      loading: false,
      careerStageId: null,
      modifyCareerStage: {
        name: '',
        description: '',
        company: '',
        logoCompany: null,
        startDate: '',
        endDate: ''
      },
      oldLogoCompany: '',
      currentName: '',
      previewLogoCompanyUrl: '',
      successMessage: '',
      errorMessage: '',
      showForm: false 
    }
  },
  mixins : [ setFormWithFile ],
  computed: {
    ...mapGetters(["oneCareer"]),    
  },
  methods: {
    ...mapActions(["updateCareerStageWithFile", "updateCareerStageWithoutFile", "resetStateCareerStage"]),
    showPreview(event) {
      const file = event.target.files[0];
      if(file) {
        this.previewLogoCompanyUrl = URL.createObjectURL(file);
        document.getElementById("previewLogoCompany").onload = function () {
          window.URL.revokeObjectURL(this.previewLogoCompanyUrl);
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
          if(!this.modifyCareerStage.logoCompany) {
            this.updateCareerStageWithoutFile({
              id: this.oneCareer.id, 
              form: this.modifyCareerStage
            })
            .then(() => {
              this.successMessage = 'L\'étape de carrière ' + this.oneCareer.id + ' a été modifier';
              this.loading = false;
              this.resetForm();
              document.getElementById("alert").scrollIntoView(); 
            })
            .catch((error) => {
              if(error.data[0]) {
                this.errorMessage = error.data[0].message;
              } else {
                this.errorMessage = error;
              }
              this.successMessage = ''
            })
          } else {
            let fd = this.setFormWithFile(this.modifyCareerStage.logoCompany, this.modifyCareerStage);
            this.updateCareerStageWithFile({
              id: this.oneCareer.id, 
              formData: fd
            })
            .then(() => {
              this.successMessage = 'L\'étape de carrière ' + this.oneCareer.id + ' a été modifier';
              this.loading = false;
              this.resetForm();
              document.getElementById("alert").scrollIntoView();  
            })
            .catch((error) => {
              if(error.data[0]) {
                this.errorMessage = error.data[0].message;
              } else {
                this.errorMessage = error;
              }
              this.successMessage = ''
            })
          }
      })
    },
    resetForm() {
      this.$refs.modifyForm.reset();
      this.modifyCareerStage.name = ''
      this.modifyCareerStage.description = ''
      this.modifyCareerStage.company = ''
      this.modifyCareerStage.logoCompany = null
      this.modifyCareerStage.altStatic = ''
      this.modifyCareerStage.creationDate = ''
      this.oldLogoCompany = ''
    },
    formatDate(date) {
      return formatDate(date);
    },
    onReturn() {
      this.successMessage = ''
      this.errorMessage = ''
    }
  },
  mounted() {
    if(this.oneCareer.id) {
      this.modifyCareerStage = this.oneCareer;
      this.currentName = this.oneCareer.name;
      this.oldLogoCompany = this.oneCareer.logoCompany;
      this.modifyCareerStage.logoCompany = null;
    }
  },
  
}
</script>

<style lang="scss" scoped>
.btn {
  &-modify {
    color: $white;
    background-color: $light-blue;
    border: 1px solid $light-blue;
    &:hover {
      color: $light-blue;
      background-color: transparent;
      border: 1px solid $light-blue;
    }
    &:focus, &:active {
      color: $white;
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
