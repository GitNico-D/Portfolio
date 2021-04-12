<template>
  <div>
  <div id="alert">
    <AlertForm v-if="successMessage" :message="successMessage" variant="success"/>
    <AlertForm v-if="errorMessage" :message="errorMessage" variant="danger"/>
  </div>
  <h2 id="modifyForm-title" class="text-center fw-bold my-5">
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
      <ValidationProvider ref="knowledge-level" rules="required|numeric" name="Niveau de compétence" v-slot="{ errors }">
        <b-form-group id="knowledge-level" class="mt-4">
          <label for="input-knowledge-level" class="text-uppercase">Niveau de compétence</label>
          <b-form-input
            id="input-knowledge-level"
            v-model="newSkill.knowledgeLevel"
            placeholder="Entrer le niveau de compétence">
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
          <label for="input-icon" class="text-uppercase">Image de l'icone de la compétence</label>
          <b-form-file
            id="input-icon"
            name="icon"
            v-model="newSkill.icon"
            :state="Boolean(newSkill.icon)"
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
        <div class="mt-3">Fichier sélectionné: {{ newSkill.icon ? newSkill.icon.name : '' }}</div>
        </b-form-group>
      </ValidationProvider>
      <ValidationProvider ref="category" rules="required|min:2" name="Catégorie" v-slot="{ errors }">
        <b-form-group id="category" class="mt-5 text">
          <label for="input-category" class="text-uppercase">Nom de la category</label>
          <b-form-input 
            id="input-category" 
            v-model="newSkill.category" 
            placeholder="Sélectionner une catégorie" 
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
      <div class="d-flex justify-content-center">
        <b-button type="submit" variant="success" class="m-3 p-3" :disabled="loading" @click="$emit('addSkill')">
          <b-spinner v-show="loading" label="Spinning" class="pt-4 p"></b-spinner>
          <span class="pl-2 pb-2">Ajouter compétence</span>
        </b-button>
        <b-button type="reset" variant="danger" class="m-3 p-3" @click="onReset">
          Réinitialiser formulaire
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
// import { setFormWithFile } from "../mixins/formMixin";

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
        knowledgeLevel: 0,
        category: ''
      },
      loading: false,
      successMessage: '',
      errorMessage: '',
    }
  },
  // mixins : [ setFormWithFile ],
  methods: {
    ...mapActions(["addSkill"]),
    onCreate() {
      this.loading = true;
      this.$refs.addForm.validate()
        .then(isValid => {
          if (!isValid) {
            this.loading = false;
            return
          }
          let fd = new FormData();
          fd.append('icon', this.newSkill.icon)
          console.log(fd);
          Object.entries(this.newSkill).forEach(
            ([key, value]) => {
              if (value !== null && value !== '') {
                fd.append(`${key}`, value);
              }
            },
          );          
        this.addSkill(fd)
          .then(() => {
            this.successMessage = "La compétence a été ajoutée !";
            document.getElementById("alert").scrollIntoView();
            this.loading = false;
            this.errorMessage = '';
            this.onReset(event);
          })
          .catch((error) => {
            this.errorMessage = error.data[0];
            document.getElementById("alert").scrollIntoView();
            this.loading = false;
            this.successMessage  = '';
          })
      });
    },
    onReset(event) {
      event.preventDefault()
      console.log("click reset");
      this.loading = false;
      this.newSkill.name = ''
      this.newSkill.description = ''
      this.newSkill.url = ''
      this.newSkill.icon = null
      this.newSkill.altStatic = ''
      this.newSkill.creationDate = ''
    }
  },
  
}
</script>

<style lang="scss" scoped>
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
