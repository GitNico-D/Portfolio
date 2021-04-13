import axios from "axios";
import errorRedirection from "../../services/errorRedirection";
import authHeader from "../../services/authHeader";

const headers = { "Content-Type": "application/json" };

const state = () => ({
  presentations: [],
  presentation: ''
});

const getters = {
  allPresentations: state => state.presentations,
  onePresentation: state => state.presentation
};

const actions = {
  getAllPresentations({ commit }) {
    axios.get(process.env.VUE_APP_API_URL + "/presentations", {
        headers: headers
      })
      .then(response => {
        commit("SET_ALL_Presentation", response.data);
      })
      .catch(error => {
        errorRedirection(error);
      });
  },
  getPresentation({ commit }) {
    return axios.get(process.env.VUE_APP_API_URL + `/presentations/1`, {
        headers: headers
      })
      .then(response => {
        commit("SET_ONE_PRESENTATION", response.data);
      })
      .catch(error => {
        console.log(error.response.data);
        return Promise.reject(error.response.data);
      });
  },
  addPresentation({ commit }, formData) {
    return axios.post(process.env.VUE_APP_API_URL + '/presentations', formData, {
      headers: authHeader()
    })
    .then(formData => {
      commit("NEW_PRESENTATION", formData);
      return Promise.resolve(formData);
    })
    .catch(error => {
      return Promise.reject(error.response);
    })
  },
  updatePresentationWithFile({ commit }, { id, formData }) {
    return axios.post(process.env.VUE_APP_API_URL + `/presentations/${id}`, formData, {
      headers: authHeader(),
      params: {
        "_method": "PUT"
      }
    })
    .then(response => {
      commit("UPDATE_PRESENTATION", response.data);
      return Promise.resolve(response.data);
    })
    .catch(error => {
      return Promise.reject(error.response.data);
    })
  },
  updatePresentationWithoutFile({ commit }, { id, form }) {
    return axios.put(process.env.VUE_APP_API_URL + `/presentations/${id}`, form, {
      headers: authHeader(),
    })
    .then(response => {
      commit("UPDATE_PRESENTATION", response.data);
      return Promise.resolve(response.data);
    })
    .catch(error => {
      return Promise.reject(error.response.data);
    })
  },
  deletePresentation({ commit }, id) {
    return axios.delete(process.env.VUE_APP_API_URL + `/presentations/${id}`, {
      headers: authHeader()
    })
    .then(response => {
      commit("DELETE_PRESENTATION", response.data);
      return Promise.resolve(response.data);
    })
    .catch(error => {
      return Promise.reject(error.response.data);
    })
  },
  resetStatePresentation({ commit }) {
    commit("RESET_STATE_PRESENTATION")
  }
};

const mutations = {
  SET_ALL_PRESENTATION(state, presentations) {
    state.presentations = presentations;
  },
  SET_ONE_PRESENTATION(state, presentation) {
    state.presentation = presentation;
  },
  NEW_PRESENTATION(state, newPresentation) {
    state.presentations.unshift(newPresentation)
  },
  UPDATE_PRESENTATION(state, updatePresentation) {
    let presentationPosition = '';
    state.presentations.forEach((presentation, index) => {
      if(presentation.id === updatePresentation.id) {
        presentationPosition = index;
      }
    });
    state.presentations.splice(presentationPosition, 1, updatePresentation);
  },
  DELETE_PRESENTATION(state, id) {
    let presentationPosition = '';
    state.presentations.forEach((presentation, index) => {
      if(presentation.id === id) {
        presentationPosition = index;
      }
    });
    state.presentations.splice(presentationPosition, 1);
  }, 
  RESET_STATE_PRESENTATION(state) {
    state.presentation = '';
  }
};

export default {
  state,
  getters,
  actions,
  mutations
};
