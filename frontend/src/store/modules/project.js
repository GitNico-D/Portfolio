import axios from "axios";
import errorRedirection from "../../services/errorRedirection";

const headers = { "Content-Type": "application/json" };

const state = () => ({
  projects: []
});

const getters = {
  allProjects: state => state.projects
};

const actions = {
  getAllProjects({ commit }) {
    axios
      .get(process.env.VUE_APP_API_URL + "/projects", {
        headers: headers
      })
      .then(response => {
        commit("ADD_PROJECT", response.data);
      })
      .catch(error => {
        errorRedirection(error);
      });
  }
};

const mutations = {
  ADD_PROJECT(state, projects) {
    state.projects = projects;
  }
};

export default {
  state,
  getters,
  actions,
  mutations
};
