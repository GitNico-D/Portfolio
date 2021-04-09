import axios from "axios";
import errorRedirection from "../../services/errorRedirection";

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
    axios
      .get(process.env.VUE_APP_API_URL + "/experiences", {
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
};

const mutations = {
  SET_ALL_CAREER_STAGE(state, careerStages) {
    state.careerStages = careerStages;
  },
  SET_ONE_CAREER(state, careerStage) {
    console.log(careerStage);
    state.careerStage = careerStage;
  },
};

export default {
  state,
  getters,
  actions,
  mutations
};
