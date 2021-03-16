import axios from "axios";
import errorRedirection from "../../services/errorRedirection";

const headers = { "Content-Type": "application/json" };

const state = () => ({
  skills: []
});

const getters = {
  allSkills: state => state.skills
};

const actions = {
  getAllSkills({ commit }) {
    axios
      .get(process.env.VUE_APP_API_URL + "/skills", {
        headers: headers
      })
      .then(response => {
        commit("ADD_SKILL", response.data);
      })
      .catch(error => {
        errorRedirection(error);
      });
  }
};

const mutations = {
  ADD_SKILL(state, skills) {
    state.skills = skills;
  }
};

export default {
  state,
  getters,
  actions,
  mutations
};
