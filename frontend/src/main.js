import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import { BootstrapVue } from "bootstrap-vue";
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
import "@/styles/scss/global.scss";
import axios from "axios";
import VueAxios from "vue-axios";
import Vuex from "vuex";
import store from "./store";
import {
  ValidationObserver,
  ValidationProvider,
  extend,
  localize
} from "vee-validate";
import fr from "vee-validate/dist/locale/fr.json";
import * as rules from "vee-validate/dist/rules";
import { library } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import {
  faHome,
  faUserShield,
  faSignInAlt,
  faSignOutAlt,
  faAngleDoubleRight,
  faFolderPlus,
  faEdit,
  faDatabase,
  faChartPie,
  faLaptopCode,
  faAddressBook,
  faTrashAlt,
  faTimes,
  faPlus,
  faArrowLeft,
  faSync,
} from "@fortawesome/free-solid-svg-icons";
import "./validation-config";

Object.keys(rules).forEach(rule => {
  extend(rule, rules[rule]);
});
localize("fr", fr);

library.add(
  faHome, 
  faUserShield, 
  faSignInAlt, 
  faSignOutAlt, 
  faAngleDoubleRight, 
  faFolderPlus,
  faEdit,
  faDatabase,
  faChartPie,
  faLaptopCode,
  faAddressBook,
  faTrashAlt,
  faTimes,
  faPlus,
  faArrowLeft,
  faSync
  );
Vue.component("font-awesome-icon", FontAwesomeIcon);
Vue.component("ValidationObserver", ValidationObserver);
Vue.component("ValidationProvider", ValidationProvider);

Vue.use(BootstrapVue);
Vue.use(VueAxios, axios);
Vue.use(Vuex);

Vue.config.productionTip = false;

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount("#app");
