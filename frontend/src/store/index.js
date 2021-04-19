import Vue from "vue";
import Vuex from "vuex";
import skill from "./modules/skill";
import error from "./modules/error";
import software from "./modules/software";
import categories from "./modules/categories";
import career from "./modules/career";
import project from "./modules/project";
import presentation from "./modules/presentation";
import contact from "./modules/contact";
import auth from "./modules/auth";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {},
  mutations: {},
  getters: {},
  actions: {},
  modules: {
    skill,
    error,
    software,
    categories,
    career,
    project,
    auth,
    presentation,
    contact
  }
});
