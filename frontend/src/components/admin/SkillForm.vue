<template>
  <b-row class="justify-content-center mt-5">
    <b-col cols md="12" lg="8" >
      <b-tabs
        active-nav-item-class="font-weight-bold text-uppercase text-success"
        active-tab-class="text-left text-white"
        align="center"
        class="mt-5"
        fill>
        <b-tab class="mt-5 justify-content-center">
          <template #title>
            <font-awesome-icon icon="folder-plus" size="2x" class="pt-2 pr-2"/>
            <span>Récupérer une compétence</span>
          </template> 
          <h2 id="modifyForm-title" class="text-center fw-bold my-5">
            Pour récupérer une <span class="font-weight-bold font-style-italic">Compétence</span> 
            existante, entré son ID dans le champ ci-dessous.
          </h2>
          <ValidationObserver ref="recoverForm" v-slot="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(fetchSkill)" >
              <ValidationProvider ref="id" rules="required|numeric" name="ID du projet" v-slot="{ errors }">
                <b-form-group id="id">
                  <label for="input-id" class="text-uppercase">ID de la compétence</label>
                  <b-form-input 
                    id="input-id" 
                    v-model="skillId"
                    placeholder="Entrer ID" 
                    required>
                  </b-form-input>
                  <b-alert
                    variant="danger"
                    v-if="errors[0]"
                    v-text="errors[0]"
                    show
                  >
                  </b-alert>
                </b-form-group>
              </ValidationProvider>
              <div class="d-flex justify-content-center">
                <b-button type="submit" variant="success" class="m-3" :disabled="loading">
                  <b-spinner v-show="loading" label="Spinning" class="pt-4"></b-spinner>
                  <span class="pl-2 pb-2">Récupérer la compétence {{ skillId }}</span>
                </b-button>
              </div>
            </b-form>
            <div id="alertModify">
              <AlertForm v-if="successMessage" :message="successMessage" variant="success"/>
              <AlertForm v-if="errorMessage" :message="errorMessage" variant="danger"/>
            </div>
            <b-card
              :title="oneSkill.name + ' ' + oneSkill.id"
              :img-src="oneSkill.icon"
              img-top
              class="mt-2 text-dark text-center"
              v-show="showSkillCard && oneSkill.id"
            >
            <b-card-body class="text-left fst-italic">
              <p>Ajouté le : {{oneSkill.createdAt}}</p>
              <p>Mise à jour le : {{oneSkill.updatedAt}}</p>
            </b-card-body>
              <b-card-text>
                {{oneSkill.description }}
              </b-card-text>
              <b-button variant="danger" class="m-2" @click="onDelete">Supprimer</b-button>
              <b-button type="reset" variant="info" class="m-2" @click="toFetchSkill">
                  Récupérer une autre compétence
              </b-button>
            </b-card>
          </ValidationObserver>
        </b-tab>
        <b-tab class="mt-5 justify-content-center">
          <template #title>
            <font-awesome-icon icon="folder-plus" size="2x" class="pt-2 pr-2"/>
            <span>Ajouter une nouvelle compétence</span>
          </template> 
          <AddSkillForm />
        </b-tab>
        <b-tab class="mt-3 justify-content-center">
          <template #title>
            <font-awesome-icon icon="edit" size="2x" class="pt-2 pr-2"/>
            <span v-if="!skillId">Modifier une compétence</span>
            <span v-else>Modifier la compétence {{ oneSkill.id }}</span>
          </template>           
          <UpdateSkillForm />
        </b-tab>
      </b-tabs>
    </b-col>
  </b-row>
</template>

<script>
import { ValidationProvider, ValidationObserver } from "vee-validate";
import { mapActions, mapGetters } from "vuex";
import AlertForm from "@/components/form/AlertForm";
import AddSkillForm from "@/components/form/AddSkillForm"
import UpdateSkillForm from "@/components/form/UpdateSkillForm"
// import { setFormWithFile } from "../mixins/formMixin";

export default {
  name: "SkillForm",
  components: { 
    ValidationProvider,
    ValidationObserver,
    AlertForm,
    AddSkillForm,
    UpdateSkillForm
  },
  data() {
    return {
      loading: false,
      showSkillCard: false,
      successMessage: '',
      errorMessage: '',
      skillId: ''
    }
  },
  // mixins : [ setFormWithFile ],
  computed: {
    ...mapGetters(["oneSkill"])
  },
  methods: {
    ...mapActions(["deleteSkill", "getSkill", "resetStateSkill"]),
    fetchSkill() {      
      this.getSkill(this.skillId)
        .then(() => {
          this.successMessage = 'Voici la compétence' + this.skillId + ' !' 
          this.showSkillCard = true;
          console.log(this.showSkillCard);
          document.getElementById("alertModify").scrollIntoView();  
          this.errorMessage = '';
        })
        .catch((error) => {   
          console.log(this.skillId);
          if(error.code == "404") {
            this.errorMessage = 'La compétence ' + this.skillId  + ' n\'existe pas !';
            this.successMessage = '';
            this.loading = false;
            this.showSkillCard = false;       
          }  
        })
    },
    onDelete() {
      console.log(this.skillId);
      this.deleteSkill(this.skillId) 
        .then(() => {
          console.log(this.skillId);
          this.successMessage = 'La compétence ' + this.skillId  + ' a bien été supprimé !';
          this.showSkillCard = false;
          this.resetStateSkill();
          document.getElementById("alertModify").scrollIntoView(); 
        })
        .catch((error) => {   
          if(error.code == "404") {
            this.errorMessage = 'La compétence ' + this.skillId  + ' n\'existe pas !';
            this.successMessage = '';
            this.loading = false;
            this.showSkillCard = false;       
          }  
        }
      )
    },
    toFetchSkill() {
      this.showSkillCard = false;
      document.getElementById("modifyForm-title").scrollIntoView(); 
      this.resetStateSkill();
      this.successMessage = '';
    },
    toModifyForm() {
      console.log(document.getElementById("__BVID__62___BV_tab_button__"));
      document.getElementById("__BVID__62___BV_tab_button__").classList.add('active');
    }
  }
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
