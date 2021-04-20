<template>
  <b-row class="justify-content-center mt-5">
    <b-col cols md="10" lg="9" class="padding-col-md">
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
            <span>La présentation</span>
          </template>
          <h2 id="modifyForm-title" class="text-center fw-bold my-5 tab-presentation-title">
            Voici la
            <span class="font-weight-bold font-style-italic">Présentation</span>
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
          <b-card class="mt-2 p-2 text-white text-center mx-auto">
            <b-card-title 
              >{{ onePresentation.firstName }}
              {{ onePresentation.lastName }}</b-card-title
            >
            <b-card-sub-title>{{ onePresentation.quote }}</b-card-sub-title>
            <b-card-body class="text-left fst-italic">
              <div class="d-flex justify-content-center mb-5 card-img">
                <b-img thumbnail :src="onePresentation.picture" width="576" class="rounded"></b-img>
              </div>
              <p class="font-style-italic">
                Ajouté le : {{ formatDate(onePresentation.createdAt) }}
              </p>
              <p class="font-style-italic mb-5">
                Mise à jour le : {{ formatDate(onePresentation.updatedAt) }}
              </p>
              <hr />
              <h4 class="text-left my-4 font-weight-bold">
                {{ onePresentation.titleFirstText }}
              </h4>
              <p class="text-justify my-4">{{ onePresentation.firstText }}</p>
              <hr />
              <h4 class="text-right my-4 font-weight-bold">
                {{ onePresentation.titleSecondText }}
              </h4>
              <p class="text-justify my-3">{{ onePresentation.secondText }}</p>
              <hr />
              <h4 class="text-left my-4 font-weight-bold">
                {{ onePresentation.titleThirdText }}
              </h4>
              <p class="text-justify my-3">{{ onePresentation.thirdText }}</p>
              <hr />
              <div class="text-center my-5">
                <Button
                  action="Modifier la présentation"
                  :color="presentationColor"
                  icon="edit"
                  v-on:action="toUpdatePresentationForm(onePresentation.id)"
                />
              </div>
              <hr />
              <hr />
              <h3 class="text-center my-5 font-weight-bold">Contacts</h3>
              <b-table
                id="table-list"
                responsive
                hover
                no-collpase
                bordered
                dark
                :items="onePresentation.contacts"
                :fields="fields"
                class="text-center"
                stacked="sm"
              >
                <template #cell(title)="data">
                  {{ data.value }}
                </template>
                <template #cell(actions)="row">
                  <Button
                    action="Modifier"
                    :color="presentationColor"
                    icon="edit"
                    v-on:action="toContactForm(row.item.id, 'update')"
                  />
                  <Button
                    action="Supprimer"
                    :color="deleteButtonColor"
                    icon="trash-alt"
                    class="m-1"
                    v-on:action="onDeleteContact(row.item.id, row.item.title)"
                  />
                </template>
              </b-table>
              <div class="text-center">
                <Button
                  action="Ajouter"
                  :color="presentationColor"
                  icon="plus"
                  v-on:action="toContactForm(null, 'create')"
                />
              </div>
            </b-card-body>
            <b-card-text>
              {{ onePresentation.description }}
            </b-card-text>
          </b-card>
        </b-tab>
        <b-tab class="mt-3 justify-content-center" lazy>
          <template #title>
            <font-awesome-icon icon="edit" size="2x" class="pt-2 pr-2" />
            <span>Modification de la présentation</span>
          </template>
          <UpdatePresentationForm
            v-on:onCancel="onCancel"
            v-on:onAction="showPresentation"
            v-on:onReturn="returnToList"
          />
        </b-tab>
        <b-tab lazy>
          <template v-if="!oneContact.id" #title>
            <font-awesome-icon icon="folder-plus" size="2x" class="pt-2 pr-2" />
            <span>Ajouter un Contact</span>
          </template>
          <template v-else #title>
            <font-awesome-icon icon="edit" size="2x" class="pt-2 pr-2" />
            <span>Modifier un Contact {{ oneContact.id }}</span>
          </template>
          <ContactForm
            :methodAction="methodAction"
            v-on:onAction="showContacts"
            v-on:onCancel="onCancel"
            v-on:onReturn="returnToList"
          />
        </b-tab>
      </b-tabs>
    </b-col>
  </b-row>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import AlertForm from "@/components/form/AlertForm";
import UpdatePresentationForm from "@/components/form/UpdatePresentationForm";
import ContactForm from "@/components/form/ContactForm";
import Button from "@/components/Button";
import formatDate from "../../services/formatDate";

export default {
  name: "PresentationList",
  components: {
    AlertForm,
    UpdatePresentationForm,
    ContactForm,
    Button
  },
  data() {
    return {
      presentationColor: "#485DA6",
      detailButtonColor: "#BE8C2E",
      deleteButtonColor: "#ef233c",
      showPresentationCard: false,
      loading: false,
      successMessage: "",
      errorMessage: "",
      addSucces: "",
      presentationId: "",
      tabIndex: 0,
      methodAction: "",
      contactId: "",
      fields: [
        {
          key: "title",
          label: "Nom du contact"
        },
        {
          key: "actions",
          label: "Actions"
        }
      ],
      items: []
    };
  },
  computed: {
    ...mapGetters(["onePresentation", "allContacts", "oneContact"])
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
    //Refresh button to reset page, form data and retrieve the new data added
    refreshTab() {
      this.$store.dispatch("getPresentation");
      this.successMessage = "";
      this.errorMessage = "";
      this.resetStateContact()
      this.contactId = "";
    },
    //Render the update presentation form 
    toUpdatePresentationForm(data) {
      this.presentationId = data;
      this.getPresentation(this.presentationId)
        .then(() => {
          this.tabIndex = 1;
        })
        .catch(error => {
          if (error.code == "404") {
            this.errorMessage =
              "La présentation " + this.presentationId + " n'existe pas !";
            this.successMessage = "";
            this.showPresentationCard = false;
          }
        });
    },
    //Render the contact form according to the method action = 'create' ou 'update'
    //In case of update the id of the contact, in case of create contact id set to null
    toContactForm(contactId, methodAction) {
      this.resetStateContact()
      this.contactId = contactId;
      this.methodAction = methodAction;
      if (methodAction == "create") {
        this.tabIndex = 2;
      } else {
        this.getContact(contactId)
          .then(() => {
            this.tabIndex = 2;
            this.errorMessage = "";
            document.getElementById("alertModify").scrollIntoView();
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
    //Delete the contact defined by the id
    onDeleteContact(id, contactName) {
      this.deleteContact(id)
        .then(() => {
          this.successMessage =
            'Le contact "' + contactName + '" a été supprimé !';
          this.$store.dispatch("getPresentation");
          this.errorMessage = "";
          document.getElementById("alertModify").scrollIntoView();
        })
        .catch(error => {
          if (error.data[0]) {
            this.errorMessage = error.data[0].message;
          } else {
            this.errorMessage = error.data.message;
          }
          this.successMessage = "";
        });
    },
    //On action of the presentation form button, reset or update some data
    showPresentation() {
      this.$store.dispatch("getPresentation");
    },
    //On action of the contact form button, reset or update some data
    showContacts() {
      this.$store.dispatch("getPresentation");
      this.$store.dispatch("getPresentation");
      this.successMessage = "";
      this.errorMessage = "";
      this.contactId = "";
    },
    //On action of the contact form button, return to the tab contact list
    returnToList() {
      this.tabIndex = 0;
    },
    //On action of the contact form button, reset some data
    onCancel() {
      this.tabIndex = 0;
      this.contactId = "";
      this.$store.dispatch("getPresentation");
      this.resetStateContact();
    }
  },
  mounted() {
    this.$store.dispatch("getPresentation");
  }
};
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
    &:focus,
    &:active {
      color: $white !important;
      box-shadow: unset;
      border: 1px solid $blue;
      background-color: $blue;
    }
  }
}
.card {
  background-color: transparent;
  border-color: $blue;
  img {
    @include box_shadow(0px, 0px, 12px, $blue);
  }
}
hr {
  background: $blue;
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
  .card {
    &-body {
      padding: 0.25rem;
    }
  }
  .padding-col-md {
    padding-right: 2.1rem;
    padding-left: 2.1rem;
  }
  .tab-presentation-title {
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
  .card {
    &-body {
      padding: 1.25rem;
    }
  }
  .padding-col-md {
    padding-right: 2.1rem;
    padding-left: 2.1rem;
  }
  .tab-presentation-title {
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
  .card {
    width: 80%;
  }
  .padding-col-md {
    padding-right: inherit;
    padding-left: inherit;
  }
  .tab-presentation-title {
    font-size: 2rem;
  }
}
</style>
