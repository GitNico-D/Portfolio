<template>
  <b-row class="justify-content-center mt-5">
    <b-col cols md="12" lg="8" >
      <b-tabs
        active-nav-item-class="font-weight-bold text-uppercase text-success"
        active-tab-class="text-left text-white"
        align="center"
        class="mt-5"
        fill
        v-model="tabIndex">
        <b-tab class="mt-5 justify-content-center" lazy>
          <template #title>
            <font-awesome-icon icon="folder-plus" size="2x" class="pt-2 pr-2"/>
            Listes des <span class="font-weight-bold font-style-italic">étapes de carrière</span>
          </template> 
          <h2 id="modifyForm-title" class="text-center fw-bold my-5">
            Toutes les <span class="font-weight-bold font-style-italic">Étape de carrière</span>
          </h2>
          <div>
            <b-button @click="refreshTab" variant="info" class="m-2 btn-add"> 
              <font-awesome-icon icon="sync" class="mr-2" spin/>Rafraichir
            </b-button>
            <div id="alertModify">
              <AlertForm v-if="successMessage" :message="successMessage" variant="success"/>
              <AlertForm v-if="errorMessage" :message="errorMessage" variant="danger"/>
            </div>
            <div class="text-right mb-4">
              <Button action="Ajouter Projet" :color="careerColor" icon="plus" v-on:action="toAddCareerForm"/>
            </div>
            <b-table responsive hover no-collpase bordered dark :items="allCareerStages" :fields="fields">
              <template #cell(startDate)="data">
                {{ formatDate(data.value)}}
              </template>
              <template #cell(endDate)="data">
                {{ formatDate(data.value) }}
              </template>
              <template #cell(actions)="row">
                <Button action="Modifier" :color="careerColor" icon="edit" class="m-1" v-on:action="toModifyForm(row.item.id)"/>
                <Button action="Détail de carrière" :color="detailButtonColor" icon="database" class="m-1" v-on:action="row.toggleDetails"/>
              </template>
                <template #row-details="row">
                  <b-card
                    :title="row.item.name"
                    :img-src="row.item.logoCompany"
                    img-top
                    class="mt-2 text-dark text-center"
                  >
                  <b-card-body class="text-left fst-italic">
                    <p>Ajouté le : {{formatDate(row.item.createdAt)}}</p>
                    <p>Mise à jour le : {{formatDate(row.item.updatedAt)}}</p>
                  </b-card-body>
                    <b-card-text>
                      {{oneCareer.description }}
                    </b-card-text>
                    <Button action="Modifier" :color="careerColor" icon="edit" class="m-1" v-on:action="toModifyForm(row.item.id)"/>
                    <Button action="Supprimer" :color="deleteButtonColor" icon="trash-alt" class="m-1" v-on:action="onDelete(row.item.id)"/>
                  </b-card>
                </template>
            </b-table>
          </div>
        </b-tab>
        <b-tab class="mt-5 justify-content-center">
          <template #title>
            <font-awesome-icon icon="folder-plus" size="2x" class="pt-2 pr-2"/>
            <span>Ajouter une nouvelle étape de carrière</span>
          </template> 
          <AddCareerForm v-on:addCareerStage="refreshTab" v-on:onCancelAdd="onCancel" v-on:onReturn="returnToList"/>
        </b-tab>
        <b-tab class="mt-3 justify-content-center" lazy>
          <template #title>
            <font-awesome-icon icon="edit" size="2x" class="pt-2 pr-2"/>
            <span v-if="!careerId">Modifier une étape de carrière</span>
            <span v-else>Modifier l'étape de carrière {{ oneCareer.id }}</span>
          </template>           
          <UpdateCareerForm v-on:onCancelModify="onCancel" v-on:showModifyCareerStage="showModifyCareerStage" v-on:onReturn="returnToList"/>
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
import Button from "@/components/Button";
import formatDate from "../../services/formatDate";

export default {
  name: "CareerForm",
  components: { 
    AlertForm,
    AddCareerForm,
    UpdateCareerForm,
    Button
  },
  data() {
    return {
      careerColor : "#00a1ba",
      detailButtonColor: "#BE8C2E",
      deleteButtonColor: "#ef233c",
      loading: false,
      showCareerCard: false,
      successMessage: '',
      errorMessage: '',
      careerId: '',
      fields: [
        {
          key: 'id',
          label: 'Id',
        },
        { 
          key: "name",
          label: "Intitulé",
        },
        {
          key: "company",
          label: "Société"
        },
        {
          key: "startDate",
          label: "Date de début",
        },
        {
          key: "endDate",
          label: "Date de fin",
        },
        {
          key: 'actions', 
          label: 'Actions' 
        }
      ],
      items: [],
      tabIndex: 0
    }
  },
  computed: {
    ...mapGetters(["oneCareer", "allCareerStages"])
  },
  methods: {
    ...mapActions(["getAllCareerStage", "deleteCareerStage", "getCareerStage", "resetStateCareerStage"]),
    formatDate(date) {
      return formatDate(date);
    },
    refreshTab() {
      this.$store.dispatch("getAllCareerStage");
      // setTimeout(() => {
      //   this.tabIndex = 0;
      // }, 5000);
      // this.errorMessage = '';
      // this.successMessage = '';
    },
    onDelete(id) {
      console.log(id);
      this.deleteCareer(id) 
        .then(() => {
          this.successMessage = 'L\'étape de carrière ' + id  + ' a bien été supprimé !';
          this.showCareerCard = false;
          this.$store.dispatch("getAllCareerStage");
          this.errorMessage = '';
          document.getElementById("alertModify").scrollIntoView(); 
        })
        .catch((error) => {   
          if(error.code == "404") {
            this.errorMessage = 'L\'étape de carrière ' + this.careerId  + ' n\'existe pas !';
            this.successMessage = '';
            this.showCareerCard = false;       
          }  
        }
      )
    },
    toModifyForm(data) {
      this.careerId = data;
      this.getCareerStage(this.careerId)
        .then(() => { 
          this.tabIndex = 2;
        })
        .catch((error) => {   
          if(error.code == "404") {
            this.errorMessage = 'L\'étape de carrière ' + this.careerId  + ' n\'existe pas !';
            this.successMessage = '';
            this.showCareerCard = false;       
          }  
        })
    },
    toAddCareerForm() {
      this.tabIndex = 1
    },
    returnToList() {
      this.tabIndex = 0;
    },
    showModifyCareerStage() {
      this.$store.dispatch("getAllCareerStage");
    },
    onCancel() {
      this.tabIndex = 0;
      this.resetStateCareerStage()
    },
  },
}
</script>

<style lang="scss" scoped>
.btn {
  &-add {
    background-color: $light-blue; 
    color: $white;
    border: 1px solid $light-blue;
    &:hover {
      color: $light-blue;
      background-color: transparent;
      border: 1px solid $light-blue;
    } 
    &:focus, &:active {
      color: $white;
      box-shadow: unset;
      border: 1px solid $light-blue;
      background-color: $light-blue;
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
