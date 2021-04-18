<template>
  <b-container fluid>
    <BackgroundPage circleColor="#fff" />
    <Transition v-show="showTransition" directionAnimation="down" />
    <b-row class="justify-content-center align-items-center">
      <b-card title="Connexion"
        ><font-awesome-icon icon="user-shield" size="4x" class="my-3" />
        <hr />
        <b-card-body>
          <ValidationObserver ref="form" v-slot="{ handleSubmit }">
            <form @submit.prevent="handleSubmit(onSubmit)">
              <ValidationProvider
                ref="email"
                rules="required|email"
                name="Email"
                v-slot="{ errors }"
              >
                <b-form-group
                  id="input-group-1"
                  label="Email"
                  label-for="input-1"
                  class="text-left"
                >
                  <b-form-input
                    id="input-1"
                    v-model="user.email"
                    type="email"
                    placeholder="Entrer email"
                  >
                  </b-form-input>
                  <b-alert
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
                rules="required"
                name="Mot de passe"
                v-slot="{ errors }"
              >
                <b-form-group
                  id="input-group-2"
                  label="Mot de Passe"
                  label-for="input-2"
                  class="text-left mb-5"
                >
                  <b-form-input
                    id="input-2"
                    v-model="user.password"
                    type="password"
                    name="password"
                    placeholder="Entrer mot de passe"
                  >
                  </b-form-input>
                  <b-alert
                    variant="danger"
                    v-if="errors[0]"
                    v-text="errors[0]"
                    show
                    dismissible
                  >
                  </b-alert>
                </b-form-group>
              </ValidationProvider>
              <b-form-group>
                <b-button block type="submit" :disabled="loading">
                  <b-spinner
                    v-show="loading"
                    label="Spinning"
                    small
                  ></b-spinner>
                  <span class="ml-2">Se connecter</span>
                </b-button>
              </b-form-group>
              <b-form-group>
                <b-alert v-if="message" variant="danger" show dismissible>{{
                  message
                }}</b-alert>
              </b-form-group>
            </form>
          </ValidationObserver>
        </b-card-body>
        <HomePageLink
          action="Retour"
          url="/"
          direction="animated-arrowLtr"
          class="link-back"
          textColor="#fff"
        />
      </b-card>
    </b-row>
  </b-container>
</template>

<script>
import BackgroundPage from "@/components/BackgroundPage.vue";
import Transition from "@/components/Transition.vue";
import HomePageLink from "@/components/HomePageLink.vue";
import { ValidationProvider, ValidationObserver } from "vee-validate";
import { mapActions } from "vuex";

export default {
  name: "Login",
  components: {
    BackgroundPage,
    ValidationProvider,
    ValidationObserver,
    HomePageLink,
    Transition
  },
  data() {
    return {
      showTransition: true,
      email: "",
      user: {
        email: "",
        password: ""
      },
      loading: false,
      message: ""
    };
  },
  computed: {
    loggedIn() {
      return this.$store.state.auth.status.loggedIn;
    }
  },
  created() {
    if (this.loggedIn) {
      this.$router.push("/admin");
    }
  },
  methods: {
    ...mapActions(["login"]),
    onSubmit() {
      this.loading = true;
      this.$refs.form.validate().then(isValid => {
        if (!isValid) {
          this.loading = false;
          return;
        }
        if (this.user.email && this.user.password) {
          this.$store
            .dispatch("auth/login", this.user)
            .then(() => {
              this.$router.push("/admin");
            })
            .catch(() => {
              this.loading = false;
              this.message = "Identifiants invalides !";
            });
        }
      });
    },
    actionTransition() {
      this.showTransition = true;
      setTimeout(() => {
        this.showTransition = false;
      }, 1300);
    }
  },
  mounted() {
    setTimeout(() => {
      this.showTransition = false;
    }, 1300);
  }
};
</script>

<style lang="scss" scoped>
.container-fluid {
  background-color: $dark-gray;
  perspective: 1000px;
  position: relative;
  min-height: 100vh;
}

.card {
  border: 1px solid $white;
  background: $dark-gray;
  @include box_shadow(0px, 0px, 5px, $white);
  &-title {
    font-weight: bold;
  }
  &-body {
    color: $white;
    font-size: 1.3rem;
    font-family: "MontSerrat", sans-serif;
  }
  .btn {
    color: $white !important;
    background-color: transparent;
    border: 1px solid $white;
    &:hover {
      color: $dark-gray !important;
      background-color: $white !important;
      box-shadow: 0 0 10px $white !important;
    }
  }
}
hr {
  background: $white;
}
.link {
  &-back {
    position: absolute;
    bottom: -15%;
    transform: translateX(-50%) scale(0.8);
  }
}
.row {
  height: 100vh;
}
</style>
