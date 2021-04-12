import axios from "axios";
import errorRedirection from "../../services/errorRedirection";
import authHeader from "../../services/authHeader";

const headers = { "Content-Type": "application/json" };

const state = () => ({
  projects: [],
  project: ''
});

const getters = {
  allProjects: state => state.projects,
  oneProject: state => state.project
};

const actions = {
  getAllProjects({ commit }) {
    axios.get(process.env.VUE_APP_API_URL + "/projects", {
        headers: headers
      })
      .then(response => {
        commit("SET_ALL_PROJECT", response.data);
      })
      .catch(error => {
        errorRedirection(error);
      });
  },
  getProject({ commit }, id) {
    return axios.get(process.env.VUE_APP_API_URL + `/projects/${id}`, {
        headers: headers
      })
      .then(response => {
        commit("SET_ONE_PROJECT", response.data);
      })
      .catch(error => {
        console.log(error.response.data);
        return Promise.reject(error.response.data);
      });
  },
  addProject({ commit }, formData) {
    return axios.post(process.env.VUE_APP_API_URL + '/projects', formData, {
      headers: authHeader()
    })
    .then(formData => {
      commit("NEW_PROJECT", formData);
      return Promise.resolve(formData);
    })
    .catch(error => {
      return Promise.reject(error.response);
    })
  },
  updateProjectWithFile({ commit }, { id, formData }) {
    return axios.post(process.env.VUE_APP_API_URL + `/projects/${id}`, formData, {
      headers: authHeader(),
      params: {
        "_method": "PUT"
      }
    })
    .then(response => {
      commit("UPDATE_PROJECT", response.data);
      return Promise.resolve(response.data);
    })
    .catch(error => {
      return Promise.reject(error.response.data);
    })
  },
  updateProjectWithoutFile({ commit }, { id, form }) {
    return axios.put(process.env.VUE_APP_API_URL + `/projects/${id}`, form, {
      headers: authHeader(),
    })
    .then(response => {
      commit("UPDATE_PROJECT", response.data);
      return Promise.resolve(response.data);
    })
    .catch(error => {
      return Promise.reject(error.response.data);
    })
  },
  deleteProject({ commit }, id) {
    return axios.delete(process.env.VUE_APP_API_URL + `/projects/${id}`, {
      headers: authHeader()
    })
    .then(response => {
      commit("DELETE_PROJECT", response.data);
      return Promise.resolve(response.data);
    })
    .catch(error => {
      return Promise.reject(error.response.data);
    })
  },
  resetStateProject({ commit }) {
    commit("RESET_STATE_PROJECT")
  }
};

const mutations = {
  SET_ALL_PROJECT(state, projects) {
    state.projects = projects;
  },
  SET_ONE_PROJECT(state, project) {
    state.project = project;
  },
  NEW_PROJECT(state, newProject) {
    state.projects.unshift(newProject)
  },
  UPDATE_PROJECT(state, updateProject) {
    let projectPosition = '';
    state.projects.forEach((project, index) => {
      if(project.id === updateProject.id) {
        projectPosition = index;
      }
    });
    state.projects.splice(projectPosition, 1, updateProject);
  },
  DELETE_PROJECT(state, id) {
    let projectPosition = '';
    state.projects.forEach((project, index) => {
      if(project.id === id) {
        projectPosition = index;
      }
    });
    state.projects.splice(projectPosition, 1);
  }, 
  RESET_STATE_PROJECT(state) {
    state.project = '';
  }
};

export default {
  state,
  getters,
  actions,
  mutations
};
