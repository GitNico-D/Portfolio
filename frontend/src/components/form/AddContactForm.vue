<template>
  <div>
  <h3 id="modifyForm-title" class="text-center fw-bold my-5">
    Remplisser le formulaire ci-dessous pour ajouter un nouveau
    <span class="font-weight-bold font-style-italic">Contact.</span>
  </h3>
  <div id="alert" class="mt-2">
    <AlertForm v-if="successMessage" :message="successMessage" variant="success"/>
    <AlertForm v-if="errorMessage" :message="errorMessage" variant="danger"/>
  </div>
  <ValidationObserver ref="addContactForm" v-slot="{ handleSubmit }">
    <b-form @submit.prevent="handleSubmit(onCreate)" @reset.prevent="onReset">
      <ValidationProvider ref="title" rules="required|min:2" name="Nom" v-slot="{ errors }">
        <b-form-group id="title">
          <label for="input-title" class="text-uppercase">Nom du contact</label>
          <b-form-input 
            id="input-title" 
            v-model="newContact.title" 
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
      <ValidationProvider ref="link" rules="required|url" name="Lien" v-slot="{ errors }">
        <b-form-group id="link" class="mt-4">
          <label for="input-link" class="text-uppercase">Lien du contact</label>
          <b-form-input
            id="input-link"
            v-model="newContact.link"
            placeholder="Entrer un lien/url">
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
      <ValidationProvider ref="logo-contact" rules="required" name="Icone" v-slot="{ errors }">
        <b-form-group id="logo-contact" class="mt-4">
          <label for="input-logo-contact" class="text-uppercase">Icone du contact</label>
          <b-form-file
            id="input-logo-contact"
            name="logo-contact"
            v-model="newContact.icon"
            :state="Boolean(newContact.icon)"
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
        <div class="mt-3">Icone sélectionné: {{ newContact.icon ? newContact.icon.name : '' }}</div>
        </b-form-group>
      </ValidationProvider>      
      <div class="d-flex justify-content-center">
        <b-button type="submit" class="m-3 p-3 btn-add" :disabled="loading" @click="$emit('addContact'), onAdd">
          <b-spinner v-show="loading" label="Spinning" class="pt-4 pl-2"></b-spinner>
          <font-awesome-icon icon="folder-plus"/><span class="pl-2 pb-2">Ajouter contact</span>
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
  name: "AddCcontactForm",
  components: { 
    ValidationProvider,
    ValidationObserver,
    AlertForm
  },
  data() {
    return {
      newContact: {
        title: '',
        link: '',
        icon: null,
        presentation: 1
      },
      loading: false,
      successMessage: '',
      errorMessage: '',
      showAddContactForm: false
    }
  },
  mixins : [ setFormWithFile ],
  methods: {
    ...mapActions(["addContact"]),
    onCreate() {
      this.loading = true;
      this.$refs.addContactForm.validate()
        .then(isValid => {
          if (!isValid) {
            this.loading = false;
            return
          }
        let fd = this.setFormWithFile(this.newContact.icon, this.newContact) 
        console.log(fd);       
        this.addContact(fd)
          .then(() => {
            this.successMessage = "Le contact a été ajoutée !";
            document.getElementById("alert").scrollIntoView();
            this.loading = false;
            this.errorMessage = '';
            this.onReset(event);
          })
          .catch((error) => {
            this.errorMessage = error.message;
            document.getElementById("alert").scrollIntoView();
            this.loading = false;
            this.successMessage  = '';
          })
      });
    },
    onReset(event) {
      event.preventDefault()
      this.loading = false;
      this.newContact.title = ''
      this.newContact.link = ''
      this.newContact.icon = null
      this.successMessage = ''
      this.errorMessage = '';
    },
    onAdd() {
      this.loading = false;
      this.newContact.title = ''
      this.newContact.link = ''
      this.newContact.icon = null
    },
    onCancel() {
      this.$refs.addForm.reset
      this.loading = false;
      this.newContact.title = ''
      this.newContact.link = ''
      this.newContact.icon = null
    }
  },
  
}
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
