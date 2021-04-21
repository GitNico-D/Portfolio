<template>
  <div>
    <div id="alert">
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
    <div class="text-center">
      <Button
        :color="presentationColor"
        action="Retour liste"
        icon="arrow-left"
        class="m-3 p-3"
        v-on:action="$emit('onReturn'), onReturn()"
      />
    </div>
    <h2
      v-if="!onePresentation.id"
      id="modifyForm-title"
      ref="titleForm"
      class="text-center fw-bold mt-5"
    >
      <p>
        Aucun
        <span class="font-weight-bold font-style-italic">Présentation</span>
        sélectionné.
      </p>
      <p>
        Rendez-vous sur l'onglet
        <span class="font-style-italic">"Liste des présentations"</span>
        pour sélectionné le présentation que vous souhaitez modifier.
      </p>
    </h2>
    <h2 v-else id="modifyForm-title" class="text-center fw-bold my-5 presentation-form-title">
      Modification de la présentation
    </h2>
    <p class="mt-4 text-left" v-show="onePresentation.id">
      ID du <span class="text-uppercase font-weight-bold">présentation : </span>
      {{ onePresentation.id }}
    </p>
    <ValidationObserver
      ref="modifyForm"
      v-slot="{ handleSubmit }"
      v-show="onePresentation.id || showForm"
    >
      <b-form @submit.prevent="handleSubmit(onModify)">
        <ValidationProvider
          ref="first-name"
          rules="required|min:2"
          firstName="Prénom"
          v-slot="{ errors }"
        >
          <b-form-group id="first-name" class="mb-5">
            <label for="input-first-name" class="text-uppercase"
              >Nouveau prénom</label
            >
            <b-form-input
              id="input-firs-name"
              v-model="modifyPresentation.firstName"
              ref="inputfirst-name"
            >
            </b-form-input>
            <b-alert
              id="alert-firstName"
              class="mt-1"
              variant="danger"
              v-if="errors[0]"
              v-text="errors[0]"
              show
            >
            </b-alert>
          </b-form-group>
        </ValidationProvider>
        <ValidationProvider
          ref="lastName"
          rules="required|min:2"
          name="Nom"
          v-slot="{ errors }"
        >
          <b-form-group id="lastName" class="mb-5">
            <label for="input-lastName" class="text-uppercase"
              >Nouvelle nom</label
            >
            <b-form-input
              id="input-lastName"
              v-model="modifyPresentation.lastName"
              size="lg"
            >
            </b-form-input>
            <b-alert
              class="mt-1"
              variant="danger"
              v-if="errors[0]"
              v-text="errors[0]"
              show
            >
            </b-alert>
          </b-form-group>
        </ValidationProvider>
        <ValidationProvider
          ref="quote"
          rules="required"
          name="Citation"
          v-slot="{ errors }"
        >
          <b-form-group id="quote" class="mb-5">
            <label for="input-quote" class="text-uppercase"
              >Nouvelle citation</label
            >
            <b-form-input id="input-quote" v-model="modifyPresentation.quote">
            </b-form-input>
            <b-alert
              class="mt-1"
              variant="danger"
              v-if="errors[0]"
              v-text="errors[0]"
              show
            >
            </b-alert>
          </b-form-group>
        </ValidationProvider>
        <div v-show="oldPicture">
          <h5 v-show="oldPicture" class="text-left text-uppercase">
            Image du présentation
          </h5>
          <b-img
            :src="oldPicture"
            fluid
            alt="Fluid image"
            class="mt-1"
            v-show="!modifyPresentation.picture && oldPicture"
          ></b-img>
        </div>
        <ValidationProvider
          ref="new-picture"
          v-if="modifyPresentation"
          name="Image"
          v-slot="{ errors }"
        >
          <b-form-group id="new-picture" class="mt-3 mb-5">
            <label for="input-picture" class="text-uppercase"
              >Nouvelle image de présentation du présentation</label
            >
            <b-form-file
              id="input-new-picture"
              ref="file"
              name="new-picture"
              v-model="modifyPresentation.picture"
              browse-text="Parcourir"
              accept="image/*"
              placeholder="Choisir un fichier ou glisser-déposer ici"
              drop-placeholder="Choisir un fichier"
              @change="showPreview($event)"
            ></b-form-file>
            <b-alert
              class="mt-1"
              variant="danger"
              v-if="errors[0]"
              v-text="errors[0]"
              show
            >
            </b-alert>
            <div class="mt-3">
              Fichier sélectionné:
              {{
                modifyPresentation.picture
                  ? modifyPresentation.picture.name
                  : ""
              }}
            </div>
            <b-img
              thumbnail  
              fluid            
              id="previewPicture"
              width="576"
              v-show="previewPictureUrl && modifyPresentation.picture"
              :src="previewPictureUrl"
            ></b-img>
          </b-form-group>
        </ValidationProvider>
        <hr />
        <ValidationProvider
          ref="title-first-text"
          rules="required|min:2"
          name="Titre du premier paragraphe"
          v-slot="{ errors }"
        >
          <b-form-group id="title-first-text" class="mb-5">
            <label for="input-title-first-text" class="text-uppercase"
              >Nouvelle titre du premier paragraphe</label
            >
            <b-form-input
              id="input-title-first-text"
              v-model="modifyPresentation.titleFirstText"
            >
            </b-form-input>
            <b-alert
              class="mt-1"
              variant="danger"
              v-if="errors[0]"
              v-text="errors[0]"
              show
              dismissible
            >
            </b-alert>
          </b-form-group>
        </ValidationProvider>
        <ValidationProvider
          ref="first-text"
          rules="required|min:2"
          name="Nom"
          v-slot="{ errors }"
        >
          <b-form-group id="first-text" class="mb-5">
            <label for="input-first-text" class="text-uppercase"
              >Nouveau texte du premier paragraphe</label
            >
            <b-form-textarea
              id="input-first-text"
              v-model="modifyPresentation.firstText"
              size="lg"
            >
            </b-form-textarea>
            <b-alert
              class="mt-1"
              variant="danger"
              v-if="errors[0]"
              v-text="errors[0]"
              show
            >
            </b-alert>
          </b-form-group>
        </ValidationProvider>
        <ValidationProvider
          ref="title-second-text"
          rules="required|min:2"
          name="Titre du second paragraphe"
          v-slot="{ errors }"
        >
          <b-form-group id="title-second-text" class="mb-5">
            <label for="input-title-second-text" class="text-uppercase"
              >Nouveau titre du second paragraphe</label
            >
            <b-form-input
              id="input-title-second-text"
              v-model="modifyPresentation.titleSecondText"
            >
            </b-form-input>
            <b-alert
              class="mt-1"
              variant="danger"
              v-if="errors[0]"
              v-text="errors[0]"
              show
              dismissible
            >
            </b-alert>
          </b-form-group>
        </ValidationProvider>
        <ValidationProvider
          ref="second-text"
          rules="required|min:2"
          name="Second texte"
          v-slot="{ errors }"
        >
          <b-form-group id="second-text" class="mb-5">
            <label for="input-second-text" class="text-uppercase"
              >Nouveau texte du second paragraphe</label
            >
            <b-form-textarea
              id="input-second-text"
              v-model="modifyPresentation.secondText"
              size="lg"
            >
            </b-form-textarea>
            <b-alert
              class="mt-1"
              variant="danger"
              v-if="errors[0]"
              v-text="errors[0]"
              show
            >
            </b-alert>
          </b-form-group>
        </ValidationProvider>
        <ValidationProvider
          ref="title-third-text"
          rules="required|min:2"
          name="Titre du troisième paragraphe"
          v-slot="{ errors }"
        >
          <b-form-group id="title-third-text" class="mb-5">
            <label for="input-title-third-text" class="text-uppercase"
              >Nouveau titre du troisième paragraphe</label
            >
            <b-form-input
              id="input-title-third-text"
              v-model="modifyPresentation.titleThirdText"
            >
            </b-form-input>
            <b-alert
              class="mt-1"
              variant="danger"
              v-if="errors[0]"
              v-text="errors[0]"
              show
              dismissible
            >
            </b-alert>
          </b-form-group>
        </ValidationProvider>
        <ValidationProvider
          ref="third-text"
          rules="required|min:2"
          name="Troisième texte"
          v-slot="{ errors }"
        >
          <b-form-group id="third-text" class="mb-5">
            <label for="input-third-text" class="text-uppercase"
              >Nouveau texte du troisième paragraphe</label
            >
            <b-form-textarea
              id="input-third-text"
              v-model="modifyPresentation.thirdText"
              size="lg"
            >
            </b-form-textarea>
            <b-alert
              class="mt-1"
              variant="danger"
              v-if="errors[0]"
              v-text="errors[0]"
              show
            >
            </b-alert>
          </b-form-group>
        </ValidationProvider>
        <div class="d-flex justify-content-center flex-wrap">
          <b-button
            type="submit"
            class="m-3 p-3 btn-modify"
            :disabled="loading"
            @click="$emit('onAction')"
          >
            <b-spinner
              v-show="loading"
              label="Spinning"
              class="mr-2"
            ></b-spinner>
            <font-awesome-icon icon="edit" />
            <span class="pl-2 pb-2">Modifier présentation</span>
          </b-button>
          <Button
            :color="cancelButtonColor"
            action="Annuler"
            icon="times"
            class="m-3 p-3"
            v-on:action="$emit('onCancel')"
          />
        </div>
      </b-form>
    </ValidationObserver>
  </div>
</template>

<script>
import { ValidationProvider, ValidationObserver } from "vee-validate";
import { mapActions, mapGetters } from "vuex";
import AlertForm from "@/components/form/AlertForm";
import Button from "@/components/Button";
import formatDate from "../../services/formatDate";
import setFormWithFile from "../../mixins/formMixin";

export default {
  name: "UpdatePresentationForm",
  components: {
    ValidationProvider,
    ValidationObserver,
    AlertForm,
    Button
  },
  data() {
    return {
      presentationColor: "#485DA6",
      cancelButtonColor: "#BE8C2E",
      loading: false,
      presentationId: null,
      modifyPresentation: {
        firstName: "",
        lastName: "",
        quote: "",
        picture: null,
        titleFirstText: "",
        firstText: "",
        titleSecondText: "",
        secondText: "",
        titleThirdText: "",
        thirdText: ""
      },
      oldPicture: "",
      previewPictureUrl: null,
      successMessage: "",
      errorMessage: "",
      showForm: false
    };
  },
  mixins: [setFormWithFile],
  computed: {
    ...mapGetters(["onePresentation"])
  },
  methods: {
    ...mapActions([
      "updatePresentationWithFile",
      "updatePresentationWithoutFile",
      "resetStatePresentation"
    ]),
    // Show a preview of the selected file of input file
    showPreview(event) {
      const file = event.target.files[0];
      if (file) {
        this.previewPictureUrl = URL.createObjectURL(file);
        document.getElementById("previewPicture").onload = function() {
          window.URL.revokeObjectURL(this.previewPictureUrl);
        };
      }
    },
    // Send Form or FormData to modify the prensentation with the new values
    onModify() {
      this.loading = true;
      this.$refs.modifyForm.validate().then(isValid => {
        if (!isValid) {
          this.loading = false;
          return;
        }
        if (!this.modifyPresentation.picture) {
          this.updatePresentationWithoutFile({
            id: this.onePresentation.id,
            form: this.modifyPresentation
          })
            .then(() => {
              this.successMessage =
                "Le présentation " +
                this.onePresentation.id +
                " a été modifier";
              this.loading = false;
              document.getElementById("alert").scrollIntoView();
            })
            .catch(error => {
              if (error.data) {
                this.errorMessage = error.data;
              } else {
                this.errorMessage = error;
              }
              this.successMessage = "";
            });
        } else {
          let fd = this.setFormWithFile(
            this.modifyPresentation.picture,
            this.modifyPresentation
          );
          this.updatePresentationWithFile({
            id: this.onePresentation.id,
            formData: fd
          })
            .then(() => {
              this.successMessage =
                "Le présentation " +
                this.onePresentation.id +
                " a été modifier";
              this.loading = false;
              document.getElementById("alert").scrollIntoView();
            })
            .catch(error => {
              if (error.data) {
                this.errorMessage = error.data;
              } else {
                this.errorMessage = error;
              }
              this.successMessage = "";
            });
        }
      });
    },
    formatDate(date) {
      return formatDate(date);
    },
    onReturn() {
      this.successMessage = "";
      this.errorMessage = "";
    }
  },
  mounted() {
    if (this.onePresentation.id) {
      this.modifyPresentation.firstName = this.onePresentation.firstName;
      this.modifyPresentation.lastName = this.onePresentation.lastName;
      this.modifyPresentation.quote = this.onePresentation.quote;
      this.modifyPresentation.titleFirstText = this.onePresentation.titleFirstText;
      this.modifyPresentation.firstText = this.onePresentation.firstText;
      this.modifyPresentation.titleSecondText = this.onePresentation.titleSecondText;
      this.modifyPresentation.secondText = this.onePresentation.secondText;
      this.modifyPresentation.titleThirdText = this.onePresentation.titleThirdText;
      this.modifyPresentation.thirdText = this.onePresentation.thirdText;
      this.oldPicture = this.onePresentation.picture;
      this.modifyPresentation.picture = null;
    }
  }
};
</script>

<style lang="scss" scoped>
.btn {
  &-modify {
    color: $white;
    background-color: $blue;
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
  &-body {
    background-color: transparent;
  }
}
.custom-file-label {
  background-color: transparent !important;
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
.form-group {
  label {
    font-size: 1.3rem;
    @include text-shadow(0px, 0px, 10px, $purple);
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
hr {
  background-color: $purple;
  width: 60%;
}
.nav-link {
  color: $white !important;
}
.row {
  height: unset;
}
.tabs {
  font-family: "Oswald", sans-serif;
  letter-spacing: 1px;
}
@media(min-width: 320px){
  form {
    width: 100%;
    margin: auto;
  }
  .presentation-form-title {
    font-size: 1.2rem;
  }
}
@media(min-width: 576px)
{
  .presentation-form-title {
    font-size: 1.5rem;
  }
}
@media(min-width: 768px){
  form {
    width: 100%;
    margin: auto;
    padding: 1.5rem;
  }
  .presentation-form-title {
    font-size: 2rem;
  }
}
</style>
