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
          <div>
            <div id="alertModify">
              <AlertForm v-if="successMessage" :message="successMessage" variant="success"/>
              <AlertForm v-if="errorMessage" :message="errorMessage" variant="danger"/>
            </div>
              <b-card
                :title="onePresentation.firstName + ' ' + onePresentation.lastName"
                :img-src="onePresentation.picture"
                :sub-title="onePresentation.quote"
                img-top
                class="mt-2 text-dark text-center"
              >
              <b-card-body class="text-left fst-italic">
                <p>Ajouté le : {{formatDate(onePresentation.createdAt)}}</p>
                <p>Mise à jour le : {{formatDate(onePresentation.updatedAt)}}</p>
                <hr>
                <h4 class="text-left my-4">{{onePresentation.titleFirstText}}</h4>
                <p class="text-justify">{{onePresentation.firstText}}</p>
                <hr>
                <h4 class="text-right my-4">{{onePresentation.titleSecondText}}</h4>
                <p class="text-justify">{{onePresentation.secondText}}</p>
                <hr>
                <h4 class="text-left my-4">{{onePresentation.titleThirdText}}</h4>
                <p class="text-justify">{{onePresentation.thirdText}}</p>
                <hr>
                <h4 class="text-center my-4">Contacts</h4>
                <div class="text-justify" v-for="contact in onePresentation.contacts" :key="contact.id">
                  <li><b-link :href="contact.link">{{contact.title}}</b-link></li>
                </div>
              </b-card-body>
                <b-card-text>
                  {{onePresentation.description }}
                </b-card-text>
                <b-button variant="info" @click="toModifyForm(onePresentation.id)" class="m-1 p-2 btn-modify">
                  <font-awesome-icon icon="edit"/> Modifier
                </b-button>
              </b-card>
          </div>
        </b-tab>
        <b-tab class="mt-3 justify-content-center" lazy>
          <template #title>
            <font-awesome-icon icon="edit" size="2x" class="pt-2 pr-2"/>
            <span>Modification de la présentation</span>
          </template>           
          <UpdatePresentationForm v-on:onCancelModify="onCancelModify" v-on:showModifyPresentation="showModifyPresentation"/>
        </b-tab>
      </b-tabs>
    </b-col>
  </b-row>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import AlertForm from "@/components/form/AlertForm";
import UpdatePresentationForm from "@/components/form/UpdatePresentationForm";
import formatDate from "../../services/formatDate";
// import { setFormWithFile } from "../mixins/formMixin";

export default {
  name: "PresentationForm",
  components: { 
    AlertForm,
    UpdatePresentationForm
  },
  data() {
    return {
      showPresentationCard: false,
      successMessage: '',
      errorMessage: '',
      presentationId: '',
      tabIndex: 0
    }
  },
  // mixins : [ setFormWithFile ],
  computed: {
    ...mapGetters(["onePresentation"]),
  },
  methods: {
    ...mapActions(["getPresentation", "deletePresentation"]),
    formatDate(date) {
      return formatDate(date);
    },
    toModifyForm(data){
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
    showModifyPresentation() {
      this.$store.dispatch("getPresentation");
    },
    onCancelModify() {
      this.tabIndex = 0;
    },
  },
  mounted() {
    this.$store.dispatch("getPresentation");
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
  &-modify {
    background-color: $purple; 
    color: $white;
    border: 1px solid $purple;
    &:hover {
      color: $purple;
      background-color: transparent;
      border: 1px solid $purple;
    } 
    &:focus, :active {
      box-shadow: unset;
      border: 1px solid $purple;
      background-color: $purple;
    }
  }
  &-delete {
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
