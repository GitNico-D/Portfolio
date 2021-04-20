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
        :color="softwareColor"
        action="Retour liste"
        icon="arrow-left"
        class="m-3 p-3"
        v-on:action="$emit('onReturn'), onReturn()"
      />
    </div>
    <div v-if="!oneSoftware.id">
      <h2 id="addForm-title" class="text-center fw-bold my-5 software-form-title">
        Remplisser le formulaire ci-dessous pour ajouter un nouveau
        <span class="font-weight-bold font-style-italic">Logiciel !</span>
      </h2>
    </div>
    <div v-else>
      <h2 id="modifyForm-title" class="text-center fw-bold my-5 software-form-title">
        Modification du Logiciel
        <p class="my-2">
          <span class="font-weight-bold font-style-italic"
            >"{{ currentName }}"</span
          >
        </p>
      </h2>
      <p class="mt-4 text-left" v-show="oneSoftware.id">
        ID du <span class="text-uppercase font-weight-bold">Logiciel : </span>
        {{ oneSoftware.id }}
      </p>
    </div>
    <ValidationObserver ref="softwareForm" v-slot="{ handleSubmit }">
      <b-form
        @submit.prevent="handleSubmit(onSubmit)"
        :methodAction="methodAction"
      >
        <ValidationProvider
          ref="name"
          rules="required|min:2|max:75"
          name="Nom"
          v-slot="{ errors }"
        >
          <b-form-group id="name" class="mb-5">
            <label v-if="oneSoftware.id" for="input-name" class="text-uppercase"
              >Nouveau nom du logiciel</label
            >
            <label v-else for="input-name" class="text-uppercase"
              >Nom du logiciel</label
            >
            <b-form-input
              id="input-name"
              v-model="software.name"
              placeholder="Entrer un nom"
            >
            </b-form-input>
            <b-alert variant="danger" v-if="errors[0]" v-text="errors[0]" show>
            </b-alert>
          </b-form-group>
        </ValidationProvider>
        <ValidationProvider
          ref="level"
          rules="required|numeric"
          name="Niveau"
          v-slot="{ errors }"
        >
          <b-form-group id="level" class="mb-5">
            <label
              v-if="oneSoftware.id"
              for="input-level"
              class="text-uppercase"
              >Nouveau niveau du logiciel</label
            >
            <label v-else for="input-level" class="text-uppercase"
              >Niveau du logiciel</label
            >
            <b-form-input
              type="number"
              id="input-level"
              v-model="software.level"
              placeholder="0"
            >
            </b-form-input>
            <b-alert variant="danger" v-if="errors[0]" v-text="errors[0]" show>
            </b-alert>
          </b-form-group>
        </ValidationProvider>
        <div v-if="!oneSoftware.id || oldIcon">
          <h5
            v-show="!software.icon && oldIcon"
            class="text-left text-uppercase"
          >
            Icone du logiciel
          </h5>
          <b-img
            :src="oldIcon"
            fluid
            alt="Fluid image"
            class="mt-1"
            v-show="!software.icon && oldIcon"
          ></b-img>
        </div>
        <div v-else>
          <p><span class="font-weight-bold">Aucune ancienne image trouvée</span></p>
        </div>
        <ValidationProvider
          ref="icon"
          rules="required"
          name="Icone"
          v-slot="{ errors }"
        >
          <b-form-group id="icon" class="mb-5">
            <label v-if="oneSoftware.id" for="input-icon" class="text-uppercase"
              >Nouvelle icone du logiciel</label
            >
            <label v-else for="input-icon" class="text-uppercase"
              >Icone du logiciel</label
            >
            <b-form-file
              id="input-icon"
              name="icon"
              v-model="software.icon"
              :state="Boolean(software.icon)"
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
              Fichier sélectionné: {{ software.icon ? software.icon.name : "" }}
            </div>
            <b-img
              thumbnail
              fluid
              id="previewIcon"
              v-show="previewIconUrl && software.icon"
              :src="previewIconUrl"
            ></b-img>
          </b-form-group>
        </ValidationProvider>
        <ValidationProvider
          ref="category"
          rules="required"
          name="Catégorie"
          v-slot="{ errors }"
        >
          <b-form-group id="category" class="mb-5">
            <label for="input-category" class="text-uppercase"
              >Choix de la categorie</label
            >
            <b-form-select
              v-model="selected"
              :options="options"
              @change="setCategory"
            >
            </b-form-select>
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
              class="pt-4 pl-2"
            ></b-spinner>
            <font-awesome-icon icon="folder-plus" /><span class="pl-2 pb-2"
              >Ajouter logiciel</span
            >
          </b-button>
          <Button
            v-show="!oneSoftware.id"
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
  name: "SoftwareForm",
  components: {
    ValidationProvider,
    ValidationObserver,
    AlertForm,
    Button
  },
  data() {
    return {
      softwareColor: "#36C486",
      cancelButtonColor: "#BE8C2E",
      resetButtonColor: "#ef233c",
      software: {
        name: "",
        icon: null,
        level: "",
        category: null
      },
      oldIcon: "",
      currentName: "",
      loading: false,
      successMessage: "",
      errorMessage: "",
      previewIconUrl: null,
      selected: null,
      options: [
        { value: null, text: "Choisir une catégorie" },
        { value: 1, text: "Informatique" },
        { value: 2, text: "Son" },
        { value: 3, text: "Vidéo" }
      ]
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
    ...mapGetters(["oneCategory", "oneSoftware"])
  },
  methods: {
    ...mapActions([
      "addSoftware",
      "updateSoftwareWithFile",
      "updateSoftwareWithoutFile",
      "resetStateSoftware"
    ]),
    setCategory() {
      return (this.software.category = this.selected);
    },
    //Create a url with the file add in the input-file to display it
    showPreview(event) {
      const file = event.target.files[0];
      if (file) {
        this.previewIconUrl = URL.createObjectURL(file);
        document.getElementById("previewIcon").onload = function() {
          window.URL.revokeObjectURL(this.previewIconUrl);
        };
      }
    },
    //Submit the form content after validation
    //In case it's a new contact or a modification of a existing contact
    onSubmit() {
      if (this.methodAction == "create") {
        this.loading = true;
        this.$refs.softwareForm.validate().then(isValid => {
          if (!isValid) {
            this.loading = false;
            return;
          }
          let fd = this.setFormWithFile(this.software.icon, this.software);
          this.addSoftware(fd)
            .then(() => {
              this.successMessage = "Le logiciel a été ajoutée !";
              document.getElementById("alert").scrollIntoView();
              this.loading = false;
              this.errorMessage = "";
              this.resetForm();
            })
            .catch(error => {
              this.errorMessage = error.data[0].message;
              document.getElementById("alert").scrollIntoView();
              this.loading = false;
              this.successMessage = "";
            });
        });
      } else {
        this.loading = true;
        this.$refs.softwareForm.validate().then(isValid => {
          if (!isValid) {
            this.loading = false;
            return;
          }
          if (!this.modifySoftware.icon) {
            this.updateSoftwareWithoutFile({
              id: this.oneSoftware.id,
              form: this.modifySoftware
            })
              .then(() => {
                this.successMessage =
                  "Le logiciel " + this.oneSoftware.id + " a été modifier";
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
          } else {
            let fd = this.setFormWithFile(
              this.modifySoftware.icon,
              this.modifySoftware
            );
            this.updateSoftwareWithFile({
              id: this.oneSoftware.id,
              formData: fd
            })
              .then(() => {
                this.successMessage =
                  "Le logiciel " + this.oneSoftware.id + " a été modifier";
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
      this.$refs.softwareForm.reset();
      this.loading = false;
      this.software.name = "";
      this.software.icon = null;
      this.software.level = "";
      this.oldIcon = "";
      this.currentName = "";
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
    this.selected = null;
    if (this.methodAction == "update") {
      this.software.name = this.oneSoftware.name;
      this.software.level = this.oneSoftware.level;
      this.currentName = this.oneSoftware.name;
      this.oldIcon = this.oneSoftware.icon;
      this.software.icon = null;
      this.selected = this.oneCategory.id;
      this.software.category = this.oneCategory.id;
    } else {
      this.selected = 0;
      this.selected = this.oneCategory.id;
      this.software.category = this.oneCategory.id;
    }
  }
};
</script>

<style lang="scss" scoped>
.btn {
  &-add,
  &-return {
    color: $white;
    background-color: $green;
    border: 1px solid $green;
    &:hover {
      color: $green;
      background-color: transparent;
      border: 1px solid $green;
    }
    &:focus,
    &:active {
      color: $white !important;
      box-shadow: unset;
      border: 1px solid $green;
      background-color: $green;
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
@media(min-width: 320px){
  form {
    width: 100%;
    margin: auto;
  }
  .software-form-title {
    font-size: 1.2rem;
  }
}
@media(min-width: 576px)
{
  .software-form-title {
    font-size: 1.5rem;
  }
}
@media(min-width: 768px){
  form {
    width: 100%;
    margin: auto;
    padding: 1.5rem;
  }
  .software-form-title {
    font-size: 2rem;
  }
}
</style>
