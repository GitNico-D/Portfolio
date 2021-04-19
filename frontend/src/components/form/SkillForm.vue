<template>
<b-row>
  <b-col cols md="12" lg="9">
    <div id="alert">
      <AlertForm
        v-if="successMessage"
        :message="successMessage"
        variant="success"
      />
      <AlertForm v-if="errorMessage" :message="errorMessage" variant="danger" />
    </div>
    <div class="text-center">
      <Button
        :color="skillColor"
        action="Retour liste"
        icon="arrow-left"
        class="m-3 p-3"
        v-on:action="$emit('onReturn'), onReturn()"
      />
    </div>
    <div v-if="!oneSkill.id">
      <h2 id="addForm-title" class="text-center fw-bold my-5">
        Remplisser le formulaire ci-dessous pour ajouter une nouvelle
        <span class="font-weight-bold font-style-italic">Compétence !</span>
      </h2>
    </div>
    <div v-else>
      <h2 id="modifyForm-title" class="text-center fw-bold my-5">
        Modification de la compétence
        <p class="my-2">
          <span class="font-weight-bold font-style-italic"
            >"{{ currentName }}"</span
          >
        </p>
      </h2>
      <p class="mt-4 text-left" v-show="oneSkill.id">
        ID de la
        <span class="text-uppercase font-weight-bold">compétence : </span>
        {{ oneSkill.id }}
      </p>
    </div>
    <ValidationObserver ref="skillForm" v-slot="{ handleSubmit }">
      <b-form
        @submit.prevent="handleSubmit(onSubmit)"
        :methodAction="methodAction"
      >
        <ValidationProvider
          ref="name"
          rules="required|min:2|max:100"
          name="Titre"
          v-slot="{ errors }"
        >
          <b-form-group id="name" class="mb-5">
            <label v-if="oneSkill.id" for="input-name" class="text-uppercase"
              >Nouveau nom de la compétence</label
            >
            <label v-else for="input-name" class="text-uppercase"
              >Nom de la compétence</label
            >
            <b-form-input
              id="input-name"
              v-model="skill.name"
              placeholder="Entrer un nom"
            >
            </b-form-input>
            <b-alert variant="danger" v-if="errors[0]" v-text="errors[0]" show>
            </b-alert>
          </b-form-group>
        </ValidationProvider>
        <ValidationProvider
          ref="description"
          rules="required|min:2"
          name="Description"
          v-slot="{ errors }"
        >
          <b-form-group id="textarea" class="mb-5">
            <label
              v-if="oneSkill.id"
              for="input-textarea"
              class="text-uppercase"
              >Nouvelle description de la compétence</label
            >
            <label v-else for="input-textarea" class="text-uppercase"
              >Description de la compétence</label
            >
            <b-form-textarea
              id="input-textarea"
              v-model="skill.description"
              placeholder="Entrer une description"
              size="lg"
            >
            </b-form-textarea>
            <b-alert variant="danger" v-if="errors[0]" v-text="errors[0]" show>
            </b-alert>
          </b-form-group>
        </ValidationProvider>
        <ValidationProvider
          ref="level"
          rules="required|numeric"
          name="Niveau de compétence"
          v-slot="{ errors }"
        >
          <b-form-group id="level" class="mb-5">
            <label v-if="oneSkill.id" for="input-level" class="text-uppercase"
              >Nouveau niveau de la compétence</label
            >
            <label v-else for="input-level" class="text-uppercase"
              >Niveau de compétence</label
            >
            <b-form-input
              type="number"
              id="input-level"
              v-model="skill.level"
              placeholder="0"
            >
            </b-form-input>
            <b-alert variant="danger" v-if="errors[0]" v-text="errors[0]" show>
            </b-alert>
          </b-form-group>
        </ValidationProvider>
        <div>
          <h5 v-show="!skill.icon && oldIcon" class="text-left text-uppercase">
            Icone de la compétence
          </h5>
          <b-img
            :src="oldIcon"
            fluid
            alt="Icone compétence"
            class="mt-1"
            v-show="!skill.icon && oldIcon"
          ></b-img>
        </div>
        <ValidationProvider
          ref="icon"
          :rules="!oneSkill.id ? 'required' : ''"
          name="Image"
          v-slot="{ errors }"
        >
          <b-form-group id="icon" class="mb-5">
            <label v-if="oneSkill.id" for="input-icon" class="text-uppercase"
              >Nouvelle Icone de la compétence</label
            >
            <label v-else for="input-icon" class="text-uppercase"
              >Icone de la compétence</label
            >
            <b-form-file
              id="input-icon"
              ref="file"
              name="icon"
              v-model="skill.icon"
              :state="Boolean(skill.icon)"
              browse-text="Parcourir"
              accept="image/*"
              placeholder="Choisir un fichier ou glisser-déposer ici"
              drop-placeholder="Choisir un fichier"
              @change="showPreview($event)"
            >
            </b-form-file>
            <b-alert variant="danger" v-if="errors[0]" v-text="errors[0]" show>
            </b-alert>
            <div class="mt-3">
              Fichier sélectionné: {{ skill.icon ? skill.icon.name : "" }}
            </div>
            <b-img
              thumbnail
              fluid
              id="previewIcon"
              v-show="previewIconUrl && skill.icon"
              :src="previewIconUrl"
            ></b-img>
          </b-form-group>
        </ValidationProvider>
        <ValidationProvider
          ref="category"
          rules="required"
          name="Catégorie"
          v-slot="{ errors }"
        >
          <b-form-group id="category" class="mt-5 text">
            <label for="input-category" class="text-uppercase"
              >Choix de la categorie</label
            >
            <b-form-select
              v-model="selected"
              :options="options"
              @change="setCategory"
            >
            </b-form-select>
            <b-alert variant="danger" v-if="errors[0]" v-text="errors[0]" show>
            </b-alert>
          </b-form-group>
        </ValidationProvider>
        <div class="d-flex justify-content-center">
          <b-button
            type="submit"
            class="m-3 p-3 btn-add"
            :disabled="loading"
            @click="$emit('onAction'), onSubmit()"
          >
            <b-spinner
              v-show="loading"
              label="Spinning"
              class="pt-4 pl-2"
            ></b-spinner>
            <font-awesome-icon icon="folder-plus" /><span class="pl-2 pb-2"
              >Ajouter compétence</span
            >
          </b-button>
          <Button
            v-show="!oneSkill.id"
            :color="resetButtonColor"
            action="Réinitialiser formulaire"
            icon="trash-alt"
            class="m-3 p-3"
            v-on:action="resetForm"
          />
          <Button
            :color="cancelButtonColor"
            action="Annuler"
            icon="times"
            class="m-3 p-3"
            v-on:action="$emit('onCancel'), resetForm()"
          />
        </div>
      </b-form>
    </ValidationObserver>
  </b-col>
  <b-row>
</template>

<script>
import { ValidationProvider, ValidationObserver } from "vee-validate";
import { mapActions, mapGetters } from "vuex";
import AlertForm from "@/components/form/AlertForm";
import Button from "@/components/Button";
import formatDate from "../../services/formatDate";
import setFormWithFile from "../../mixins/formMixin";

export default {
  name: "SkillForm",
  components: {
    ValidationProvider,
    ValidationObserver,
    AlertForm,
    Button
  },
  data() {
    return {
      skillColor: "#36C486",
      cancelButtonColor: "#BE8C2E",
      resetButtonColor: "#ef233c",
      skill: {
        name: "",
        description: "",
        icon: null,
        level: "",
        category: null
      },
      oldIcon: "",
      currentName: "",
      loading: false,
      successMessage: "",
      errorMessage: "",
      previewIconUrl: null,
      selected: null,
      options: [
        { value: null, text: "Choisir une catégorie" },
        { value: 1, text: "Informatique" },
        { value: 2, text: "Son" },
        { value: 3, text: "Vidéo" }
      ]
    };
  },
  props: {
    methodAction: {
      type: String,
      default: "create"
    }
  },
  mixins: [setFormWithFile],
  computed: {
    ...mapGetters(["oneCategory", "oneSkill"])
  },
  methods: {
    ...mapActions([
      "addSkill",
      "getCategory",
      "updateSkillWithFile",
      "updateSkillWithoutFile",
      "resetStateSkill"
    ]),
    setCategory() {
      return (this.skill.category = this.selected);
    },
    showPreview(event) {
      const file = event.target.files[0];
      if (file) {
        this.previewIconUrl = URL.createObjectURL(file);
        document.getElementById("previewIcon").onload = function() {
          window.URL.revokeObjectURL(this.previewIconUrl);
        };
      }
    },
    onSubmit() {
      if (this.methodAction == "create") {
        this.loading = true;
        this.$refs.skillForm.validate().then(isValid => {
          if (!isValid) {
            this.loading = false;
            return;
          }
          let fd = this.setFormWithFile(this.skill.icon, this.skill);
          this.addSkill(fd)
            .then(() => {
              this.successMessage = "La compétence a été ajoutée !";
              document.getElementById("alert").scrollIntoView();
              this.loading = false;
              this.errorMessage = "";
              this.resetForm();
            })
            .catch(error => {
              this.errorMessage = error.data[0].message;
              document.getElementById("alert").scrollIntoView();
              this.loading = false;
              this.successMessage = "";
            });
        });
      } else {
        this.loading = true;
        this.$refs.skillForm.validate().then(isValid => {
          if (!isValid) {
            this.loading = false;
            return;
          }
          if (!this.skill.icon) {
            this.updateSkillWithoutFile({
              id: this.oneSkill.id,
              form: this.skill
            })
              .then(() => {
                this.successMessage =
                  "La compétence " + this.oneSkill.id + " a été modifier";
                this.loading = false;
                this.errorMessage = "";
                this.resetForm();
                document.getElementById("alert").scrollIntoView();
              })
              .catch(error => {
                if (error.data[0]) {
                  this.errorMessage = error.data[0].message;
                } else {
                  this.errorMessage = error;
                }
              });
          } else {
            let fd = this.setFormWithFile(this.skill.icon, this.skill);
            this.updateSkillWithFile({
              id: this.oneSkill.id,
              formData: fd
            })
              .then(() => {
                this.successMessage =
                  "La compétence " + this.oneSkill.id + " a été modifier";
                this.loading = false;
                this.errorMessage = "";
                this.resetForm();
                document.getElementById("alert").scrollIntoView();
              })
              .catch(error => {
                if (error.data[0]) {
                  this.errorMessage = error.data[0].message;
                } else {
                  this.errorMessage = error;
                }
              });
          }
        });
      }
    },
    resetForm() {
      this.$refs.skillForm.reset();
      this.loading = false;
      this.skill.name = "";
      this.skill.description = "";
      this.skill.icon = null;
      this.skill.level = "";
      this.oldIcon = "";
      this.previewIconUrl = "";
    },
    onReturn() {
      this.successMessage = "";
      this.errorMessage = "";
    },
    formatDate(date) {
      return formatDate(date);
    }
  },
  mounted() {
    console.log(this.methodAction);
    if (this.methodAction == "update") {
      this.skill = this.oneSkill;
      this.currentName = this.oneSkill.name;
      this.oldIcon = this.oneSkill.icon;
      this.skill.icon = null;
      this.selected = this.oneCategory.id;
      this.skill.category = this.oneCategory.id;
    } else {
      this.selected = 0;
      this.selected = this.oneCategory.id;
      this.skill.category = this.oneCategory.id;
    }
  }
};
</script>

<style lang="scss" scoped>
.btn {
  &-add
  {
    color: $white;
    background-color: $green;
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
form {
  width: 90%;
  margin: auto;
  padding: 1.5rem;
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
.form-group {
  margin-bottom: 2rem;
}
.nav-link {
  color: $white !important;
}
.tabs {
  font-family: "Oswald", sans-serif;
  letter-spacing: 1px;
}
</style>
