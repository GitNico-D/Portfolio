<template>
<div> 
  <div id="alert" class="mt-2">
    <AlertForm v-if="successMessage" v-show="oneContact.id" :message="successMessage" variant="success"/>
    <AlertForm v-if="errorMessage" v-show="oneContact.id" :message="errorMessage" variant="danger"/>
  </div>
  <div class="text-center">
    <Button :color="contactColor" action="Retour présentation" icon="arrow-left" class="m-3 p-3" v-on:action="$emit('onReturn'), onReturn()"/>
  </div>
  <h2 v-if="!oneContact.id" id="modifyForm-title" ref="titleForm" class="text-center fw-bold mt-5" >
    <p>Aucun <span class="font-weight-bold font-style-italic">Contact</span> sélectionné.</p>
    <p>Rendez-vous sur l'onglet 
      <span class="font-style-italic">"Présentation"</span> 
      pour sélectionné le contact que vous souhaitez modifier.
    </p>
  </h2>
  <h2 v-else id="modifyForm-title" class="text-center fw-bold my-5" >
    Modification du contact 
    <p class="my-2"><span class="font-weight-bold font-style-italic">"{{ currentTitle }}"</span></p>
  </h2>
  <p class="mt-4 text-left" v-show="oneContact.id">
    ID du <span class="text-uppercase font-weight-bold">contact : </span>
    {{oneContact.id}}
  </p>
  <ValidationObserver ref="modifyForm" v-slot="{ handleSubmit }" >
    <b-form @submit.prevent="handleSubmit(onModify)" >
      <ValidationProvider ref="name" rules="required|min:2" name="Name" v-slot="{ errors }">
        <b-form-group id="name">
          <label for="input-name" class="text-uppercase">Nouveau nom du contact</label>
          <b-form-input 
            id="input-name" 
            v-model="modifyContact.title" 
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
          <label for="input-link" class="text-uppercase">Nouveau lien du contact</label>
          <b-form-input
            id="input-link"
            v-model="modifyContact.link"
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
      <div >
        <h5 v-show="!modifyContact.icon && oldIcon" class="text-left text-uppercase">Icone du contact</h5>
        <b-img :src="oldIcon" fluid alt="Fluid image" class="mt-1" v-show="!modifyContact.icon && oldIcon"></b-img>
      </div>
      <ValidationProvider ref="icon" name="Icone" v-slot="{ errors }">
        <b-form-group id="icon" class="mt-4">
          <label for="input-icon" class="text-uppercase">Nouvelle icone du contact</label>
          <b-form-file
            id="input-icon"
            name="icon"
            v-model="modifyContact.icon"
            :state="Boolean(modifyContact.icon)"
            browse-text="Parcourir"
            placeholder="Choisir un fichier ou glisser-déposer ici"
            drop-placeholder="Choisir un fichier"
            @change="showPreview($event)"
          ></b-form-file>
        <b-alert
          variant="danger"
          v-if="errors[0]"
          v-text="errors[0]"
          show
          dismissible>
        </b-alert>
        <div class="mt-3">Icone sélectionné: {{ modifyContact.icon ? modifyContact.icon.name : '' }}</div>
        <b-img thumbnail fluid id="previewIcon" v-show="previewIconUrl && modifyContact.icon" :src="previewIconUrl"></b-img>
        </b-form-group>
      </ValidationProvider> 
      <div class="d-flex justify-content-center">
        <b-button type="submit" class="m-3 p-3 btn-modify" :disabled="loading" @click="$emit('updateContact')">
          <b-spinner v-show="loading" label="Spinning" class="mr-2"></b-spinner>
            <font-awesome-icon icon="edit"/>
            <span class="pl-2 pb-2">Modifier contact</span>
        </b-button>
        <Button :color="cancelButtonColor" action="Annuler" icon="times" class="m-3 p-3" v-on:action="$emit('onCancelModify'), resetForm()"/>
      </div>
    </b-form>
  </ValidationObserver>
</div>
</template>

<script>
import { ValidationProvider, ValidationObserver } from "vee-validate";
import { mapActions, mapGetters } from "vuex";
import AlertForm from "@/components/form/AlertForm";
import Button from"@/components/Button";
import formatDate from "../../services/formatDate";
import setFormWithFile from "../../mixins/formMixin";

export default {
  name: "UpdateContactForm",
  components: { 
    ValidationProvider,
    ValidationObserver,
    AlertForm,
    Button
  },
  data() {
    return {
      cancelButtonColor: "#BE8C2E",
      contactColor: "#485DA6",
      loading: false,
      contactId: null,
      modifyContact: {
        title: '',
        link: '',
        icon: null
      },
      oldIcon: '',
      currentTitle: '',
      previewIconUrl: null,
      successMessage: '',
      errorMessage: ''
    }
  },
  mixins : [ setFormWithFile ],
  computed: {
    ...mapGetters(["oneContact"]), 
  },
  methods: {
    ...mapActions(["updateContactWithFile", "updateContactWithoutFile", "resetStateContact"]),
    showPreview(event) {
      const file = event.target.files[0];
      if(file) {
        this.previewIconUrl = URL.createObjectURL(file);
        document.getElementById("previewIcon").onload = function () {
          window.URL.revokeObjectURL(this.previewIconUrl);
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
          if(!this.modifyContact.icon) {
            this.updateContactWithoutFile({
              id: this.oneContact.id, 
              form: this.modifyContact
            })
            .then(() => {
              this.successMessage = 'Le contact ' + this.oneContact.id + ' a été modifié';
              this.loading = false;
              this.errorMessage = ''
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
            let fd = this.setFormWithFile(this.modifyContact.icon, this.modifyContact)
            this.updateContactWithFile({
              id: this.oneContact.id, 
              formData: fd
            })
            .then(() => {
              this.successMessage = 'Le contact ' + this.oneContact.id + ' a été modifié';
              this.loading = false;
              this.errorMessage = ''
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
      this.modifyContact.title = ''
      this.modifyContact.link = ''
      this.modifyContact.icon = null
      this.oldIcon = ''
      this.currentTitle = ''
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
    if(this.oneContact) {
      this.modifyContact = this.oneContact;
      this.currentTitle = this.oneContact.title;
      this.oldIcon = this.oneContact.icon;
      this.modifyContact.icon = null;
    }
  },
  
}
</script>

<style lang="scss" scoped>
.btn {
  &-modify {
    color: $white;
    background-color: $blue;
    border: 1px solid $blue;
    &:hover {
      color: $blue;
      background-color: transparent;
      border: 1px solid $blue;
    }
    &:focus, &:active {
      color: $white!important;
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
.custom-file-label {
  background-color: transparent!important;
  color: $white;
  border: unset;
  border-bottom: 1px solid $white;
  border-radius: unset;
  &:focus {
    @include box_shadow(0px, 0px, 5px, $blue);
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
