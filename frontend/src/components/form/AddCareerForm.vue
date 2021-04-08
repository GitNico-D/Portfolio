<template>
  <div>
  <div id="alert">
    <AlertForm v-if="successMessage" :message="successMessage" variant="success"/>
    <AlertForm v-if="errorMessage" :message="errorMessage" variant="danger"/>
  </div>
  <h2 id="modifyForm-title" class="text-center fw-bold my-5">
    Remplisser le formulaire ci-dessous pour ajouter une nouvelle 
    <span class="font-weight-bold font-style-italic">Étape de carrière !</span>
  </h2>
  <ValidationObserver ref="addForm" v-slot="{ handleSubmit }">
    <b-form @submit.prevent="handleSubmit(onCreate)" @reset.prevent="onReset" >
      <ValidationProvider ref="name" rules="required|min:2" name="Titre" v-slot="{ errors }">
        <b-form-group id="name">
          <label for="input-name" class="text-uppercase">Titre de l'étape de carrière</label>
          <b-form-input 
            id="input-name" 
            v-model="newCareer.name" 
            placeholder="Entrer nom de l'étape de carrière">
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
      <ValidationProvider ref="company" rules="required" name="Société" v-slot="{ errors }">
        <b-form-group id="company" class="mt-4">
          <label for="input-company" class="text-uppercase">Société de l'étape de carrière</label>
          <b-form-input
            id="input-company"
            v-model="newCareer.company"
            placeholder="Entrer company de l'étape de carrière">
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
          ></b-form-file>
        <b-alert
          variant="danger"
          v-if="errors[0]"
          v-text="errors[0]"
          show
          dismissible>
        </b-alert>
        <div class="mt-3">Fichier sélectionné: {{ newCareer.logoCompany ? newCareer.logoCompany.name : '' }}</div>
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
        <b-button type="submit" variant="success" class="m-3 p-3" :disabled="loading">
          <b-spinner v-show="loading" label="Spinning" class="pt-4 p"></b-spinner>
          <span class="pl-2 pb-2">Ajouter étape de carrière</span>
        </b-button>
        <b-button type="reset" variant="danger" class="m-3 p-3" @click="onReset">
          Réinitialiser formulaire
        </b-button>
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
// import { setFormWithFile } from "../mixins/formMixin";

export default {
  name: "AddCareerForm",
  components: { 
    ValidationProvider,
    ValidationObserver,
    AlertForm
  },
  data() {
    return {
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
    }
  },
  // mixins : [ setFormWithFile ],
  methods: {
    ...mapActions(["addCareer"]),
    onCreate() {
      this.loading = true;
      this.$refs.addForm.validate()
        .then(isValid => {
          if (!isValid) {
            this.loading = false;
            return
          }
          let fd = new FormData();
          fd.append('logoCompany', this.newCareer.logoCompany)
          console.log(fd);
          Object.entries(this.newCareer).forEach(
            ([key, value]) => {
              if (value !== null && value !== '') {
                fd.append(`${key}`, value);
              }
            },
          );          
        this.addCareer(fd)
          .then(() => {
            this.successMessage = "LendDate'étape de carrière a été ajouté !";
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
      this.newCareer.name = ''
      this.newCareer.description = ''
      this.newCareer.company = ''
      this.newCareer.logoCompany = null
      this.newCareer.startDate = ''
      this.newCareer.endDate = ''
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
