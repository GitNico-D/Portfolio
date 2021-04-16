<template>
<div> 
  <div id="alert">
    <AlertForm v-if="successMessage" v-show="oneSoftware.id" :message="successMessage" variant="success"/>
    <AlertForm v-if="errorMessage" v-show="oneSoftware.id" :message="errorMessage" variant="danger"/>
  </div>
  <div class="text-center">
    <b-button v-if="!oneSoftware.id || successMessage" class="m-3 p-3 btn-return" @click="$emit('onReturn')">
      <font-awesome-icon icon="arrow-left"/>
      <span class="pl-2 pb-2">Retour liste</span>
    </b-button>
  </div>
  <h2 v-if="!oneSoftware.id" id="modifyForm-title" ref="titleForm" class="text-center fw-bold mt-5" >
    <p>Aucun <span class="font-weight-bold font-style-italic">Logiciel</span> sélectionné.</p>
    <p>Rendez-vous sur l'onglet 
      <span class="font-style-italic">"Liste des Compétences"</span> 
      pour sélectionner le logiciel que vous souhaitez modifier.
    </p>
  </h2>
  <h2 v-else id="modifyForm-title" class="text-center fw-bold my-5" >
    Modification du logiciel "{{ currentName }}"
  </h2>
  <p class="mt-4 text-left" v-show="oneSoftware.id">
    ID du <span class="text-uppercase font-weight-bold">logiciel : </span>
    {{oneSoftware.id}}
  </p>
  <ValidationObserver ref="modifyForm" v-slot="{ handleSubmit }" v-show="oneSoftware.id || showForm">
    <b-form @submit.prevent="handleSubmit(onModify)" >
      <ValidationProvider ref="name" rules="required|min:2" name="Nom" v-slot="{ errors }">
        <b-form-group id="name" class="mb-5">
          <label for="input-name" class="text-uppercase">Nouveau nom du logiciel</label>
          <b-form-input 
            id="input-name" 
            v-model="modifySoftware.name"
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
      <div >
        <h5 v-show="!modifySoftware.icon && oldIcon" class="text-left text-uppercase">Icone du logiciel</h5>
        <b-img :src="oldIcon" fluid alt="Fluid image" class="mt-1" v-show="!modifySoftware.icon && oldIcon"></b-img>
      </div>
      <ValidationProvider ref="new-icon" name="Icone" v-slot="{ validate, errors }">
        <b-form-group id="new-icon" class="mt-3 mb-5">
          <label for="input-icon" class="text-uppercase">Nouvelle icone du logiciel</label>
          <b-form-file
            id="input-new-icon"
            ref="file"
            name="new-icon"
            v-model="modifySoftware.icon"
            browse-text="Parcourir"
            accept="image/*"
            placeholder="Choisir un fichier ou glisser-déposer ici"
            drop-placeholder="Choisir un fichier"
            @change="showPreview($event), validate"
          >
          </b-form-file>
          <b-alert
            class="mt-1"
            variant="danger"
            v-if="errors[0]"
            v-text="errors[0]"
            show
          >
          </b-alert>
          <div class="mt-3">Icone sélectionnée: {{ modifySoftware.icon ? modifySoftware.icon.name : '' }}</div>
          <b-img thumbnail fluid id="previewIcon" v-show="previewIconUrl && modifySoftware.icon" :src="previewIconUrl"></b-img>
        </b-form-group>
      </ValidationProvider>
      <ValidationProvider ref="level" rules="required|numeric" name="Niveau" v-slot="{ errors }">
        <b-form-group id="level" class="mb-5">
          <label for="input-level" class="text-uppercase">Nouveau niveau du logiciel</label>
          <b-form-input 
            type="number"
            id="input-level" 
            v-model="modifySoftware.level"
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
      <ValidationProvider ref="category" rules="required" name="Catégorie" v-slot="{ errors }">
        <b-form-group id="category" class="mt-5 text">
          <label for="input-category" class="text-uppercase">Choix de la categorie</label>
            <b-form-select v-model="selected" :options="options" @change="setCategory">
            </b-form-select>
          <b-alert
            variant="danger"
            v-if="errors[0]"
            v-text="errors[0]"
            show
            dismissible>
          </b-alert>
        </b-form-group>
      </ValidationProvider>
      <div class="d-flex justify-content-center">
        <b-button type="submit" class="m-3 p-3 btn-modify" :disabled="loading" @click="$emit('showModifySoftware')">
          <b-spinner v-show="loading" label="Spinning" class="pt-4 p"></b-spinner>
            <font-awesome-icon icon="edit"/>
            <span class="pl-2 pb-2">Modifier compétence</span>
        </b-button>
        <b-button class="m-3 p-3 btn-delete" @click="$emit('onCancel'), onCancel">
          <font-awesome-icon icon="times"/>
          <span class="pl-2 pb-2">Annuler</span>
        </b-button>        
      </div>
      <b-card class="mt-3" header="Form Data Result">
        <pre class="m-0">{{ modifySoftware }}</pre>
      </b-card>
      <b-card class="mt-3" header="Form Data Result">
        <pre class="m-0">{{ oneSoftware }}</pre>
      </b-card>
    </b-form>
  </ValidationObserver>
</div>
</template>

<script>
import { ValidationProvider, ValidationObserver } from "vee-validate";
import { mapActions, mapGetters } from "vuex";
import AlertForm from "@/components/form/AlertForm";
import formatDate from "../../services/formatDate";
import setFormWithFile from "../../mixins/formMixin";

export default {
  name: "UpdateSoftwareForm",
  components: { 
    ValidationProvider,
    ValidationObserver,
    AlertForm
  },
  data() {
    return {
      loading: false,
      modifySoftware: {
        name: '',
        description: '',
        icon: null,
        level: 0,
        category: null
      },
      oldIcon: '',
      currentName: '',
      previewIconUrl: null,
      successMessage: '',
      errorMessage: '',
      showForm: false,
      selected: null,
      options: [
        {value: null, text: 'Choisir une catégorie' },
        {value: 1, text:'Informatique'},
        {value: 2, text:'Son'},
        {value: 3, text:'Vidéo'}
      ] 
    }
  },
  mixins : [ setFormWithFile ],
  computed: {
    ...mapGetters(["oneSoftware", "oneCategory"]),    
  },
  methods: {
    ...mapActions(["getCategory", "updateSoftwareWithFile", "updateSoftwareWithoutFile", "resetStateSoftware"]),
    showPreview(event) {
      const file = event.target.files[0];
      if(file) {
        this.previewIconUrl = URL.createObjectURL(file);
        document.getElementById("previewIcon").onload = function () {
          window.URL.revokeObjectURL(this.previewIconUrl);
        }
      }
    },
    setCategory() {
      return this.modifySoftware.category = this.selected;
    },
    onModify() {
      this.loading = true;
      this.$refs.modifyForm.validate()
        .then(isValid => {
          if (!isValid) {
            this.loading = false;
            return
          }
          if(!this.modifySoftware.icon) {
            this.updateSoftwareWithoutFile({
              id: this.oneSoftware.id, 
              form: this.modifySoftware
            })
            .then(() => {
              this.successMessage = 'Le logiciel ' + this.oneSoftware.id + ' a été modifier';
              this.loading = false;
              this.resetForm();
              document.getElementById("alert").scrollIntoView(); 
            })
            .catch((error) => {
              this.errorMessage = error.message;
            })
          } else {
            let fd = this.setFormWithFile(this.modifySoftware.icon, this.modifySoftware);
            this.updateSoftwareWithFile({
              id: this.oneSoftware.id, 
              formData: fd
            })
            .then(() => {
              this.successMessage = 'Le logiciel ' + this.oneSoftware.id + ' a été modifier';
              this.loading = false;
              this.resetForm();
              document.getElementById("alert").scrollIntoView();  
            })
            .catch((error) => {
              this.errorMessage = error.message;
            })
          }
      })
    },
    resetForm() {
      this.$refs.modifyForm.reset;
      this.modifySoftware.name = ''
      this.modifySoftware.icon = null
      this.modifySoftware.level = 0
      this.oldIcon = ''
      this.currentName = ''
    },
    onCancel: function() {
      this.resetForm();
    },
    formatDate(date) {
      return formatDate(date);
    },
  },
  mounted() {
    console.log(this.oneSoftware);
    if(this.oneSoftware && this.oneCategory) {
      this.modifySoftware = this.oneSoftware;
      this.modifySoftware.category = this.oneCategory.id
      this.currentName = this.oneSoftware.name;
      this.selected = this.oneCategory.id;
      this.oldIcon = this.oneSoftware.icon;
      this.modifySoftware.icon = null;
    }
  },
  
}
</script>

<style lang="scss" scoped>
.btn {
  &-modify, &-return {
    color: $white;
    background-color: $green;
    border: 1px solid $green;
    &:hover {
      color: $green;
      background-color: transparent;
      border: 1px solid $green;
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
