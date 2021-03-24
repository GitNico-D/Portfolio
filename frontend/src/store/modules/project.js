import axios from "axios";
import errorRedirection from "../../services/errorRedirection";
import authHeader from "../../services/authHeader";

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
  },
  addProject({ commit, dispatch }, formData) {
    return axios.post(process.env.VUE_APP_API_URL + '/projects', formData, {
      headers: authHeader()
    })
    .then(response => {
      console.log(response.data);
      commit("NEW_PROJECT", response.data);
      return Promise(response.data);
    })
    .catch(error => {
      if (error.response.data.code === "401") {
        dispatch("logout")
      }
      return Promise.reject(error.response.data);
    })
  }
};

const mutations = {
  ADD_PROJECT(state, projects) {
    state.projects = projects;
  },
  NEW_PROJECT(state, newProject) {
    state.projects.unshift(newProject)
  }
};

export default {
  state,
  getters,
  actions,
  mutations
};
