<template>
  <b-row class="justify-content-center mt-5" >
    <b-col cols md="10" lg="9" class="padding-col-md" v-if="allCareerStages">
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
            Listes des
            <span class="font-weight-bold font-style-italic"
              >étapes de carrière</span
            >
          </template>
          <h2 id="tab-title" class="text-center fw-bold my-5 tab-career-title">
            Toutes les
            <span class="font-weight-bold font-style-italic"
              >Étape de carrière</span
            >
          </h2>
          <div>
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
            <div class="btn-add-position mb-4">
              <Button
                action="Ajouter Carrière"
                :color="careerColor"
                icon="plus"
                v-on:action="toCareerForm(null, 'create')"
              />
            </div>
            <b-table
              responsive
              hover
              dark
              :items="allCareerStages"
              :fields="fields"
              stacked="sm"
            >
              <template #cell(startDate)="data">
                {{ formatDate(data.value) }}
              </template>
              <template #cell(endDate)="data">
                {{ formatDate(data.value) }}
              </template>
              <template #cell(actions)="row">
                <Button
                  action="Modifier"
                  :color="careerColor"
                  icon="edit"
                  class="m-1"
                  v-on:action="toCareerForm(row.item.id, 'update')"
                />
                <Button
                  action="Détail de carrière"
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
                  <b-img :src="row.item.logoCompany" width="480"></b-img>
                </div>
                  <b-card-body class="text-left fst-italic">
                    <p>Ajouté le : {{ formatDate(row.item.createdAt) }}</p>
                    <p>Mise à jour le : {{ formatDate(row.item.updatedAt) }}</p>
                  </b-card-body>
                  <b-card-text>
                    <p class="my-4">{{ row.item.description }}</p>
                  </b-card-text>
                  <Button
                    action="Modifier"
                    :color="careerColor"
                    icon="edit"
                    class="m-1"
                    v-on:action="toCareerForm(row.item.id, 'update')"
                  />
                  <Button
                    action="Supprimer"
                    :color="deleteButtonColor"
                    icon="trash-alt"
                    class="m-1"
                    v-on:action="onDelete(row.item.id)"
                  />
                </b-card>
              </template>
            </b-table>
          </div>
        </b-tab>
        <b-tab class="mt-5 justify-content-center" lazy>
          <template v-if="!oneCareer.id" #title>
            <font-awesome-icon icon="folder-plus" size="2x" class="pt-2 pr-2" />
            <span>Ajouter une nouvelle étape de carrière</span>
          </template>
          <template v-else #title>
            <font-awesome-icon icon="edit" size="2x" class="pt-2 pr-2" />
            <span>Modifier l'étape de carrière {{ oneCareer.id }}</span>
          </template>
          <CareerForm
            :methodAction="methodAction"
            v-on:onAction="showCareerStage"
            v-on:onCancel="onCancel"
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
          :color="careerColor"
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
import CareerForm from "@/components/form/CareerForm";
import Button from "@/components/Button";
import formatDate from "../../services/formatDate";

export default {
  name: "CareerList",
  components: {
    AlertForm,
    CareerForm,
    Button
  },
  data() {
    return {
      careerColor: "#00a1ba",
      detailButtonColor: "#BE8C2E",
      deleteButtonColor: "#ef233c",
      loading: false,
      showCareerCard: false,
      successMessage: "",
      errorMessage: "",
      careerId: "",
      methodAction: "",
      fields: [
        {
          key: "id",
          label: "Id"
        },
        {
          key: "name",
          label: "Intitulé"
        },
        {
          key: "company",
          label: "Société"
        },
        {
          key: "startDate",
          label: "Date de début"
        },
        {
          key: "endDate",
          label: "Date de fin"
        },
        {
          key: "actions",
          label: "Actions"
        }
      ],
      items: [],
      tabIndex: 0
    };
  },
  computed: {
    ...mapGetters(["oneCareer", "allCareerStages"])
  },
  methods: {
    ...mapActions([
      "getAllCareerStage",
      "deleteCareerStage",
      "getCareerStage",
      "resetStateCareerStage"
    ]),
    formatDate(date) {
      return formatDate(date);
    },
    //Refresh button to reset page, form data and retrieve the new data added
    refreshTab() {
      this.$store.dispatch("getAllCareerStage");
      this.successMessage = "";
      this.errorMessage = "";
      this.resetStateCareerStage()
      this.methodAction = 'create'
      this.careerId = ''
    },
    //Delete the career stage defined by the id
    onDelete(id) {
      this.deleteCareerStage(id)
        .then(() => {
          this.successMessage =
            "L'étape de carrière " + id + " a bien été supprimé !";
          this.showCareerCard = false;
          this.$store.dispatch("getAllCareerStage");
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
    //Render the career stage form according to the method action = 'create' ou 'update'
    //In case of update the id of the career stage, in case of create career stage id set to null
    toCareerForm(data, methodAction) {
      this.resetStateCareerStage()
      this.careerId = data;
      this.methodAction = methodAction;
      if (methodAction == "create") {
        this.tabIndex = 1;
      } else {
        this.getCareerStage(this.careerId)
          .then(() => {
            this.tabIndex = 1;
          })
          .catch(error => {
            if (error.data[0]) {
              this.errorMessage = error.data[0].message;
            } else {
              this.errorMessage = error.data.message;
            }
            this.successMessage = "";
          });
      }
    },
    returnToList() {
      this.tabIndex = 0;
    },
    //On action of the career form button, reset or update some data
    showCareerStage() {
      this.$store.dispatch("getAllCareerStage");
      this.successMessage = "";
      this.errorMessage = "";
      this.methodAction = ''
      this.careerId = ''
    },
    //On action of the career form button, reset some data
    onCancel() {
      this.tabIndex = 0;
      this.careerId = ''
      this.resetStateCareerStage();
    }
  },
  mounted() {
    this.methodAction = 'create';
  }
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
    &:focus,
    &:active {
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
.jumbotron {
  background-color: transparent;
}
.row {
  height: unset;
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
  .tab-career-title {
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
  .padding-col-md {
    padding-right: 2.1rem;
    padding-left: 2.1rem;
  }
  .tab-career-title {
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
  .tab-career-title {
    font-size: 2rem;
  }
}

</style>
