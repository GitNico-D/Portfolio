import axios from "axios";
import errorRedirection from "../../services/errorRedirection";
import authHeader from "../../services/authHeader";

const headers = { "Content-Type": "application/json" };

//Two state for all project and one projects
const state = () => ({
  projects: [],
  project: ""
});

const getters = {
  allProjects: state => state.projects,
  oneProject: state => state.project
};

const actions = {
  //Get all projects present on bdd
  getAllProjects({ commit }) {
    axios
      .get(process.env.VUE_APP_API_URL + "/projects", {
        headers: headers
      })
      .then(response => {
        commit("SET_ALL_PROJECT", response.data);
      })
      .catch(error => {
        errorRedirection(error);
      });
  },
  //Get a unique contact defined by his id
  getProject({ commit }, id) {
    return axios
      .get(process.env.VUE_APP_API_URL + `/projects/${id}`, {
        headers: headers
      })
      .then(response => {
        commit("SET_ONE_PROJECT", response.data);
      })
      .catch(error => {
        return Promise.reject(error.response);
      });
  },
  //Add a new project
  addProject({ commit }, formData) {
    return axios
      .post(process.env.VUE_APP_API_URL + "/projects", formData, {
        headers: authHeader()
      })
      .then(formData => {
        commit("NEW_PROJECT", formData);
        return Promise.resolve(formData);
      })
      .catch(error => {
        return Promise.reject(error.response);
      });
  },
  //This function treat request with file. A parameter "_method: "PUT" set with a POST method 
  //due to an issue with Symfony to receive and treat a formData on PUT method
  updateProjectWithFile({ commit }, { id, formData }) {
    return axios
      .post(process.env.VUE_APP_API_URL + `/projects/${id}`, formData, {
        headers: authHeader(),
        params: {
          _method: "PUT"
        }
      })
      .then(response => {
        commit("UPDATE_PROJECT", response.data);
        return Promise.resolve(response.data);
      })
      .catch(error => {
        return Promise.reject(error.response);
      });
  },
  //Classic PUT request to send a form with content-type: Application/json
  updateProjectWithoutFile({ commit }, { id, form }) {
    return axios
      .put(process.env.VUE_APP_API_URL + `/projects/${id}`, form, {
        headers: authHeader()
      })
      .then(response => {
        commit("UPDATE_PROJECT", response.data);
        return Promise.resolve(response.data);
      })
      .catch(error => {
        return Promise.reject(error.response);
      });
  },
  //Delete a project defined by his id
  deleteProject({ commit }, id) {
    return axios
      .delete(process.env.VUE_APP_API_URL + `/projects/${id}`, {
        headers: authHeader()
      })
      .then(response => {
        commit("DELETE_PROJECT", response.data);
        return Promise.resolve(response.data);
      })
      .catch(error => {
        return Promise.reject(error.response);
      });
  },
  //Reset the oneProject state
  resetStateProject({ commit }) {
    commit("RESET_STATE_PROJECT");
  }
};

//Mutations applied to the desired state related to the above actions 
const mutations = {
  SET_ALL_PROJECT(state, projects) {
    state.projects = projects;
  },
  SET_ONE_PROJECT(state, project) {
    state.project = project;
  },
  NEW_PROJECT(state, newProject) {
    state.projects.unshift(newProject);
  },
  UPDATE_PROJECT(state, updateProject) {
    let projectPosition = "";
    state.projects.forEach((project, index) => {
      if (project.id === updateProject.id) {
        projectPosition = index;
      }
    });
    state.projects.splice(projectPosition, 1, updateProject);
  },
  DELETE_PROJECT(state, id) {
    let projectPosition = "";
    state.projects.forEach((project, index) => {
      if (project.id === id) {
        projectPosition = index;
      }
    });
    state.projects.splice(projectPosition, 1);
  },
  RESET_STATE_PROJECT(state) {
    state.project = "";
  }
};

export default {
  state,
  getters,
  actions,
  mutations
};
