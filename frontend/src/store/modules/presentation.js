import axios from "axios";
import errorRedirection from "../../services/errorRedirection";
import authHeader from "../../services/authHeader";

const headers = { "Content-Type": "application/json" };

//Two state for all presentation and one presentations
const state = () => ({
  presentations: [],
  presentation: ""
});

const getters = {
  allPresentations: state => state.presentations,
  onePresentation: state => state.presentation
};

const actions = {
  //Get all contacts presentation on bdd
  getAllPresentations({ commit }) {
    axios
      .get(process.env.VUE_APP_API_URL + "/presentations", {
        headers: headers
      })
      .then(response => {
        commit("SET_ALL_Presentation", response.data);
      })
      .catch(error => {
        errorRedirection(error);
      });
  },
  //Get a unique presentation defined by his id
  getPresentation({ commit }) {
    return axios
      .get(process.env.VUE_APP_API_URL + `/presentations/1`, {
        headers: headers
      })
      .then(response => {
        commit("SET_ONE_PRESENTATION", response.data);
      })
      .catch(error => {
        return Promise.reject(error.response.data);
      });
  },
  //This function treat request with file. A parameter "_method: "PUT" set with a POST method 
  //due to an issue with Symfony to receive and treat a formData on PUT method
  updatePresentationWithFile({ commit }, { id, formData }) {
    return axios
      .post(process.env.VUE_APP_API_URL + `/presentations/${id}`, formData, {
        headers: authHeader(),
        params: {
          _method: "PUT"
        }
      })
      .then(response => {
        commit("UPDATE_PRESENTATION", response.data);
        return Promise.resolve(response.data);
      })
      .catch(error => {
        return Promise.reject(error.response.data);
      });
  },
  //Classic PUT request to send a form with content-type: Application/json
  updatePresentationWithoutFile({ commit }, { id, form }) {
    return axios
      .put(process.env.VUE_APP_API_URL + `/presentations/${id}`, form, {
        headers: authHeader()
      })
      .then(response => {
        commit("UPDATE_PRESENTATION", response.data);
        return Promise.resolve(response.data);
      })
      .catch(error => {
        return Promise.reject(error.response.data);
      });
  },
};

//Mutations applied to the desired state related to the above actions 
const mutations = {
  SET_ALL_PRESENTATION(state, presentations) {
    state.presentations = presentations;
  },
  SET_ONE_PRESENTATION(state, presentation) {
    state.presentation = presentation;
  },
  NEW_PRESENTATION(state, newPresentation) {
    state.presentations.unshift(newPresentation);
  },
  UPDATE_PRESENTATION(state, updatePresentation) {
    let presentationPosition = "";
    state.presentations.forEach((presentation, index) => {
      if (presentation.id === updatePresentation.id) {
        presentationPosition = index;
      }
    });
    state.presentations.splice(presentationPosition, 1, updatePresentation);
  },
  DELETE_PRESENTATION(state, id) {
    let presentationPosition = "";
    state.presentations.forEach((presentation, index) => {
      if (presentation.id === id) {
        presentationPosition = index;
      }
    });
    state.presentations.splice(presentationPosition, 1);
  },
  RESET_STATE_PRESENTATION(state) {
    state.presentation = "";
  }
};

export default {
  state,
  getters,
  actions,
  mutations
};
