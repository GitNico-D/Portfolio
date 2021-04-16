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
            <span>Listes de tous les compétences</span>
          </template> 
          <h2 id="modifyForm-title" class="text-center fw-bold my-5">
            Toutes les <span class="font-weight-bold font-style-italic">compétences</span>
          </h2>
          <div>
            <b-button @click="refreshTab" variant="info" class="m-2"> Refresh</b-button>
            <div id="alertModify">
              <AlertForm v-if="successMessage" :message="successMessage" variant="success"/>
              <AlertForm v-if="errorMessage" :message="errorMessage" variant="danger"/>
            </div>
            <div v-for="category in allCategories" :key="category.id">
              <div class="d-flex justify-content-around my-4">
                <h3 > Compétences de catégorie : <span class="font-weight-bold">{{category.name}}</span></h3>
                <b-button type="btn" @click="toAddForm(category.id)" class=" btn-add rounded text-center">
                    <font-awesome-icon icon="plus"/> Ajouter compétence {{category.name}}
                </b-button>
            </div>
              <!-- <span v-for="skill in allSkills" :key="skill.id"> -->
              <b-table id="table-list" responsive hover no-collpase bordered dark 
                :items="category.skills" 
                :fields="fields"
                >
                <b-thead class="p-5"></b-thead>
                <template #cell(level)="data">
                  {{ data.value }}
                </template>
                <template #cell(createdAt)="data">
                  {{ formatDate(data.value) }}
                </template>
                <template #cell(updatedAt)="data">
                  {{ formatDate(data.value) }}
                </template>
              <template #cell(actions)="row">
                <b-button variant="info" @click="toModifyForm(row.item.id, category.id)" class="m-1 p-2 btn-modify">
                  <font-awesome-icon icon="edit"/> Modifier
                </b-button>
                <b-button variant="info" @click="row.toggleDetails" class="m-1 p-2 btn-details">
                  <font-awesome-icon icon="database" /><span class="pl-2">Détail de la compétence</span>
                </b-button>
              </template>
                <template #row-details="row">
                  <b-card
                    :title="row.item.name"
                    :img-src="row.item.icon"
                    img-top
                    class="mt-2 text-dark text-center"
                  >
                  <b-card-body class="text-left fst-italic">
                    <p>Ajouté le : {{row.item.createdAt}}</p>
                    <p>Mise à jour le : {{formatDate(row.item.updatedAt)}}</p>
                  </b-card-body>
                    <b-card-text>
                      <p class="my-4">Niveau  de compétence</p> 
                      {{row.item.level}}
                      <b-progress :value="row.item.level" :max="maxValue" show-progress animated></b-progress>
                      <p class="my-4">{{row.item.description }}</p>
                    </b-card-text>
                    <b-button variant="info" @click="toModifyForm(row.item.id, category.id)" class="m-1 p-2 btn-modify">
                      <font-awesome-icon icon="edit"/> Modifier
                    </b-button>
                    <b-button variant="danger" class="m-1 p-2 btn-delete" @click="onDelete(row.item.id)">
                      <font-awesome-icon icon="trash-alt"/> Supprimer
                    </b-button>
                  </b-card>
                </template>
              </b-table>
              <!-- </span> -->
            </div>
          </div>
        </b-tab>
        <b-tab class="mt-5 justify-content-center" lazy>
          <template #title>
            <font-awesome-icon icon="folder-plus" size="2x" class="pt-2 pr-2"/>
            <span>Ajouter une nouvelle compétence</span>
          </template> 
          <AddSkillForm v-on:addSkill="refreshTab" v-on:onCancel="onCancel" :category="categoryId"/>
        </b-tab>
        <b-tab class="mt-3 justify-content-center" lazy>
          <template #title>
            <font-awesome-icon icon="edit" size="2x" class="pt-2 pr-2"/>
            <span v-if="!skillId">Modifier la compétence</span>
            <span v-else>Modification de la compétence {{ oneSkill.id }}</span>
          </template>           
          <UpdateSkillForm v-on:onCancel="onCancel" v-on:showModifySkill="showModifySkill"/>
        </b-tab>
      </b-tabs>
    </b-col>
  </b-row>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import AlertForm from "@/components/form/AlertForm";
import AddSkillForm from "@/components/form/AddSkillForm"
import UpdateSkillForm from "@/components/form/UpdateSkillForm"
import formatDate from "../../services/formatDate";

export default {
  name: "SkillForm",
  components: { 
    AlertForm,
    AddSkillForm,
    UpdateSkillForm
  },
  data() {
    return {
      showSkillCard: false,
      successMessage: '',
      errorMessage: '',
      skillId: '',
      fields: [
        {
          key: 'id',
          label: 'Id',
          sortable: true
        },
        { 
          key: "name",
          label: "Nom",
        },
        {
          key: "level",
          label: "Niveau de connaissance",
        },
        {
          key: "createdAt",
          label: "Créé le",
          sortable: true
        },
        {
          key: "updatedAt",
          label: "Modifiée le",
          sortable: true
        },
        {
          key: 'actions', 
          label: 'Actions' 
        }
      ],
      items: [],
      tabIndex: 0,
      maxValue: 100,
      categoryId: 0
    }
  },
  computed: {
    ...mapGetters(["oneCategory", "allCategories", "oneSkill", "allSkills"]),
  },
  methods: {
    ...mapActions([
      "getCategory", 
      "getAllCategories", 
      "deleteCategories", 
      "resetStateCategory",
      "deleteSkill", 
      "getSkill",
      "getAllSkills", 
      "resetStateSkill"]),
    formatDate(date) {
      return formatDate(date);
    },
    refreshTab() {
      this.$store.dispatch("getAllSkills");
      this.$store.dispatch("getAllCategories");
      setTimeout(() => {
        this.tabIndex = 0;
      }, 5000);
      this.errorMessage = '';
      this.successMessage = '';
    },
    onDelete(id) {
      console.log(id);
      this.deleteSkill(id) 
        .then(() => {
          this.successMessage = 'La compétence ' + id + ' a bien été supprimé !';
          this.showSkillCard = false;
          this.$store.dispatch("getAllSkills");
          this.errorMessage = '';
          document.getElementById("alertModify").scrollIntoView(); 
        })
        .catch((error) => {   
          if(error.code == "404") {
            this.errorMessage = 'La compétence ' + id + ' n\'existe pas !';
            this.successMessage = '';
            this.showSkillCard = false;       
          }  
        }
      )
    },
    toModifyForm(skillId, categoryId) {
      this.getSkill(skillId)
        .then(() => { 
          this.getCategory(categoryId)
          .then(() => { 
            this.tabIndex = 2;
          })
        })
        .catch((error) => {   
          if(error.code == "404") {
            this.errorMessage = 'La compétence ' + this.skillId  + ' n\'existe pas !';
            this.successMessage = '';
            this.showSkillCard = false;       
          }  
        })
      this.getCategory(categoryId)
        .then(() => { 
          this.tabIndex = 2;
        })
        .catch((error) => {   
          if(error.code == "404") {
            this.errorMessage = 'La categorie ' + this.categoryId  + ' n\'existe pas !';
            this.successMessage = '';
            this.showSkillCard = false;       
          }  
        })
    },
    showModifySkill() {
      this.$store.dispatch("getSkills");
    },
    toAddForm(categoryId) {
      this.tabIndex = 1
      this.categoryId = categoryId;
    },
    onCancel() {
      this.tabIndex = 0;
      this.resetStateSkill()
      this.resetStateCategory()
    },
  },
  mounted() {
    this.$store.dispatch("getAllCategories");
    this.$store.dispatch("getAllSkills");
  },
}
</script>

<style lang="scss" scoped>
table {
  color: $white;
  tr {
    padding: 1rem;
  }
  .table-hover {
    tbody {
      tr {
        &:hover {
          color: $purple!important;
        }
      }
    }
  }
}
.btn {
  &-add {
    background-color: $green; 
    color: $white;
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
  &-modify {
    background-color: $green; 
    color: $white;
    border: 1px solid $green;
    &:hover {
      color: $green;
      background-color: transparent;
      border: 1px solid $green;
    } 
    &:focus, :active {
      color: $white!important;
      box-shadow: unset;
      border: 1px solid $green;
      background-color: $green;
    }
  }
  &-delete {
    &:hover {
      color: $red;
      background-color: transparent;
      border: 1px solid $red;
    }
    &:focus, :active {
      color: $white!important;
      box-shadow: unset;
      border: 1px solid $red;
      background-color: $red;
    }
  }
  &-detail {
    &:hover {
      color: $light-blue;
      background-color: transparent;
      border: 1px solid $light-blue;
    }
    &:focus, :active {
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
