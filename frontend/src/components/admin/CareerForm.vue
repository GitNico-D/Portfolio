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
            <span>Récupérer une étape de carrière</span>
          </template> 
          <h2 id="modifyForm-title" class="text-center fw-bold my-5">
            Pour récupérer une <span class="font-weight-bold font-style-italic">Étape de carrière</span> 
            existante, entré son ID dans le champ ci-dessous.
          </h2>
          <div>
            <b-table striped hover :items="allCareerStages" :fields="fields">
              <template #cell(createdAt)="data">
                {{ formatDate(data.value) }}
              </template>
              <template #cell(updatedAt)="data">
                {{ formatDate(data.value) }}
              </template>
            </b-table>
          </div>
          <div id="alertModify">
            <AlertForm v-if="successMessage" :message="successMessage" variant="success"/>
            <AlertForm v-if="errorMessage" :message="errorMessage" variant="danger"/>
          </div>
          <b-card
            :title="oneCareer.name + ' ' + oneCareer.id"
            :img-src="oneCareer.logoCompany"
            img-top
            class="mt-2 text-dark text-center"
            v-show="showCareerCard && oneCareer.id"
          >
          <b-card-body class="text-left fst-italic">
            <p>Ajouté le : {{oneCareer.createdAt}}</p>
            <p>Mise à jour le : {{oneCareer.updatedAt}}</p>
          </b-card-body>
            <b-card-text>
              {{oneCareer.description }}
            </b-card-text>
            <b-button variant="danger" class="m-2" @click="onDelete">Supprimer</b-button>
            <b-button type="reset" variant="info" class="m-2" @click="toFetchCareer">
                Récupérer une autre étape de carrière
            </b-button>
          </b-card>
        </b-tab>
        <b-tab class="mt-5 justify-content-center">
          <template #title>
            <font-awesome-icon icon="folder-plus" size="2x" class="pt-2 pr-2"/>
            <span>Ajouter une nouvelle étape de carrière</span>
          </template> 
          <AddCareerForm />
        </b-tab>
        <b-tab class="mt-3 justify-content-center">
          <template #title>
            <font-awesome-icon icon="edit" size="2x" class="pt-2 pr-2"/>
            <span v-if="!careerId">Modifier une étape de carrière</span>
            <span v-else>Modifier l'étape de carrière {{ oneCareer.id }}</span>
          </template>           
          <UpdateCareerForm />
        </b-tab>
      </b-tabs>
    </b-col>
  </b-row>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import AlertForm from "@/components/form/AlertForm";
import AddCareerForm from "@/components/form/AddCareerForm"
import UpdateCareerForm from "@/components/form/UpdateCareerForm"
import formatDate from "../../services/formatDate";
// import { setFormWithFile } from "../mixins/formMixin";

export default {
  name: "CareerForm",
  components: { 
    AlertForm,
    AddCareerForm,
    UpdateCareerForm
  },
  data() {
    return {
      loading: false,
      showCareerCard: false,
      successMessage: '',
      errorMessage: '',
      careerId: '',
      fields: [
        {
          key: 'id',
          label: 'Id',
          sortable: true
        },
        { 
          key: "name",
          label: "Nom",
          sortable: true
        },
        {
          key: "company",
          label: "Société"
        },
        {
          key: "createdAt",
          label: "Date d'ajout",
          sortable: true
        },
        {
          key: "updatedAt",
          label: "Date de modification",
          sortable: true
        }
      ],
      items: []
    }
  },
  // mixins : [ setFormWithFile ],
  computed: {
    ...mapGetters(["oneCareer", "allCareerStages"])
  },
  methods: {
    ...mapActions(["deleteCareer", "getCareer", "resetStateCareer"]),
    formatDate(date) {
      return formatDate(date);
    },
    fetchCareer() {      
      this.getCareer(this.careerId)
        .then(() => {
          this.successMessage = 'Voici l\'étape de carrière' + this.careerId + ' !' 
          this.showCareerCard = true;
          console.log(this.showCareerCard);
          document.getElementById("alertModify").scrollIntoView();  
          this.errorMessage = '';
        })
        .catch((error) => {   
          console.log(this.careerId);
          if(error.code == "404") {
            this.errorMessage = 'Le l\'étape de carrière ' + this.careerId  + ' n\'existe pas !';
            this.successMessage = '';
            this.loading = false;
            this.showCareerCard = false;       
          }  
        })
    },
    onDelete() {
      console.log(this.careerId);
      this.deleteCareer(this.careerId) 
        .then(() => {
          console.log(this.careerId);
          this.successMessage = 'l\'étape de carrière ' + this.careerId  + ' a bien été supprimé !';
          this.showCareerCard = false;
          this.resetStateCareer();
          document.getElementById("alertModify").scrollIntoView(); 
        })
        .catch((error) => {   
          if(error.code == "404") {
            this.errorMessage = 'l\'étape de carrière ' + this.careerId  + ' n\'existe pas !';
            this.successMessage = '';
            this.loading = false;
            this.showCareerCard = false;       
          }  
        }
      )
    },
    toFetchCareer() {
      this.showCareerCard = false;
      document.getElementById("modifyForm-title").scrollIntoView(); 
      this.resetStateCareer();
      this.successMessage = '';
    },
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
