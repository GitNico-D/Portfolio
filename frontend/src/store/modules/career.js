import axios from "axios";
import errorRedirection from "../../services/errorRedirection";

const headers = { "Content-Type": "application/json" };

const state = () => ({
  careerStage: []
});

const getters = {
  allCareerStage: state => state.careerStage
};

const actions = {
  getAllCareerStage({ commit }) {
    axios
      .get(process.env.VUE_APP_API_URL + "/experiences", {
        headers: headers
      })
      .then(response => {
        commit("ADD_CAREER_STAGE", response.data);
      })
      .catch(error => {
        errorRedirection(error);
      });
  }
};

const mutations = {
  ADD_CAREER_STAGE(state, careerStage) {
    state.careerStage = careerStage;
  }
};

export default {
  state,
  getters,
  actions,
  mutations
};
