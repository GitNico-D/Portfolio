<template>
<div> 
  <div id="alert">
    <AlertForm v-if="successMessage" v-show="oneSkill.id" :message="successMessage" variant="success"/>
    <AlertForm v-if="errorMessage" v-show="oneSkill.id" :message="errorMessage" variant="danger"/>
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
      <ValidationProvider ref="name" rules="required|min:2" name="Titre" v-slot="{ errors }">
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
      <ValidationProvider ref="new-icon" rules="required_if:modifySkill.icon" v-if="modifySkill" name="Image" v-slot="{ validate, errors }">
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
          >{{modifySkill.icon}}</b-form-file>
          <b-alert
            class="mt-1"
            variant="danger"
            v-if="errors[0]"
            v-text="errors[0]"
            show
          >
          </b-alert>
          <div class="mt-3">Icone sélectionnée: {{ modifySkill.icon ? modifySkill.icon.name : '' }}</div>
          <b-img thumbnail fluid id="previewImage" v-show="previewImageUrl && modifySkill.icon" :src="previewImageUrl"></b-img>
        </b-form-group>
      </ValidationProvider>
      <hr>
      <ValidationProvider ref="knowledge-level" rules="required|number" name="Niveau de compétence" v-slot="{ errors }">
        <b-form-group id="knowledge-level" class="mb-5">
          <label for="input-knowledge-level" class="text-uppercase">Nouveau niveau de la compétence</label>
          <b-form-input 
            id="input-knowledge-level" 
            v-model="modifySkill.knowledgeLevel"
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
      <div class="d-flex justify-content-center">
        <b-button type="submit" class="m-3 p-3 btn-modify" :disabled="loading" @click="$emit('showModifySkill')">
          <b-spinner v-show="loading" label="Spinning" class="pt-4 p"></b-spinner>
            <font-awesome-icon icon="edit"/>
            <span class="pl-2 pb-2">Modifier compétence</span>
        </b-button>
        <b-button class="m-3 p-3 btn-delete" @click="$emit('onCancelModify'), onCancel">
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
import { mapActions, mapGetters } from "vuex";
import AlertForm from "@/components/form/AlertForm";
import formatDate from "../../services/formatDate";
// import { setFormWithFile } from "../mixins/formMixin";

export default {
  name: "UpdateSkillForm",
  components: { 
    ValidationProvider,
    ValidationObserver,
    AlertForm
  },
  data() {
    return {
      loading: false,
      skillId: null,
      modifySkill: {
        name: '',
        description: '',
        icon: null,
        knowledgeLevel: 0,
      },
      oldIcon: '',
      currentName: '',
      previewImageUrl: null,
      successMessage: '',
      errorMessage: '',
      showForm: false 
    }
  },
  // mixins : [ setFormWithFile ],
  computed: {
    ...mapGetters(["oneSkill"]),    
  },
  methods: {
    ...mapActions(["updateSkillWithFile", "updateSkillWithoutFile", "resetStateSkill"]),
    showPreview(event) {
      const file = event.target.files[0];
      if(file) {
        this.previewImageUrl = URL.createObjectURL(file);
        document.getElementById("previewImage").onload = function () {
          window.URL.revokeObjectURL(this.previewImageUrl);
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
          if(!this.modifySkill.icon) {
            this.modifySkill.icon = this.oldIcon;
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
            let fd = new FormData();
            fd.append('icon', this.modifySkill.icon);
            Object.entries(this.modifySkill).forEach(
              ([key, value]) => {
                if (value !== null && value !== '') {
                  fd.append(`${key}`, value);
                }
              },
            );
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
      this.modifySkill.knowledgeLevel = 0
      this.oldIcon = ''
    },
    onCancel: function() {
      this.onReset(event);
    },
    formatDate(date) {
      return formatDate(date);
    },
  },
  mounted() {
    if(this.oneSkill.id) {
      this.modifySkill.name = this.oneSkill.name;
      this.currentName = this.oneSkill.name;
      this.modifySkill.description = this.oneSkill.description;
      this.modifySkill.knowledgeLevel = this.oneSkill.knowledgeLevel;
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
