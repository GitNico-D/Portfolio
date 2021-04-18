<template>
  <div>
    <div id="alert" class="mt-2">
      <AlertForm
        v-if="successMessage"
        :message="successMessage"
        variant="success"
      />
      <AlertForm v-if="errorMessage" :message="errorMessage" variant="danger" />
    </div>
    <div class="text-center">
      <Button
        :color="contactColor"
        action="Retour présentation"
        icon="arrow-left"
        class="m-3 p-3"
        v-on:action="$emit('onReturn'), onReturn()"
      />
    </div>
    <div v-if="!oneContact.id">
      <h2 id="modifyForm-title" class="text-center fw-bold mt-5">
        Remplisser le formulaire ci-dessous pour ajouter un nouveau
        <span class="font-weight-bold font-style-italic">Contact !</span>
      </h2>
    </div>
    <div v-else>
      <h2 id="modifyForm-title" class="text-center fw-bold my-5">
        Modification du contact
        <p class="my-2">
          <span class="font-weight-bold font-style-italic"
            >"{{ currentTitle }}"</span
          >
        </p>
      </h2>
      <p class="mt-4 text-left" v-show="oneContact.id">
        ID du <span class="text-uppercase font-weight-bold">contact : </span>
        {{ oneContact.id }}
      </p>
    </div>
    <ValidationObserver ref="contactForm" v-slot="{ handleSubmit }">
      <b-form
        @submit.prevent="handleSubmit(onSubmit)"
        :methodAction="methodAction"
      >
        <ValidationProvider
          ref="title"
          rules="required|min:2"
          name="Nom"
          v-slot="{ errors }"
        >
          <b-form-group id="title">
            <label v-if="oneContact.id" for="input-name" class="text-uppercase"
              >Nouveau nom du contact</label
            >
            <label v-else for="input-title" class="text-uppercase"
              >Nom du contact</label
            >
            <b-form-input
              id="input-title"
              v-model="contact.title"
              placeholder="Entrer un nom"
            >
            </b-form-input>
            <b-alert variant="danger" v-if="errors[0]" v-text="errors[0]" show>
            </b-alert>
          </b-form-group>
        </ValidationProvider>
        <ValidationProvider
          ref="link"
          rules="required|url"
          name="Lien"
          v-slot="{ errors }"
        >
          <b-form-group id="link" class="mt-4">
            <label v-if="oneContact.id" for="input-link" class="text-uppercase"
              >Nouveau lien du contact</label
            >
            <label v-else for="input-link" class="text-uppercase"
              >Lien du contact</label
            >
            <b-form-input
              id="input-link"
              v-model="contact.link"
              placeholder="Entrer un lien/url"
            >
            </b-form-input>
            <b-alert variant="danger" v-if="errors[0]" v-text="errors[0]" show>
            </b-alert>
          </b-form-group>
        </ValidationProvider>
        <div>
          <h5
            v-show="!contact.icon && oldIcon"
            class="text-left text-uppercase"
          >
            Icone du contact
          </h5>
          <b-img
            :src="oldIcon"
            fluid
            alt="Fluid image"
            class="mt-1"
            v-show="!contact.icon && oldIcon"
          ></b-img>
        </div>
        <ValidationProvider
          ref="logo-contact"
          :rules="!oneContact.id ? 'required' : ''"
          name="Icone"
          v-slot="{ errors }"
        >
          <b-form-group id="logo-contact" class="mt-4">
            <label for="input-logo-contact" class="text-uppercase"
              >Icone du contact</label
            >
            <b-form-file
              id="input-logo-contact"
              ref="file"
              name="logo-contact"
              v-model="contact.icon"
              :state="Boolean(contact.icon)"
              accept="image/*"
              browse-text="Parcourir"
              placeholder="Choisir un fichier ou glisser-déposer ici"
              drop-placeholder="Choisir un fichier"
              @change="showPreview($event)"
            >
            </b-form-file>
            <b-alert variant="danger" v-if="errors[0]" v-text="errors[0]" show>
            </b-alert>
            <div class="mt-3">
              Icone sélectionné: {{ contact.icon ? contact.icon.name : "" }}
            </div>
            <b-img
              thumbnail
              fluid
              id="previewIcon"
              v-show="previewIconUrl && contact.icon"
              :src="previewIconUrl"
            ></b-img>
          </b-form-group>
        </ValidationProvider>
        <div class="d-flex justify-content-center">
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
              >Ajouter contact</span
            >
          </b-button>
          <Button
            v-show="!oneContact.id"
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
import formatDate from "../../services/formatDate";
import Button from "@/components/Button";
import setFormWithFile from "../../mixins/formMixin";

export default {
  name: "contactForm",
  components: {
    ValidationProvider,
    ValidationObserver,
    AlertForm,
    Button
  },
  data() {
    return {
      contactColor: "#485DA6",
      cancelButtonColor: "#BE8C2E",
      resetButtonColor: "#ef233c",
      contact: {
        title: "",
        link: "",
        icon: null,
        presentation: 1
      },
      oldIcon: "",
      currentTitle: "",
      previewIconUrl: "",
      loading: false,
      successMessage: "",
      errorMessage: ""
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
    ...mapGetters(["oneContact"])
  },
  methods: {
    ...mapActions([
      "addContact",
      "updateContactWithFile",
      "updateContactWithoutFile",
      "resetStateContact"
    ]),
    showPreview(event) {
      const file = event.target.files[0];
      if (file) {
        this.previewIconUrl = URL.createObjectURL(file);
        document.getElementById("previewIcon").onload = function() {
          window.URL.revokeObjectURL(this.previewIconUrl);
        };
      }
    },
    onSubmit() {
      if (this.methodAction == "create") {
        this.loading = true;
        this.$refs.contactForm.validate().then(isValid => {
          if (!isValid) {
            this.loading = false;
            return;
          }
          let fd = this.setFormWithFile(this.contact.icon, this.contact);
          this.addContact(fd)
            .then(() => {
              this.successMessage = "Le contact a été ajoutée !";
              document.getElementById("alert").scrollIntoView();
              this.loading = false;
              this.errorMessage = "";

              this.resetStateContact();
              this.resetForm();
            })
            .catch(error => {
              if (error.data[0]) {
                this.errorMessage = error.data[0].message;
              } else {
                this.errorMessage = error;
              }
              document.getElementById("alert").scrollIntoView();
              this.loading = false;
              this.successMessage = "";
            });
        });
      } else {
        this.loading = true;
        this.$refs.contactForm.validate().then(isValid => {
          if (!isValid) {
            this.loading = false;
            return;
          }
          if (!this.contact.icon) {
            this.updateContactWithoutFile({
              id: this.oneContact.id,
              form: this.contact
            })
              .then(() => {
                this.successMessage =
                  "Le contact " + this.oneContact.id + " a été modifié";
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
            let fd = this.setFormWithFile(this.contact.icon, this.contact);
            this.updateContactWithFile({
              id: this.oneContact.id,
              formData: fd
            })
              .then(() => {
                this.successMessage =
                  "Le contact " + this.oneContact.id + " a été modifié";
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
    onReturn() {
      this.successMessage = "";
      this.errorMessage = "";
    },
    resetForm() {
      this.$refs.contactForm.reset();
      this.loading = false;
      this.contact.title = "";
      this.contact.link = "";
      this.contact.icon = null;
      this.oldIcon = "";
      this.currentTitle = "";
    },
    formatDate(date) {
      return formatDate(date);
    }
  },
  mounted() {
    console.log(this.methodAction);
    console.log(this.oneContact);
    if (this.methodAction == "update" && this.oneContact) {
      this.contact = this.oneContact;
      this.currentTitle = this.oneContact.title;
      this.oldIcon = this.oneContact.icon;
      this.contact.icon = null;
    } else {
      this.resetForm();
    }
  }
};
</script>

<style lang="scss" scoped>
.btn {
  &-add {
    color: $white;
    background-color: $blue;
    border: 1px solid $blue;
    &:hover {
      color: $blue;
      background-color: transparent;
      border: 1px solid $blue;
    }
    &:focus,
    &:active {
      color: $white !important;
      box-shadow: unset;
      border: 1px solid $blue;
      background-color: $blue;
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
</style>
