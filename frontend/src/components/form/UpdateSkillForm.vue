<template>
<div> 
  <div id="alert">
    <AlertForm v-if="successMessage" v-show="oneSkill.id" :message="successMessage" variant="success"/>
    <AlertForm v-if="errorMessage" v-show="oneSkill.id" :message="errorMessage" variant="danger"/>
  </div>
  <div class="text-center">
    <Button :color="skillColor" action="Retour liste" icon="arrow-left" class="m-3 p-3" v-on:action="$emit('onReturn')"/>
  </div>
  <div class="text-center">
    <b-button v-if="!oneSkill.id || successMessage" class="m-3 p-3 btn-delete" @click="$emit('onReturn')">
      <font-awesome-icon icon="arrow-left"/>
      <span class="pl-2 pb-2">Retour liste</span>
    </b-button>
  </div>
  <h2 v-if="!oneSkill.id" id="modifyForm-title" ref="titleForm" class="text-center fw-bold mt-5" >
    <p>Aucune <span class="font-weight-bold font-style-italic">Compétence</span> sélectionnée.</p>
    <p>Rendez-vous sur l'onglet 
      <span class="font-style-italic">"Liste des Compétences"</span> 
      pour sélectionné le compétence que vous souhaitez modifier.
    </p>
  </h2>
  <h2 v-else id="modifyForm-title" class="text-center fw-bold my-5" >
    Modification de la compétence "{{ currentName }}"
  </h2>
  <p class="mt-4 text-left" v-show="oneSkill.id">
    ID de la <span class="text-uppercase font-weight-bold">compétence : </span>
    {{oneSkill.id}}
  </p>
  <ValidationObserver ref="modifyForm" v-slot="{ handleSubmit }" v-show="oneSkill.id || showForm">
    <b-form @submit.prevent="handleSubmit(onModify)" >
      <ValidationProvider ref="name" rules="required|min:2" name="Nom" v-slot="{ errors }">
        <b-form-group id="name" class="mb-5">
          <label for="input-name" class="text-uppercase">Nouveau nom de la compétence</label>
          <b-form-input 
            id="input-name" 
            v-model="modifySkill.name"
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
          <label for="input-textarea" class="text-uppercase">Nouvelle description de la compétence</label>
          <b-form-textarea
            id="input-textarea"
            v-model="modifySkill.description"
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
      <div >
        <h5 v-show="!modifySkill.icon && oldIcon" class="text-left text-uppercase">Icone de la compétence</h5>
        <b-img :src="oldIcon" fluid alt="Fluid image" class="mt-1" v-show="!modifySkill.icon && oldIcon"></b-img>
      </div>
      <ValidationProvider ref="new-icon" name="Icone" v-slot="{ validate, errors }">
        <b-form-group id="new-icon" class="mt-3 mb-5">
          <label for="input-icon" class="text-uppercase">Nouvelle Icone de la compétence</label>
          <b-form-file
            id="input-new-icon"
            ref="file"
            name="new-icon"
            v-model="modifySkill.icon"
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
          <div class="mt-3">Icone sélectionnée: {{ modifySkill.icon ? modifySkill.icon.name : '' }}</div>
          <b-img thumbnail fluid id="previewIcon" v-show="previewIconUrl && modifySkill.icon" :src="previewIconUrl"></b-img>
        </b-form-group>
      </ValidationProvider>
      <hr>
      <ValidationProvider ref="level" rules="required|numeric" name="Niveau de compétence" v-slot="{ errors }">
        <b-form-group id="level" class="mb-5">
          <label for="input-level" class="text-uppercase">Nouveau niveau de la compétence</label>
          <b-form-input 
            type="number"
            id="input-level" 
            v-model="modifySkill.level"
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
        <b-button type="submit" class="m-3 p-3 btn-modify" :disabled="loading" @click="$emit('showModifySkill')">
          <b-spinner v-show="loading" label="Spinning" class="mr-2"></b-spinner>
            <font-awesome-icon icon="edit"/>
            <span class="pl-2 pb-2">Modifier compétence</span>
        </b-button>
        <Button :color="cancelButtonColor" action="Annuler" icon="times" class="m-3 p-3" v-on:action="$emit('onCancelModify'), resetForm"/>
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
  name: "UpdateSkillForm",
  components: { 
    ValidationProvider,
    ValidationObserver,
    AlertForm,
    Button
  },
  data() {
    return {
      cancelButtonColor: "#BE8C2E",
      skillColor: "#36C486",
      loading: false,
      skillId: null,
      modifySkill: {
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
    ...mapGetters(["oneSkill", "oneCategory"]),    
  },
  methods: {
    ...mapActions(["getCategory", "updateSkillWithFile", "updateSkillWithoutFile", "resetStateSkill"]),
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
      return this.modifySkill.category = this.selected;
    },
    onModify() {
      this.loading = true;
      this.$refs.modifyForm.validate()
        .then(isValid => {
          if (!isValid) {
            this.loading = false;
            return
          }
          if(!this.modifySkill.icon) {
            this.updateSkillWithoutFile({
              id: this.oneSkill.id, 
              form: this.modifySkill
            })
            .then(() => {
              this.successMessage = 'La compétence ' + this.oneSkill.id + ' a été modifier';
              this.loading = false;
              this.resetForm();
              document.getElementById("alert").scrollIntoView(); 
            })
            .catch((error) => {
              this.errorMessage = error.message;
            })
          } else {
            let fd = this.setFormWithFile(this.modifySkill.icon, this.modifySkill);
            this.updateSkillWithFile({
              id: this.oneSkill.id, 
              formData: fd
            })
            .then(() => {
              this.successMessage = 'La compétence ' + this.oneSkill.id + ' a été modifier';
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
      this.modifySkill.name = ''
      this.modifySkill.description = ''
      this.modifySkill.icon = null
      this.modifySkill.level = 0
      this.oldIcon = ''
    },
    formatDate(date) {
      return formatDate(date);
    },
  },
  mounted() {
    console.log(this.oneSkill);
    if(this.oneSkill && this.oneCategory) {
      this.modifySkill = this.oneSkill;
      this.modifySkill.category = this.oneCategory.id
      this.currentName = this.oneSkill.name;
      this.selected = this.oneCategory.id;
      this.oldIcon = this.oneSkill.icon;
      this.modifySkill.icon = null;
    }
  },
  
}
</script>

<style lang="scss" scoped>
.btn {
  &-modify {
    color: $white;
    background-color: $green;
    border: 1px solid $green;
    &:hover {
      color: $green;
      background-color: transparent;
      border: 1px solid $green;
    }
    &:focus, &:active {
      color: $white!important;
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
