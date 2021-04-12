import axios from "axios";
import errorRedirection from "../../services/errorRedirection";

const state = () => ({
  softwares: [],
  software: ''
});

const getters = {
  allSoftwares: state => state.softwares,
  oneSoftware: state => state.software
};

const actions = {
  getAllSoftwares({ commit }) {
    axios
      .get(process.env.VUE_APP_API_URL + "/softwares", {
        headers: {
          "Content-Type": "application/json"
        }
      })
      .then(response => {
        commit("ADD_SOFTWARE", response.data);
      })
      .catch(error => {
        errorRedirection(error);
      });
  },
  getSoftware({ commit }, id) {
    return axios.get(process.env.VUE_APP_API_URL + `/softwares/${id}`, {
        headers: headers
      })
      .then(response => {
        commit("SET_ONE_SOFTWARE", response.data);
      })
      .catch(error => {
        console.log(error.response.data);
        return Promise.reject(error.response.data);
      });
  },
  addSoftware({ commit }, formData) {
    return axios.post(process.env.VUE_APP_API_URL + '/softwares', formData, {
      headers: authHeader()
    })
    .then(formData => {
      commit("NEW_SOFTWARE", formData);
      return Promise.resolve(formData);
    })
    .catch(error => {
      return Promise.reject(error.response);
    })
  },
  updateSoftwareWithFile({ commit }, { id, formData }) {
    return axios.post(process.env.VUE_APP_API_URL + `/softwares/${id}`, formData, {
      headers: authHeader(),
      params: {
        "_method": "PUT"
      }
    })
    .then(response => {
      commit("UPDATE_SOFTWARE", response.data);
      return Promise.resolve(response.data);
    })
    .catch(error => {
      return Promise.reject(error.response.data);
    })
  },
  updateSoftwareWithoutFile({ commit }, { id, form }) {
    return axios.put(process.env.VUE_APP_API_URL + `/softwares/${id}`, form, {
      headers: authHeader(),
    })
    .then(response => {
      commit("UPDATE_SOFTWARE", response.data);
      return Promise.resolve(response.data);
    })
    .catch(error => {
      return Promise.reject(error.response.data);
    })
  },
  deleteSoftware({ commit }, id) {
    return axios.delete(process.env.VUE_APP_API_URL + `/softwares/${id}`, {
      headers: authHeader()
    })
    .then(response => {
      commit("DELETE_SOFTWARE", response.data);
      return Promise.resolve(response.data);
    })
    .catch(error => {
      return Promise.reject(error.response.data);
    })
  },
  resetStateSoftware({ commit }) {
    commit("RESET_STATE_SOFTWARE")
  }
};

const mutations = {
  ADD_SOFTWARE(state, softwares) {
    state.softwares = softwares;
  },
  SET_ONE_SOFTWARE(state, software) {
    state.software = software;
  },
  NEW_SOFTWARE(state, newSoftware) {
    state.softwares.unshift(newSoftware)
  },
  UPDATE_SOFTWARE(state, updateSoftware) {
    let softwarePosition = '';
    state.softwares.forEach((software, index) => {
      if(software.id === updateSoftware.id) {
        softwarePosition = index;
      }
    });
    state.softwares.splice(softwarePosition, 1, updateSoftware);
  },
  DELETE_SOFTWARE(state, id) {
    let softwarePosition = '';
    state.softwares.forEach((software, index) => {
      if(software.id === id) {
        softwarePosition = index;
      }
    });
    state.softwares.splice(softwarePosition, 1);
  }, 
  RESET_STATE_SOFTWARE(state) {
    state.software = '';
  }
};

export default {
  state,
  getters,
  actions,
  mutations
};
