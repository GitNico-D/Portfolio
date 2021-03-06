<template>
  <b-row class="justify-content-center mt-5">
    <b-col cols md="10" lg="9" class="padding-col-md" v-if="allSkills">
      <b-tabs
        active-nav-item-class="font-weight-bold text-uppercase text-success"
        active-tab-class="text-left text-white"
        align="center"
        class="mt-5"
        fill
        v-model="tabIndex"
        small
      >
        <b-tab class="mt-5 justify-content-center" lazy>
          <template #title>
            <font-awesome-icon icon="folder-plus" size="2x" class="pt-2 pr-2" />
            <span>Listes des compétences</span>
          </template>
          <h2 id="modifyForm-title" class="text-center fw-bold my-5 tab-skill-title">
            Toutes les
            <span class="font-weight-bold font-style-italic">compétences</span>
          </h2>
          <div class="btn-refresh-position">
            <b-button @click="refreshTab" variant="info" class="m-2 btn-add">
              <font-awesome-icon icon="sync" class="mr-2" spin />Rafraichir
            </b-button>
          </div>
          <div id="alertModify">
            <AlertForm
              v-if="successMessage"
              :message="successMessage"
              variant="success"
            />
            <AlertForm
              v-if="errorMessage"
              :message="errorMessage"
              variant="danger"
            />
          </div>
          <div v-for="category in allCategories" :key="category.id">
            <div class="d-flex flex-wrap justify-content-around my-5">
              <h3>
                Catégorie
                <span class="font-weight-bold">{{ category.name }}</span>
              </h3>
              <Button
                :action="'Compétence ' + category.name"
                :color="skillColor"
                icon="plus"
                class="mb-1"
                v-on:action="toSkillForm(null, category.id, 'create')"
              />
              <Button
                :action="'Logiciel ' + category.name"
                :color="skillColor"
                icon="plus"
                class="mb-1"
                v-on:action="toSoftwareForm(null, category.id, 'create')"
              />
            </div>
            <h4 class="m-3">Compétences</h4>
            <b-table
              id="table-list"
              responsive
              hover
              no-collpase
              bordered
              dark
              :items="category.skills"
              :fields="fields"
              stacked="sm"
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
                <Button
                  action="Modifier"
                  :color="skillColor"
                  icon="plus"
                  v-on:action="toSkillForm(row.item.id, category.id, 'update')"
                />
                <Button
                  action="Détail de la compétence"
                  :color="detailButtonColor"
                  icon="database"
                  class="m-1"
                  v-on:action="row.toggleDetails"
                />
              </template>
              <template #row-details="row">
                <b-card
                  :title="row.item.name"
                  class="mt-2 text-dark text-center"
                >
                <div class="d-flex justify-content-center my-4">
                  <b-img :src="row.item.icon" width="128"></b-img>
                </div>
                  <b-card-body class="text-left fst-italic">
                    <p>Ajouté le : {{ formatDate(row.item.createdAt) }}</p>
                    <p>Mise à jour le : {{ formatDate(row.item.updatedAt) }}</p>
                  </b-card-body>
                  <b-card-text>
                    <p class="my-4">Niveau de compétence</p>
                    <b-progress
                      :value="row.item.level"
                      :max="maxValue"
                      show-progress
                      animated
                    ></b-progress>
                    <p class="my-4">{{ row.item.description }}</p>
                  </b-card-text>
                  <Button
                    action="Modifier"
                    :color="skillColor"
                    icon="plus"
                    v-on:action="
                      toSkillForm(row.item.id, category.id, 'update')
                    "
                  />
                  <Button
                    action="Supprimer"
                    :color="deleteButtonColor"
                    icon="trash-alt"
                    class="m-1"
                    v-on:action="onDeleteSkill(row.item.id)"
                  />
                </b-card>
              </template>
            </b-table>
            <h4 class="m-3">Logiciels</h4>
            <b-table
              id="table-list"
              responsive
              hover
              no-collpase
              bordered
              dark
              :items="category.softwares"
              :fields="fields"
              stacked="sm"
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
                <Button
                  action="Modifier"
                  :color="skillColor"
                  icon="plus"
                  v-on:action="
                    toSoftwareForm(row.item.id, category.id, 'update')
                  "
                />
                <Button
                  action="Détail du logiciel"
                  :color="detailButtonColor"
                  icon="database"
                  class="m-1"
                  v-on:action="row.toggleDetails"
                />
              </template>
              <template #row-details="row">
                <b-card
                  :title="row.item.name"
                  class="mt-2 text-dark text-center"
                >
                <div class="d-flex justify-content-center my-4">
                  <b-img :src="row.item.icon" width="128"></b-img>
                </div>
                  <b-card-body class="text-left fst-italic">
                    <p>Ajouté le : {{ formatDate(row.item.createdAt) }}</p>
                    <p>Mise à jour le : {{ formatDate(row.item.updatedAt) }}</p>
                  </b-card-body>
                  <b-card-text>
                    <p class="my-4">Maitrise du logiciel</p>
                    {{ row.item.level }}
                    <b-progress
                      :value="row.item.level"
                      :max="maxValue"
                      show-progress
                      animated
                    ></b-progress>
                    <p class="my-4">{{ row.item.description }}</p>
                  </b-card-text>
                  <Button
                    action="Modifier"
                    :color="skillColor"
                    icon="plus"
                    v-on:action="
                      toSoftwareForm(row.item.id, category.id, 'update')
                    "
                  />
                  <Button
                    action="Supprimer"
                    :color="deleteButtonColor"
                    icon="trash-alt"
                    class="m-1"
                    v-on:action="onDeleteSoftware(row.item.id)"
                  />
                </b-card>
              </template>
            </b-table>
            <hr class="mt-5">
            <!-- </span> -->
          </div>
          <!-- </div> -->
        </b-tab>
        <b-tab class="mt-5 justify-content-center" lazy>
          <template v-if="!oneSkill.id" #title>
            <font-awesome-icon icon="folder-plus" size="2x" class="pt-2 pr-2" />
            <span>Ajouter une nouvelle compétence</span>
          </template>
          <template v-else #title>
            <font-awesome-icon icon="edit" size="2x" class="pt-2 pr-2" />
            <span>Modification de la compétence {{ oneSkill.id }}</span>
          </template>
          <SkillForm
            :methodAction="methodAction"
            v-on:onCancel="onCancel"
            v-on:onAction="showSkills"
            v-on:onReturn="returnToList"
          />
        </b-tab>
        <b-tab class="mt-5 justify-content-center" lazy>
          <template v-if="!oneSoftware.id" #title>
            <font-awesome-icon icon="folder-plus" size="2x" class="pt-2 pr-2" />
            <span>Ajouter un nouveau logiciel</span>
          </template>
          <template v-else #title>
            <font-awesome-icon icon="edit" size="2x" class="pt-2 pr-2" />
            <span>Modification du logiciel {{ oneSoftware.id }}</span>
          </template>
          <SoftwareForm
            :methodAction="methodAction"
            v-on:onCancel="onCancel"
            v-on:onAction="showSoftwares"
            v-on:onReturn="returnToList"
          />
        </b-tab>
      </b-tabs>
    </b-col>
    <b-col v-else>
      <b-jumbotron 
        header="Une erreur est survenue" 
        lead="Aucune données n'a pu être récupéré du serveur"
        class="m-5"
      >
        <p>Veuillez ressayer ultérieurement ou contactez un administrateur</p>
        <Button
          :color="skillColor"
          action="Retour tableau de bord"
          icon="arrow-left"
          class="m-3 p-3"
          v-on:action="$emit('returnOverview')"
        />
      </b-jumbotron>
    </b-col>
  </b-row>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import AlertForm from "@/components/form/AlertForm";
import Button from "@/components/Button";
import SkillForm from "@/components/form/SkillForm";
import SoftwareForm from "@/components/form/SoftwareForm";
import formatDate from "../../services/formatDate";

export default {
  name: "SkillList",
  components: {
    AlertForm,
    SkillForm,
    SoftwareForm,
    Button
  },
  data() {
    return {
      skillColor: "#36C486",
      detailButtonColor: "#BE8C2E",
      deleteButtonColor: "#ef233c",
      loading: false,
      successMessage: "",
      errorMessage: "",
      skillId: "",
      softwareId: "",
      methodAction: "",
      fields: [
        {
          key: "id",
          label: "Id",
          sortable: true
        },
        {
          key: "name",
          label: "Nom"
        },
        {
          key: "level",
          label: "Niveau de connaissance"
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
          key: "actions",
          label: "Actions"
        }
      ],
      items: [],
      tabIndex: 0,
      maxValue: 100
    };
  },
  computed: {
    ...mapGetters([
      "oneCategory",
      "allCategories",
      "oneSkill",
      "allSkills",
      "allSoftwares",
      "oneSoftware"
    ])
  },
  methods: {
    ...mapActions([
      "getCategory",
      "getAllCategories",
      "deleteCategories",
      "resetStateCategory",
      "getSkill",
      "getAllSkills",
      "deleteSkill",
      "resetStateSkill",
      "getSoftware",
      "getAllSoftwares",
      "deleteSoftware",
      "resetStateSoftware"
    ]),
    formatDate(date) {
      return formatDate(date);
    },
    //Refresh button to reset page, form data and retrieve the new data added
    refreshTab() {
      this.$store.dispatch("getAllCategories");
      this.getAllSkills();
      this.getAllSoftwares();
      this.successMessage = "";
      this.errorMessage = "";
      this.resetStateSkill()
      this.resetStateSoftware()
      this.methodAction = 'create'
      this.careerId = ''
    },
    //Delete the skill defined by the id
    onDeleteSkill(id) {
      this.deleteSkill(id)
        .then(() => {
          this.successMessage =
            "La compétence " + id + " a bien été supprimé !";
          this.$store.dispatch("getAllCategories");
          this.errorMessage = "";
          document.getElementById("alertModify").scrollIntoView();
        })
        .catch(error => {
          if (error.data) {
            this.errorMessage = error.data[0].message;
          } else {
            this.errorMessage = error;
          }
          this.successMessage = "";
        });
    },
    //Delete the software defined by the id
    onDeleteSoftware(id) {
      this.deleteSoftware(id)
        .then(() => {
          this.successMessage = "Le logiciel " + id + " a bien été supprimé !";
          this.showSoftwareCard = false;
          this.$store.dispatch("getAllCategories");
          this.errorMessage = "";
          document.getElementById("alertModify").scrollIntoView();
        })
        .catch(error => {
          if (error.data[0]) {
            this.errorMessage = error.data[0].message;
          } else {
            this.errorMessage = error;
          }
          this.successMessage = "";
        });
    },
    //Render the software form according to the method action = 'create' ou 'update'
    //Send the associate category and in case of update the 
    //id of the skill, in case of create skill id set to null
    toSkillForm(skillId, categoryId, methodAction) {
      this.resetStateSkill()
      this.skillId = skillId;
      this.methodAction = methodAction;
      if (methodAction == "create") {
        this.getCategory(categoryId)
          .then(() => {
            this.tabIndex = 1;
            this.successMessage = "";
          })
          .catch(error => {
            if (error.code == "404") {
              this.errorMessage =
                "La categorie " + categoryId + " n'existe pas !";
              this.successMessage = "";
            }
          });
      } else {
        this.getSkill(skillId)
          .then(() => {
            this.getCategory(categoryId).then(() => {
              this.tabIndex = 1;
              this.successMessage = "";
            });
          })
          .catch(error => {
            if (error.code == "404") {
              this.errorMessage =
                "La compétence " + this.skillId + " n'existe pas !";
              this.successMessage = "";
            }
          });
      }
    },
    //Render the software form according to the method action = 'create' ou 'update'
    //Send the associate category and in case of update the 
    //id of the software, in case of create software id set to null
    toSoftwareForm(softwareId, categoryId, methodAction) {
      this.resetStateSoftware()
      this.softwareId = softwareId;
      this.methodAction = methodAction;
      if (methodAction == "create") {
        this.getCategory(categoryId)
          .then(() => {
            this.tabIndex = 2;
            this.successMessage = "";
          })
          .catch(error => {
            if (error.code == "404") {
              this.errorMessage =
                "La categorie " + categoryId + " n'existe pas !";
              this.successMessage = "";
            }
          });
      } else {
        this.getSoftware(softwareId)
          .then(() => {
            this.getCategory(categoryId).then(() => {
              this.tabIndex = 2;
              this.successMessage = "";
            });
          })
          .catch(error => {
            if (error.code == "404") {
              this.errorMessage =
                "La compétence " + this.softwareId + " n'existe pas !";
              this.successMessage = "";
            }
          });
      }
    },
    //On action of the skill form button, reset or update some data
    showSkills() {
      this.$store.dispatch("getAllCategories");
      this.successMessage = "";
      this.errorMessage = "";
      this.methodAction = ''
      this.careerId = ''
    },
    //On action of the skill form button, reset or update some data
    showSoftwares() {
      this.$store.dispatch("getAllCategories");
      this.successMessage = "";
      this.errorMessage = "";
      this.methodAction = ''
      this.careerId = ''
    },
    //On action of the skill form button, reset some data
    onCancel() {
      this.tabIndex = 0;
      this.skillId = "";
      this.softwareId = "";
      this.resetStateSkill();
      this.resetStateCategory();
      this.resetStateSoftware();
    },
    returnToList() {
      this.tabIndex = 0;
    }
  },
  mounted() {
    this.methodAction = 'create';
  }
};
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
          color: $purple !important;
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
    &:focus,
    &:active {
      color: $white !important;
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
.row {
  height: unset;
}
hr {
  background-color: $green;
}
.jumbotron {
  background-color: transparent;
}
.nav-link {
  color: $white !important;
}
.tabs {
  font-family: "Oswald", sans-serif;
  letter-spacing: 1px;
}
@media (min-width: 320px) {
  .btn {
    &-refresh {
      &-position {
        text-align: center;
      }
    }
    &-add {
      &-position {
        text-align: center;
      }
    }
  }
  .padding-col-md {
    padding-right: 2.1rem;
    padding-left: 2.1rem;
  }
  .tab-skill-title, h3 {
    font-size: 1.2rem;
  }
}
@media (min-width: 576px) {
  .btn {
    &-refresh {
      &-position {
        text-align: left;
      }
    }
    &-add {
      &-position {
        text-align: right;
      }
    }
  }
  .padding-col-md, h3 {
    padding-right: 2.1rem;
    padding-left: 2.1rem;
  }
  .tab-skill-title, h3 {
    font-size: 1.5rem;
  }
}
@media (min-width: 768px) {
  .btn {
    &-refresh {
      &-position {
        text-align: left;
      }
    }
    &-add {
      &-position {
        text-align: right;
      }
    }
  }
  
  .padding-col-md {
    padding-right: inherit;
    padding-left: inherit;
  }
  .tab-skill-title, h3 {
    font-size: 2rem;
  }
}
</style>
