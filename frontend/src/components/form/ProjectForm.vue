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
        :color="projectColor"
        action="Retour liste"
        icon="arrow-left"
        class="m-3 p-3"
        v-on:action="$emit('onReturn'), onReturn()"
      />
    </div>
    <div v-if="!oneProject.id">
      <h2 id="modifyForm-title" class="text-center fw-bold my-5 project-form-title">
        Remplisser le formulaire ci-dessous pour ajouter un nouveau
        <span class="font-weight-bold font-style-italic">Projet !</span>
      </h2>
    </div>
    <div v-else>
      <h2 id="modifyForm-title" class="text-center fw-bold my-5 project-form-title">
        Modification du project
        <p class="my-2">
          <span class="font-weight-bold font-style-italic"
            >"{{ currentName }}"</span
          >
        </p>
      </h2>
      <p class="mt-4 text-left" v-show="oneProject.id">
        ID du <span class="text-uppercase font-weight-bold">projet : </span>
        {{ oneProject.id }}
      </p>
    </div>
    <ValidationObserver ref="projectForm" v-slot="{ handleSubmit }">
      <b-form
        @submit.prevent="handleSubmit(onSubmit)"
        :methodAction="methodAction"
      >
        <ValidationProvider
          ref="name"
          rules="required|min:2"
          name="Titre"
          v-slot="{ errors }"
        >
          <b-form-group id="name" class="mb-5">
            <label v-if="oneProject.id" for="input-name" class="text-uppercase"
              >Nouveau titre du projet</label
            >
            <label v-else for="input-name" class="text-uppercase"
              >Titre du projet</label
            >
            <b-form-input
              id="input-name"
              v-model="project.name"
              placeholder="Entrer nom du projet"
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
            <label v-if="oneProject.id" for="input-name" class="text-uppercase"
              >Nouvelle description du projet</label
            >
            <label v-else for="input-textarea" class="text-uppercase"
              >Description du projet</label
            >
            <b-form-textarea
              id="input-textarea"
              v-model="project.description"
              placeholder="Entrer description"
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
          ref="url"
          rules="required|url"
          name="Url"
          v-slot="{ errors }"
        >
          <b-form-group id="url" class="mb-5">
            <label v-if="oneProject.id" for="input-url" class="text-uppercase"
              >Nouvelle Url du projet</label
            >
            <label v-else for="input-url" class="text-uppercase"
              >Url du projet</label
            >
            <b-form-input
              id="input-url"
              v-model="project.url"
              placeholder="Entrer url du projet"
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
        <div v-if="!oneProject.id || oldImgStatic">
          <h5
            v-show="!project.imgStatic && oldImgStatic"
            class="text-left text-uppercase"
          >
            Image du projet
          </h5>
          <b-img
            thumbnail
            :src="oldImgStatic"
            fluid
            alt="Fluid image"
            class="mt-1"
            v-show="!project.imgStatic && oldImgStatic"
          ></b-img>
        </div>
        <div v-else>
          <p><span class="font-weight-bold">Aucune ancienne image trouvée</span></p>
        </div>
        <ValidationProvider
          ref="imgStatic"
          :rules="!oneProject.id ? 'required' : ''"
          name="Image"
          v-slot="{ errors }"
        >
          <b-form-group id="imgStatic" class="mb-5">
            <label
              v-if="oneProject.id"
              for="input-imgStatic"
              class="text-uppercase"
              >Nouvelle image de présentation du projet</label
            >
            <label v-else for="input-imgStatic" class="text-uppercase"
              >Image de présentation du projet</label
            >
            <b-form-file
              id="input-imgStatic"
              ref="file"
              name="imgStatic"
              v-model="project.imgStatic"
              :state="Boolean(project.imgStatic)"
              browse-text="Parcourir"
              accept="image/*"
              placeholder="Choisir un fichier ou glisser-déposer ici"
              drop-placeholder="Choisir un fichier"
              @change="showPreview($event)"
            >
            </b-form-file>
            <b-alert variant="danger" v-if="errors[0]" v-text="errors[0]" show>
            </b-alert>
            <div class="mt-3">
              Fichier sélectionné:
              {{ project.imgStatic ? project.imgStatic.name : "" }}
            </div>
            <b-img
              thumbnail
              fluid
              id="previewImgStatic"
              v-show="previewImgStaticUrl && project.imgStatic"
              :src="previewImgStaticUrl"
            ></b-img>
          </b-form-group>
        </ValidationProvider>
        <ValidationProvider
          ref="description-image"
          rules="required|min:2"
          name="Description de l'image"
          v-slot="{ errors }"
        >
          <b-form-group id="altStatic" class="mt-5">
            <label
              v-if="oneProject.id"
              for="input-altStatic"
              class="text-uppercase"
              >Nouvelle description de l'image du projet</label
            >
            <label v-else for="input-altStatic" class="text-uppercase"
              >Description de l'image du projet</label
            >
            <b-form-input
              id="input-altStatic"
              v-model="project.altStatic"
              placeholder="Entrer description"
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
        <ValidationProvider
          ref="creation-date"
          rules="required"
          name="Date de création "
          v-slot="{ errors }"
        >
          <b-form-group id="creation-date" class="mb-5">
            <label
              v-if="oneProject.id"
              for="input-end-date"
              class="text-uppercase"
              >Nouvelle date création du projet</label
            >
            <label v-else for="input-creation-date" class="text-uppercase"
              >Date de création du projet</label
            >
            <b-form-datepicker
              id="creation-date"
              v-model="project.creationDate"
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
            <p v-if="oneProject.id">
              Nouvelle date de création: '{{
                formatDate(project.creationDate)
              }}'
            </p>
            <p v-else>Date de création: '{{ project.creationDate }}'</p>
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
              class="mr-2"
            ></b-spinner>
            <font-awesome-icon icon="folder-plus" />
            <span v-if="oneProject.id" class="pl-2 pb-2">Modifier Projet</span>
            <span v-else class="pl-2">Ajouter projet</span>
          </b-button>
          <Button
            v-show="!oneProject.id"
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
  name: "ProjectForm",
  components: {
    ValidationProvider,
    ValidationObserver,
    AlertForm,
    Button
  },
  data() {
    return {
      cancelButtonColor: "#BE8C2E",
      projectColor: "#6d327c",
      resetButtonColor: "#ef233c",
      project: {
        name: "",
        description: "",
        imgStatic: null,
        altStatic: "",
        creationDate: ""
      },
      oldImgStatic: "",
      currentName: "",
      previewImageUrl: null,
      successMessage: "",
      errorMessage: "",
      previewImgStaticUrl: "",
      loading: false
    };
  },
  props: {
    methodAction: {
      type: String,
      default: "create"
    }
  },
  mixins: [setFormWithFile],
  computed: {
    ...mapGetters(["oneProject"])
  },
  methods: {
    ...mapActions([
      "addProject",
      "updateProjectWithFile",
      "updateProjectWithoutFile",
      "resetStateProject"
    ]),
    //Create a url with the file add in the input-file to display it
    showPreview(event) {
      const file = event.target.files[0];
      if (file) {
        this.previewImgStaticUrl = URL.createObjectURL(file);
        document.getElementById("previewImgStatic").onload = function() {
          window.URL.revokeObjectURL(this.previewImgStaticUrl);
        };
      }
    },
    //Submit the form content after validation
    //In case it's a new contact or a modification of a existing contact
    onSubmit() {
      if (this.methodAction == "create") {
        this.loading = true;
        this.$refs.projectForm.validate().then(isValid => {
          if (!isValid) {
            this.loading = false;
            return;
          }
          let fd = this.setFormWithFile(this.project.imgStatic, this.project);
          this.addProject(fd)
            .then(() => {
              this.successMessage = "Le projet a été ajouté !";
              document.getElementById("alert").scrollIntoView();
              this.loading = false;
              this.errorMessage = "";
              this.resetForm();
            })
            .catch(error => {
              if (error.data[0]) {
                this.errorMessage = error.data[0].message;
              } else {
                this.errorMessage = error;
              }
              this.successMessage = "";
              document.getElementById("alert").scrollIntoView();
              this.loading = false;
              this.successMessage = "";
            });
        });
      } else {
        this.loading = true;
        this.$refs.projectForm.validate().then(isValid => {
          if (!isValid) {
            this.loading = false;
            return;
          }
          if (!this.project.imgStatic) {
            this.updateProjectWithoutFile({
              id: this.oneProject.id,
              form: this.project
            })
              .then(() => {
                this.successMessage =
                  "Le projet " + this.oneProject.id + " a été modifier";
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
              });
          } else {
            let fd = this.setFormWithFile(this.project.imgStatic, this.project);
            this.updateProjectWithFile({
              id: this.oneProject.id,
              formData: fd
            })
              .then(() => {
                this.successMessage =
                  "Le projet " + this.oneProject.id + " a été modifier";
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
              });
          }
        });
      }
    },
    //Reset all the form data and the specific page data
    resetForm() {
      this.$refs.projectForm.reset();
      this.loading = false;
      this.project.name = "";
      this.project.description = "";
      this.project.url = "";
      this.project.imgStatic = null;
      this.project.altStatic = "";
      this.project.creationDate = "";
      this.oldImgStatic = "";
      this.previewImgStaticUrl = "";
    },
    //Erase the alert message
    onReturn() {
      this.successMessage = "";
      this.errorMessage = "";
    },
    formatDate(date) {
      return formatDate(date);
    }
  },
  mounted() {
    //According to the method received, fill in the form data
    if (this.methodAction == "update") {
      this.project.name = this.oneProject.name;
      this.project.description = this.oneProject.description;
      this.project.url = this.oneProject.url;
      this.project.altStatic = this.oneProject.altStatic;
      this.project.creationDate = this.oneProject.creationDate;
      this.currentName = this.oneProject.name;
      this.oldImgStatic = this.oneProject.imgStatic;
      this.project.imgStatic = null;
    } 
  }
};
</script>

<style lang="scss" scoped>
.btn {
  &-add {
    color: $white;
    background-color: $purple;
    border: 1px solid $purple;
    &:hover {
      color: $purple;
      background-color: transparent;
      border: 1px solid $purple;
    }
    &:focus,
    &:active {
      color: $white !important;
      box-shadow: unset;
      border: 1px solid $purple;
      background-color: $purple;
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
  .project-form-title {
    font-size: 1.2rem;
  }
}
@media (min-width: 576px) {
  .project-form-title {
    font-size: 1.5rem;
  }
}
@media (min-width: 768px) {
  form {
    width: 100%;
    margin: auto;
    padding: 1.5rem;
  }
  .project-form-title {
    font-size: 2rem;
  }
}
</style>
