<template>
  <div>
    <div id="alert">
      <AlertForm
        v-if="successMessage"
        :message="successMessage"
        variant="success"
      />
      <AlertForm v-if="errorMessage" :message="errorMessage" variant="danger" />
    </div>
    <div class="text-center">
      <Button
        :color="careerColor"
        action="Retour liste"
        icon="arrow-left"
        class="m-3 p-3"
        v-on:action="$emit('onReturn'), onReturn()"
      />
    </div>
    <div v-if="!oneCareer.id">
      <h2 id="modifyForm-title" class="text-center fw-bold my-5 career-form-title">
        Remplisser le formulaire ci-dessous pour ajouter une nouvelle
        <span class="font-weight-bold font-style-italic"
          >Étape de carrière !</span
        >
      </h2>
    </div>
    <div v-else>
      <h2 id="modifyForm-title" class="text-center fw-bold my-5 career-form-title">
        Modification du CareerStage
        <p class="my-2">
          <span class="font-weight-bold font-style-italic"
            >"{{ currentName }}"</span
          >
        </p>
      </h2>
      <p class="mt-4 text-left" v-show="oneCareer.id">
        ID de
        <span class="text-uppercase font-weight-bold"
          >l'étape de carrière :
        </span>
        {{ oneCareer.id }}
      </p>
    </div>
    <ValidationObserver ref="careerForm" v-slot="{ handleSubmit }">
      <b-form
        @submit.prevent="handleSubmit(onSubmit)"
        :methodAction="methodAction"
      >
        <ValidationProvider
          ref="name"
          rules="required|min:2|max:100"
          name="Titre"
          v-slot="{ errors }"
        >
          <b-form-group id="name" class="mb-5">
            <label v-if="oneCareer.id" for="input-name" class="text-uppercase"
              >Nouvelle intitulé de l'étape de carrière
            </label>
            <label v-else for="input-name" class="text-uppercase"
              >Intitulé de l'étape de carrière</label
            >
            <b-form-input
              id="input-name"
              v-model="career.name"
              placeholder="Entrer un nom"
            >
            </b-form-input>
            <b-alert variant="danger" v-if="errors[0]" v-text="errors[0]" show>
            </b-alert>
          </b-form-group>
        </ValidationProvider>
        <ValidationProvider
          ref="description"
          rules="required|min:2"
          name="Description"
          v-slot="{ errors }"
        >
          <b-form-group id="textarea" class="mb-5">
            <label v-if="oneCareer.id" for="input-name" class="text-uppercase"
              >Nouvelle description de l'étape de carrière</label
            >
            <label v-else for="input-textarea" class="text-uppercase"
              >Description de l'étape de carrière</label
            >
            <b-form-textarea
              id="input-textarea"
              v-model="career.description"
              placeholder="Entrer une description"
              size="lg"
            >
            </b-form-textarea>
            <b-alert
              variant="danger"
              v-if="errors[0]"
              v-text="errors[0]"
              show
              dismissible
            >
            </b-alert>
          </b-form-group>
        </ValidationProvider>
        <ValidationProvider
          ref="company"
          rules="required|min:2|max:50"
          name="Société"
          v-slot="{ errors }"
        >
          <b-form-group id="company" class="mb-5">
            <label
              v-if="oneCareer.id"
              for="input-company"
              class="text-uppercase"
              >Nouvelle société de l'étape de carrière</label
            >
            <label v-else for="input-company" class="text-uppercase"
              >Société de l'étape de carrière</label
            >
            <b-form-input
              id="input-company"
              v-model="career.company"
              placeholder="Entrer un nom"
            >
            </b-form-input>
            <b-alert
              variant="danger"
              v-if="errors[0]"
              v-text="errors[0]"
              show
              dismissible
            >
            </b-alert>
          </b-form-group>
        </ValidationProvider>
        <div v-if="!oneCareer.id || oldLogoCompany">
          <h5
            v-show="!career.logoCompany && oldLogoCompany"
            class="text-left text-uppercase"
          >
            Logo de la société
          </h5>
          <b-img
            :src="oldLogoCompany"
            fluid
            alt="Fluid image"
            class="mt-1"
            v-show="!career.logoCompany && oldLogoCompany"
          ></b-img>
        </div>
        <div v-else>
          <p><span class="font-weight-bold">Aucune ancienne image trouvée</span></p>
        </div> 
        <ValidationProvider
          ref="logo-company"
          :rules="!oneCareer.id ? 'required' : ''"
          name="Logo"
          v-slot="{ errors }"
        >
          <b-form-group id="logo-company" class="mb-5">
            <label
              v-if="oneCareer.id"
              for="input-logoCompany"
              class="text-uppercase"
              >Nouveau logo de la société</label
            >
            <label v-else for="input-logo-company" class="text-uppercase"
              >Logo de la société</label
            >
            <b-form-file
              id="input-logo-company"
              ref="file"
              name="logo-company"
              v-model="career.logoCompany"
              :state="Boolean(career.logoCompany)"
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
              dismissible
            >
            </b-alert>
            <div class="mt-3">
              Fichier sélectionné:
              {{ career.logoCompany ? career.logoCompany.name : "" }}
            </div>
            <b-img
              thumbnail
              fluid
              id="previewLogoCompany"
              v-show="previewLogoCompanyUrl && career.logoCompany"
              :src="previewLogoCompanyUrl"
            ></b-img>
          </b-form-group>
        </ValidationProvider>
        <ValidationProvider
          ref="start-date"
          rules="required"
          name="Date de début"
          v-slot="{ errors }"
        >
          <b-form-group id="start-date" class="mt-4">
            <label
              v-if="oneCareer.id"
              for="input-start-date"
              class="text-uppercase"
              >Nouvelle date de début de l'étape de carrière</label
            >
            <label v-else for="input-start-date" class="text-uppercase"
              >Date de début de l'étape de carrière</label
            >
            <b-form-datepicker
              id="start-date"
              v-model="career.startDate"
              class="mb-2"
              placeholder="Choisir une date"
            ></b-form-datepicker>
            <b-alert
              variant="danger"
              v-if="errors[0]"
              v-text="errors[0]"
              show
              dismissible
            >
            </b-alert>
            <p v-if="oneCareer.id">
              Nouvelle date de début: '{{ formatDate(career.startDate) }}'
            </p>
            <p v-else>Date de début: '{{ career.startDate ? formatDate(career.startDate) : '' }}'</p>
          </b-form-group>
        </ValidationProvider>
        <ValidationProvider
          ref="end-date"
          rules="required"
          name="Date de fin"
          v-slot="{ errors }"
        >
          <b-form-group id="end-date" class="mt-4">
            <label v-if="oneCareer.id" for="input-end-date" class="text-uppercase"
              >Nouvelle date de fin de l'étape de carrière</label
            >
            <label v-else for="input-end-date" class="text-uppercase"
              >Date de fin de l'étape de carrière</label
            >
            <b-form-datepicker
              id="end-date"
              v-model="career.endDate"
              class="mb-2"
              placeholder="Choisir une date"
            ></b-form-datepicker>
            <b-alert
              variant="danger"
              v-if="errors[0]"
              v-text="errors[0]"
              show
              dismissible
            >
            </b-alert>
            <p v-if="oneCareer.id">
              Nouvelle date de fin: '{{ formatDate(career.endDate) }}'
            </p>
            <p v-else>Date de fin: '{{ career.endDate ? formatDate(career.endDate) : '' }}'</p>
          </b-form-group>
        </ValidationProvider>
        <div class="d-flex justify-content-center flex-wrap">
          <b-button
            type="submit"
            class="m-3 p-3 btn-add"
            :disabled="loading"
            @click="$emit('onAction'), onSubmit()"
          >
            <b-spinner
              v-show="loading"
              label="Spinning"
              class="pl-2"
            ></b-spinner>
            <font-awesome-icon icon="folder-plus" />
            <span v-if="oneCareer.id" class="pl-2 pb-2">Modifier Carrière</span>
            <span v-else class="pl-2">Ajouter étape de carrière</span>
          </b-button>
          <Button
            v-show="!oneCareer.id"
            :color="resetButtonColor"
            action="Réinitialiser formulaire"
            icon="trash-alt"
            class="m-3 p-3"
            v-on:action="resetForm"
          />
          <Button
            :color="cancelButtonColor"
            action="Annuler"
            icon="times"
            class="m-3 p-3"
            v-on:action="$emit('onCancel'), resetForm()"
          />
        </div>
      </b-form>
    </ValidationObserver>
  </div>
</template>

<script>
import { ValidationProvider, ValidationObserver } from "vee-validate";
import { mapActions, mapGetters } from "vuex";
import AlertForm from "@/components/form/AlertForm";
import Button from "@/components/Button";
import formatDate from "../../services/formatDate";
import setFormWithFile from "../../mixins/formMixin";

export default {
  name: "careerForm",
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
      career: {
        name: "",
        description: "",
        company: "",
        logoCompany: null,
        startDate: "",
        endDate: ""
      },
      oldLogoCompany: "",
      currentName: "",
      showForm: false,
      loading: false,
      successMessage: "",
      errorMessage: "",
      previewLogoCompanyUrl: ""
    };
  },
  props: {
    methodAction: {
      type: String,
      default: "create"
    }
  },
  computed: {
    ...mapGetters(["oneCareer"])
  },
  mixins: [setFormWithFile],
  methods: {
    ...mapActions([
      "addCareerStage",
      "updateCareerStageWithFile",
      "updateCareerStageWithoutFile",
      "resetStateCareerStage"
    ]),
    //Create a url with the file add in the input-file to display it
    showPreview(event) {
      const file = event.target.files[0];
      if (file) {
        this.previewLogoCompanyUrl = URL.createObjectURL(file);
        document.getElementById("previewLogoCompany").onload = function() {
          window.URL.revokeObjectURL(this.previewLogoCompanyUrl);
        };
      }
    },
    //Submit the form content after validation
    //In case it's a new career stage or a modification of a existing career stage
    onSubmit() {    
      console.log(this.methodAction)
      if (this.methodAction == "create") {
        this.loading = true;
        this.$refs.careerForm.validate().then(isValid => {
          if (!isValid) {
            this.loading = false;
            return;
          }
          //Create the formData in a external services
          let fd = this.setFormWithFile(this.career.logoCompany, this.career);
          this.addCareerStage(fd)
            .then(() => {
              this.successMessage = "L'étape de carrière a été ajoutée !";
              this.loading = false;
              this.errorMessage = "";
              this.resetForm();
              document.getElementById("alert").scrollIntoView();
            })
            .catch(error => {
              if (error.data[0]) {
                this.errorMessage = error.data[0].message;
              } else {
                this.errorMessage = error;
              }
              this.successMessage = "";
              this.loading = false;
              this.successMessage = "";
              document.getElementById("alert").scrollIntoView();
            });
        });
      } else {
        this.loading = true;
        this.$refs.careerForm.validate().then(isValid => {
          if (!isValid) {
            this.loading = false;
            return;
          }
          if (!this.career.logoCompany) {
            this.updateCareerStageWithoutFile({
              id: this.oneCareer.id,
              form: this.career
            })
              .then(() => {
                this.successMessage =
                  "L'étape de carrière " +
                  this.oneCareer.id +
                  " a été modifier";
                this.loading = false;
                this.resetForm();
                document.getElementById("alert").scrollIntoView();
              })
              .catch(error => {
                if (error.data) {
                  this.errorMessage = error.data[0].message;
                } else {
                  this.errorMessage = error;
                }
                this.successMessage = "";
              });
          } else {
            let fd = this.setFormWithFile(this.career.logoCompany, this.career);
            this.updateCareerStageWithFile({
              id: this.oneCareer.id,
              formData: fd
            })
              .then(() => {
                this.successMessage =
                  "L'étape de carrière " +
                  this.oneCareer.id +
                  " a été modifier";
                this.loading = false;
                this.resetForm();
                document.getElementById("alert").scrollIntoView();
              })
              .catch(error => {
                if (error.data[0]) {
                  this.errorMessage = error.data[0].message;
                } else {
                  this.errorMessage = error;
                }
                this.successMessage = "";
              });
          }
        });
      }
    },
    //Reset all the form data
    resetForm() {
      this.$refs.careerForm.reset();
      this.loading = false;
      this.career.name = "";
      this.career.description = "";
      this.career.company = "";
      this.career.logoCompany = null;
      this.career.startDate = "";
      this.career.endDate = "";
      this.oldLogoCompany = "";
      this.previewLogoCompanyUrl = "";
      this.currentName = "";
    },
    //Erase the alert message
    onReturn() {
      this.successMessage = "";
      this.errorMessage = "";
    },
    //Format the date in an external service
    formatDate(date) {
      return formatDate(date);
    }
  },
  mounted() {
    //According to the method received, fill in the form data
    if (this.methodAction == "update") {
      this.career.name = this.oneCareer.name;
      this.career.description = this.oneCareer.description;
      this.career.company = this.oneCareer.company;
      this.career.startDate = this.oneCareer.startDate;
      this.career.endDate = this.oneCareer.endDate;
      this.oldLogoCompany = this.oneCareer.logoCompany;
      this.currentName = this.oneCareer.name;
      this.career.logoCompany = null;
    }
  }
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
    &:focus,
    &:active {
      color: $white !important;
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
.form-group {
  margin-bottom: 2rem;
}
.custom-file-label {
  background-color: transparent !important;
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
  color: $white !important;
}
.tabs {
  font-family: "Oswald", sans-serif;
  letter-spacing: 1px;
}
@media (min-width: 320px) {
  form {
    width: 100%;
    margin: auto;
  }
  .career-form-title {
    font-size: 1.2rem;
  }
}
@media (min-width: 576px) {
  .career-form-title {
    font-size: 1.5rem;
  }
}
@media (min-width: 768px) {
  form {
    width: 100%;
    margin: auto;
    padding: 1.5rem;
  }
  .career-form-title {
    font-size: 2rem;
  }
}
</style>
