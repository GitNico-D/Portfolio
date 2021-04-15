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
            <span>La présentation</span>
          </template> 
          <h2 id="modifyForm-title" class="text-center fw-bold my-5">
            Voici la <span class="font-weight-bold font-style-italic">Présentation</span>
          </h2>
          <b-button @click="refreshTab" variant="info" class="m-2"> Refresh</b-button>
          <div id="alertModify">
            <AlertForm v-if="successMessage" :message="successMessage" variant="success"/>
            <AlertForm v-if="errorMessage" :message="errorMessage" variant="danger"/>
          </div>
          <b-card class="mt-2 p-2 text-dark text-center">
          <b-card-title class="display-4">{{onePresentation.firstName}} {{onePresentation.lastName}}</b-card-title>
          <b-card-sub-title>{{onePresentation.quote}}</b-card-sub-title>
          <b-card-body class="text-left fst-italic">
          <b-card-img :src="onePresentation.picture" class="rounded mb-3" top></b-card-img>
            <p class="font-style-italic">Ajouté le : {{formatDate(onePresentation.createdAt)}}</p>
            <p class="font-style-italic">Mise à jour le : {{formatDate(onePresentation.updatedAt)}}</p>
            <hr>
            <h4 class="text-left my-4 font-weight-bold">{{onePresentation.titleFirstText}}</h4>
            <p class="text-justify my-3">{{onePresentation.firstText}}</p>
            <hr>
            <h4 class="text-right my-4 font-weight-bold">{{onePresentation.titleSecondText}}</h4>
            <p class="text-justify my-3">{{onePresentation.secondText}}</p>
            <hr>
            <h4 class="text-left my-4 font-weight-bold">{{onePresentation.titleThirdText}}</h4>
            <p class="text-justify my-3">{{onePresentation.thirdText}}</p>
            <hr>
            <div class="text-center">
              <b-button variant="info" @click="toUpdatePresentationForm(onePresentation.id)" class="mb-5 mt-3 p-2 btn-add">
                <font-awesome-icon icon="edit"/> Modifier la présentation
              </b-button>
            </div>
            <hr><hr>
            <h3 class="text-center my-5 font-weight-bold">Contacts</h3>
            <b-table id="table-list" responsive hover :items="onePresentation.contacts" :fields="fields" class="text-center">
            <template #cell(title)="data">
              {{ data.value }}
            </template>
            <template #cell(actions)="row">
              <b-button type="btn" @click="toUpdateContactForm(row.item.id)" class="m-1 p-2 btn-update rounded">
                <font-awesome-icon icon="edit"/> Modifier
              </b-button>
              <b-button type="btn" @click="onDeleteContact(row.item.id)" class="m-1 p-2 btn-delete rounded">
                <font-awesome-icon icon="trash-alt"/><span class="pl-2">Supprimer</span>
              </b-button>
              </template>
            </b-table>
            <div class="text-center">
              <b-button type="btn" @click="toAddForm" class="m-1 p-2 btn-add rounded text-center">
                  <font-awesome-icon icon="plus"/> Ajouter
              </b-button>
            </div>
            <div id="alertModify" class="mt-1">
              <AlertForm v-if="successMessage" :message="successMessage" variant="success"/>
              <AlertForm v-if="errorMessage" :message="errorMessage" variant="danger"/>
            </div>
          </b-card-body>
            <b-card-text>
              {{onePresentation.description }}
            </b-card-text>            
          </b-card>
        </b-tab>
        <b-tab class="mt-3 justify-content-center" lazy>
          <template #title>
            <font-awesome-icon icon="edit" size="2x" class="pt-2 pr-2"/>
            <span>Modification de la présentation</span>
          </template>           
          <UpdatePresentationForm v-on:onCancel="onCancel" v-on:showModifyPresentation="showModifyPresentation"/>
        </b-tab>
        <b-tab lazy>
          <template #title>
            <font-awesome-icon icon="edit" size="2x" class="pt-2 pr-2"/>
            <span>Ajouter un Contact</span>
          </template> 
          <AddContactForm v-on:addContact="refreshTab" v-on:onCancel="onCancel"/>
        </b-tab>
        <b-tab lazy>
          <template #title>
            <font-awesome-icon icon="folder-plus" size="2x" class="pt-2 pr-2"/>
            <span>Modifier un Contact</span>
          </template> 
          <UpdateContactForm v-on:updateContact="onUpdateContact" v-on:onCancel="onCancel"/>
        </b-tab>
      </b-tabs>
    </b-col>
  </b-row>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import AlertForm from "@/components/form/AlertForm";
import UpdatePresentationForm from "@/components/form/UpdatePresentationForm";
import AddContactForm from "@/components/form/AddContactForm";
import UpdateContactForm from "@/components/form/UpdateContactForm";
import formatDate from "../../services/formatDate";

export default {
  name: "PresentationForm",
  components: { 
    AlertForm,
    UpdatePresentationForm,
    AddContactForm,
    UpdateContactForm
  },
  data() {
    return {
      showPresentationCard: false,
      successMessage: '',
      errorMessage: '',
      addSucces: '',
      presentationId: '',
      tabIndex: 0,
      fields: [
        {
          key: "title",
          label: "Nom du contact",
        },
        {
          key: 'actions', 
          label: 'Actions' 
        }
      ],
      items: [],
    }
  },
  computed: {
    ...mapGetters(["onePresentation", "allContacts", "oneContact"]),
  },
  methods: {
    ...mapActions([
      "getPresentation", 
      "deletePresentation", 
      "getContact", 
      "getAllContacts", 
      "deleteContact", 
      "resetStateContact",
      "resetStatePresentation"
      ]),
    formatDate(date) {
      return formatDate(date);
    },
    refreshTab() {
      this.$store.dispatch("getPresentation");
      this.successMessage = '';
      this.errorMessage = '';
    },
    toUpdatePresentationForm(data){
      this.presentationId = data;
      this.getPresentation(this.presentationId)
        .then(() => { 
          this.tabIndex = 1;
        })
        .catch((error) => {   
          if(error.code == "404") {
            this.errorMessage = 'La présentation ' + this.presentationId  + ' n\'existe pas !';
            this.successMessage = '';
            this.showPresentationCard = false;       
          }  
        })
    },
    toUpdateContactForm(id) {
      console.log(id);
      this.getContact(id)
        .then(() => {
          this.tabIndex = 3;
          this.errorMessage = '';
          document.getElementById("alertModify").scrollIntoView(); 
        })
        .catch((error) => {   
          this.errorMessage = error.message;
          if(error.code == "404") {
            this.errorMessage = 'Le contact ' + id + ' n\'existe pas !';
            this.successMessage = '';      
          }  
        }
      )
    },
    onDeleteContact(id, contactName) {
      console.log("clickDelete " + id);
      this.deleteContact(id) 
        .then(() => {
          this.successMessage = 'Le contact "' +  contactName + '" a été supprimé !';
          this.$store.dispatch("getPresentation");
          this.showAddCardForm = false
          this.showUpdateCardForm = true
          this.errorMessage = '';
          document.getElementById("alertModify").scrollIntoView(); 
        })
        .catch((error) => {   
          this.errorMessage = error.message;
          if(error.code == "404") {
            this.errorMessage = 'Le contact ' + id + ' n\'existe pas !';
            this.successMessage = '';      
          }  
        }
      )
    },
    showModifyPresentation() {
      this.$store.dispatch("getPresentation");
    },
    toAddForm() {
      this.tabIndex = 2
    },
    onUpdateContact() {
      this.$store.dispatch("getPresentation");
    },
    onCancel() {
      this.tabIndex = 0;
      this.$store.dispatch("getPresentation");
      this.resetStateContact();
    },
  },
  mounted() {
    this.resetStateContact()
    this.$store.dispatch("getPresentation");
  },
}
</script>

<style lang="scss" scoped>
.btn {
  &-add {
    background-color: $blue; 
    color: $white;
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
  &-delete {
    background-color: $red; 
    color: $white;
    border: 1px solid $red;
    &:hover {
      color: $red;
      background-color: transparent;
      border: 1px solid $red;
    }
    &:focus, :active {
      box-shadow: unset;
      border: 1px solid $red;
      background-color: $red;
    }
  }
  &-update {
    background-color: $yellow; 
    color: $white;
    border: 1px solid $yellow;
    &:hover {
      color: $yellow;
      background-color: transparent;
      border: 1px solid $yellow;
    }
    &:focus, :active {
      color: $white;
      box-shadow: unset;
      border: 1px solid $yellow;
      background-color: $yellow;
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
