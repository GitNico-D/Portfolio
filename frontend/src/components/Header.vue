<template>
  <b-row>
    <b-navbar toggleable="sm">
      <b-navbar-toggle
        target="nav-collapse"
        :style="{ '--color': color }"
      ></b-navbar-toggle>
      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav class="py-3" :style="{ '--color': color }">
          <router-link to="/" v-b-popover.hover.leftbottom="'Accueil'">
            <font-awesome-icon icon="home" /> </router-link
          ><span class="px-3" :style="{ '--color': color }"> | </span>
          <router-link to="/presentation">Présentation</router-link
          ><span class="px-3" :style="{ '--color': color }"> | </span>
          <router-link to="/projects">Projets</router-link
          ><span class="px-3" :style="{ '--color': color }"> | </span>
          <router-link to="/skills">Compétences</router-link
          ><span class="px-3" :style="{ '--color': color }"> | </span>
          <router-link to="/career">Carrières</router-link
          ><span class="px-3" :style="{ '--color': color }"> | </span>
          <b-link
            v-if="loggedIn"
            to="/admin"
            @click="reloadPage"
            v-b-popover.hover.bottom="'Vers page administrateur'"
          >
            <font-awesome-icon icon="user-shield" />
          </b-link>
          <router-link
            to="/login"
            v-if="!loggedIn"
            v-b-popover.hover.bottom="'Connexion'"
          >
            <font-awesome-icon icon="sign-out-alt" /> </router-link
          ><span class="px-3" :style="{ '--color': color }"> | </span>
          <b-link
            to=""
            v-if="loggedIn"
            @click.prevent="logOut"
            v-b-popover.hover.bottom="'Déconnexion'"
          >
            <font-awesome-icon icon="sign-in-alt" />
          </b-link>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
    <h1 :style="{ '--color': color }" class="mt-3">{{ title }}</h1>
  </b-row>
</template>

<script>
export default {
  name: "Header",
  props: {
    color: String,
    title: String
  },
  methods: {
    logOut() {
      this.$store.dispatch("auth/logout");
      this.$router.push("/login");
    },
    reloadPage() {
      document.location.reload(true);
    }
  },
  computed: {
    loggedIn() {
      return this.$store.state.auth.status.loggedIn;
    }
  }
};
</script>

<style lang="scss" scoped>
.row {
  .navbar {
    width: 100%;
    &-nav {
      margin: auto;
      a {
        position: relative;
        font-family: "Oswald", sans-serif;
        color: $white;
        text-transform: uppercase;
        transition: ease-out 0.2s;
        animation: tracking-in-expand 0.7s cubic-bezier(0.215, 0.61, 0.355, 1)
          1.3s both;
        &::after {
          position: absolute;
          content: " ";
          top: 100%;
          left: 0;
          width: 100%;
          height: 3px;
          background: var(--color);
          transform: scaleX(0);
          transform-origin: right;
          transition: transform 0.5s;
        }
        &:hover::after {
          transform: scaleX(1);
          transform-origin: left;
        }
        &:hover {
          color: var(--color);
        }
      }
      .router-link-exact-active {
        color: var(--color);
        &:hover {
          color: $white;
        }
      }
      span {
        color: var(--color);
        font-weight: bold;
        animation: swirl-in-fwd 0.8s ease-out 1.6s both;
      }
    }
    button {
      color: $white;
      background-color: var(--color);
      border: 1px solid var(--color) !important;
    }
  }
  h1 {
    @include customFont;
    text-shadow: 0 1px 0 var(--color), 0 2px 0 var(--color),
      0 3px 0 var(--color), 0 4px 0 var(--color), 0 5px 0 var(--color),
      0 6px 0 var(--color), 0 7px 0 var(--color), 0 8px 0 var(--color),
      0 9px 0 var(--color);
    color: $white;
    text-transform: uppercase;
    animation: tracking-in-expand 0.7s cubic-bezier(0.215, 0.61, 0.355, 1) 1s
      both;
  }
  @keyframes tracking-in-expand {
    0% {
      letter-spacing: -0.5em;
      opacity: 0;
    }
    40% {
      opacity: 0.6;
    }
    100% {
      opacity: 1;
    }
  }
  @keyframes swirl-in-fwd {
    0% {
      transform: rotate(-540deg) scale(0);
      opacity: 0;
    }
    100% {
      transform: rotate(0) scale(1);
      opacity: 1;
    }
  }
}
@media (min-width: 320px) {
  .row {
    h1 {
      font-size: 1.8rem !important;
    }
    .navbar {
      padding: unset;
      button {  
        margin: auto !important;
        margin-top: 1rem !important;
      }
      &-nav {
        a {
          margin-bottom: 0.5rem;
        }
        span {
          display: none;
        }
      }
    }
  }
}
@media (min-width: 576px) {
  .row {
    h1 {
      font-size: 2.2rem !important;
    }
    .navbar {
      &-nav {
        span {
          display: block;
        }
      }
    }
  }
}
@media (min-width: 768px) {
  .row {
    height: 25vh;
    h1 {
      font-size: 2.8rem !important;
    }
    .navbar {
      &-nav {
        padding: 1.5rem;
      }
    }
  }
}
</style>
