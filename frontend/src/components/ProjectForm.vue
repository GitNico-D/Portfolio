<template>
  <b-row class="justify-content-center my-4">
    <b-col cols="8">
      <b-tabs
        active-nav-item-class="font-weight-bold text-sucess"
        active-tab-class="font-weight-bold text-left text-white"
        content-class="mt-3"
        align="center"
      >
        <b-tab title="Ajouter un nouveau projet" active>
          <b-form @submit="onSubmit" @reset="onReset" v-if="show">
            <b-form-group id="title" label="Titre du projet" label-for="input-title" class="mt-5">
              <b-form-input 
                id="input-title" 
                v-model="form.title" 
                type="email" 
                placeholder="Entrer titre" 
                required>
              </b-form-input>
            </b-form-group>
            <b-form-group id="textarea" label="Description du projet" label-for="input-textarea" class="mt-5">
              <b-form-textarea
                id="input-textarea"
                v-model="form.description"
                type="text"
                placeholder="Entrer description"
                required
              ></b-form-textarea>
            </b-form-group>
            <b-form-group id="url" label="Url du projet" label-for="input-url" class="mt-5">
              <b-form-input
                id="input-url"
                v-model="form.name"
                placeholder="Enter url"
                required
              ></b-form-input>
            </b-form-group>
            <b-form-group id="img" label="Image de présentation du projet" label-for="input-img" class="mt-5">
              <b-form-file
                id="input-img"
                v-model="form.imgStatic"
                :state="Boolean(form.imgStatic)"
                placeholder="Choisir un fichier ou glisser-déposer ici"
                drop-placeholder="Choisir un fichier"
              ></b-form-file>
            <div class="mt-3">Fichier sélectionné: {{ form.imgStatic ? form.imgStatic.name : '' }}</div>
            </b-form-group>
            <b-form-group id="description-img" label="Description de l'image du projet" label-for="input-description-img" class="mt-5">
              <b-form-input 
                id="input-description-img" 
                v-model="form.descriptionImg" 
                type="text" 
                placeholder="Entrer description" 
                required>
              </b-form-input>
            </b-form-group>
            <b-form-group id="creation-date" label="Date de création du projet" label-for="input-creation-date" class="mt-5">
              <b-form-datepicker id="creation-date" v-model="form.creationDate" class="mb-2"></b-form-datepicker>
              <p>Date de création: '{{ form.creationDate }}'</p>
            </b-form-group>
            <b-button class="text-center" type="submit" variant="primary">Submit</b-button>
            <b-button type="reset" variant="danger">Reset</b-button>
          </b-form>
        </b-tab>
        <b-tab title="Modifier un projet">
        </b-tab>
      </b-tabs>
      <b-card class="mt-3" header="Form Data Result">
        <pre class="m-0">{{ form }}</pre>
      </b-card>
    </b-col>
  </b-row>
</template>

<script>
  export default {
    name: "ProjectForm",
    data() {
      return {
        form: {
          title: '',
          description: '',
          imgStatic: null,
          descriptionImg: '',
          creationDate: '',
          value: ''
        },
        show: true
      }
    },
    methods: {
      onSubmit(event) {
        event.preventDefault()
        alert(JSON.stringify(this.form))
      },
      onReset(event) {
        event.preventDefault()
        // Reset our form values
        this.form.title = ''
        this.form.description = ''
        this.form.imgStatic = null
        this.form.descriptionImg = ''
        this.form.creationDate = ''
        this.show = false
        this.$nextTick(() => {
          this.show = true
        })
      }
    }
  }
</script>

<style lang="scss" scoped>
.row {
  height: unset;
}
</style>
