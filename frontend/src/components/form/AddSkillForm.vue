<template>
  <div>
  <div id="alert">
    <AlertForm v-if="successMessage" :message="successMessage" variant="success"/>
    <AlertForm v-if="errorMessage" :message="errorMessage" variant="danger"/>
  </div>
  <h2 id="addForm-title" class="text-center fw-bold my-5">
    Remplisser le formulaire ci-dessous pour ajouter une nouvelle 
    <span class="font-weight-bold font-style-italic">Compétence !</span>
  </h2>
  <ValidationObserver ref="addForm" v-slot="{ handleSubmit }">
    <b-form @submit.prevent="handleSubmit(onCreate)" @reset.prevent="onReset" >
      <ValidationProvider ref="name" rules="required|min:2" name="Titre" v-slot="{ errors }">
        <b-form-group id="name">
          <label for="input-name" class="text-uppercase">Nom de la compétence</label>
          <b-form-input 
            id="input-name" 
            v-model="newSkill.name" 
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
      <ValidationProvider ref="description" rules="required|min:2" name="Description" v-slot="{ errors }">
        <b-form-group id="textarea">
          <label for="input-textarea" class="text-uppercase">Description de la compétence</label>
          <b-form-textarea
            id="input-textarea"
            v-model="newSkill.description"
            placeholder="Entrer une description"
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
      <ValidationProvider ref="level" rules="required|numeric" name="Niveau de compétence" v-slot="{ errors }">
        <b-form-group id="level" class="mt-4">
          <label for="input-level" class="text-uppercase">Niveau de compétence</label>
          <b-form-input
            type="number"
            id="input-level"
            v-model="newSkill.level"
            placeholder="Entrer le niveau de compétence"
            >
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
      <ValidationProvider ref="icon" rules="required" name="Image" v-slot="{ errors }">
        <b-form-group id="icon" class="mt-4">
          <label for="input-icon" class="text-uppercase">Icone de la compétence</label>
          <b-form-file
            id="input-icon"
            name="icon"
            v-model="newSkill.icon"
            :state="Boolean(newSkill.icon)"
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
        <div class="mt-3">Fichier sélectionné: {{ newSkill.icon ? newSkill.icon.name : '' }}</div>
        <b-img thumbnail fluid id="previewIcon" v-show="previewIconUrl && newSkill.icon" :src="previewIconUrl"></b-img>
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
        <b-button type="submit" class="m-3 p-3 btn-add" :disabled="loading" @click="$emit('addSkill'), onAdd">
          <b-spinner v-show="loading" label="Spinning" class="pt-4 pl-2"></b-spinner>
          <font-awesome-icon icon="folder-plus"/><span class="pl-2 pb-2">Ajouter compétence</span>
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
    <b-card class="mt-3" header="Form Data Result">
      <pre class="m-0">{{ newSkill }}</pre>
    </b-card>
  </ValidationObserver>
</div>
</template>

<script>
import { ValidationProvider, ValidationObserver } from "vee-validate";
import { mapActions } from "vuex";
import AlertForm from "@/components/form/AlertForm";
import setFormWithFile from "../../mixins/formMixin";

export default {
  name: "AddSkillForm",
  components: { 
    ValidationProvider,
    ValidationObserver,
    AlertForm
  },
  data() {
    return {
      newSkill: {
        name: '',
        description: '',
        icon: null,
        level: 0,
        category: null
      },
      loading: false,
      successMessage: '',
      errorMessage: '',
      previewIconUrl: null,
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
    },
  methods: {
    ...mapActions(["addSkill"]),
    setCategory() {
      return this.newSkill.category = this.selected;
    },
    showPreview(event) {
      const file = event.target.files[0];
      if(file) {
        this.previewIconUrl = URL.createObjectURL(file);
        document.getElementById("previewIcon").onload = function () {
          window.URL.revokeObjectURL(this.previewIconUrl);
        }
      }
    },
    onCreate() {
      this.loading = true;
      this.$refs.addForm.validate()
        .then(isValid => {
          if (!isValid) {
            this.loading = false;
            return
          }
          let fd = this.setFormWithFile(this.newSkill.icon, this.newSkill);     
        this.addSkill(fd)
          .then(() => {
            this.successMessage = "La compétence a été ajoutée !";
            document.getElementById("alert").scrollIntoView();
            this.loading = false;
            this.errorMessage = '';
            this.onReset(event);
          })
          .catch((error) => {
            this.errorMessage = error.message; //.data[0];
            document.getElementById("alert").scrollIntoView();
            this.loading = false;
            this.successMessage  = '';
          })
      });
    },
    onReset(event) {
      event.preventDefault()
      this.loading = false;
      this.newSkill.name = ''
      this.newSkill.description = ''
      this.newSkill.url = ''
      this.newSkill.icon = null
      this.newSkill.level = 0
      this.newSkill.creationDate = ''
    },
    onAdd() {
      this.loading = false;
      this.newSkill.title = ''
      this.newSkill.link = ''
      this.newSkill.icon = null
    },
    onCancel() {
      this.$refs.addForm.reset
      this.loading = false;
      this.newSkill.title = ''
      this.newSkill.link = ''
      this.newSkill.icon = null
    }
  }  
}
</script>

<style lang="scss" scoped>
.btn {
  &-add {
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
