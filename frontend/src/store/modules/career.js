import axios from "axios";
import errorRedirection from "../../services/errorRedirection";
import authHeader from "../../services/authHeader";

const headers = { "Content-Type": "application/json" };

const state = () => ({
  careerStages: [],
  careerStage: ''
});

const getters = {
  allCareerStages: state => state.careerStages,
  oneCareer: state => state.careerStage
};

const actions = {
  getAllCareerStage({ commit }) {
    axios.get(process.env.VUE_APP_API_URL + "/experiences", {
        headers: headers
      })
      .then(response => {
        commit("SET_ALL_CAREER_STAGE", response.data);
      })
      .catch(error => {
        errorRedirection(error);
      });
  },
  getCareerStage({ commit }, id) {
    return axios.get(process.env.VUE_APP_API_URL + `/experiences/${id}`, {
        headers: headers
      })
      .then(response => {
        commit("SET_ONE_CAREER", response.data);
      })
      .catch(error => {
        console.log(error.response.data);
        return Promise.reject(error.response.data);
      });
  },
  addCareerStage({ commit }, formData) {
    return axios.post(process.env.VUE_APP_API_URL + '/experiences', formData, {
      headers: authHeader()
    })
    .then(formData => {
      commit("NEW_CAREER_STAGE", formData);
      return Promise.resolve(formData);
    })
    .catch(error => {
      return Promise.reject(error.response);
    })
  },
  updateCareerStageWithFile({ commit }, { id, formData }) {
    return axios.post(process.env.VUE_APP_API_URL + `/experiences/${id}`, formData, {
      headers: authHeader(),
      params: {
        "_method": "PUT"
      }
    })
    .then(response => {
      commit("UPDATE_CAREER_STAGE", response);
      return Promise.resolve(response.data);
    })
    .catch(error => {
      return Promise.reject(error.response);
    })
  },
  updateCareerStageWithoutFile({ commit }, { id, form }) {
    return axios.put(process.env.VUE_APP_API_URL + `/experiences/${id}`, form, {
      headers: authHeader(),
    })
    .then(response => {
      commit("UPDATE_CAREER_STAGE", response.data);
      return Promise.resolve(response.data);
    })
    .catch(error => {
      return Promise.reject(error.response);
    })
  },
  deleteCareerStage({ commit }, id) {
    return axios.delete(process.env.VUE_APP_API_URL + `/experiences/${id}`, {
      headers: authHeader()
    })
    .then(response => {
      commit("DELETE_CAREER_STAGE", response.data);
      return Promise.resolve(response.data);
    })
    .catch(error => {
      console.log(error.response);
      return Promise.reject(error.response);
    })
  },
  resetStateCareerStage({ commit }) {
    commit("RESET_STATE_CAREER_STAGE")
  }
};

const mutations = {
  SET_ALL_CAREER_STAGE(state, careerStages) {
    state.careerStages = careerStages;
  },
  SET_ONE_CAREER(state, careerStage) {
    state.careerStage = careerStage;
  },
  NEW_CAREER_STAGE(state, newCareerStage) {
    state.careerStages.unshift(newCareerStage)
  },
  UPDATE_CAREER_STAGE(state, updateCareerStage) {
    let careerStagePosition = '';
    state.careerStages.forEach((careerStage, index) => {
      if(careerStage.id === updateCareerStage.id) {
        careerStagePosition = index;
      }
    });
    state.careerStages.splice(careerStagePosition, 1, updateCareerStage);
  },
  DELETE_CAREER_STAGE(state, id) {
    let careerStagePosition = '';
    state.careerStages.forEach((careerStage, index) => {
      if(careerStage.id === id) {
        careerStagePosition = index;
      }
    });
    state.careerStages.splice(careerStagePosition, 1);
  }, 
  RESET_STATE_CAREER_STAGE(state) {
    state.careerStage = '';
  }
};

export default {
  state,
  getters,
  actions,
  mutations
};
