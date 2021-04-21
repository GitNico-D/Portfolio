import axios from "axios";
import errorRedirection from "../../services/errorRedirection";
import authHeader from "../../services/authHeader";

const headers = { "Content-Type": "application/json" };

//Two state for all skill and one skills
const state = () => ({
  skills: [],
  skill: ""
});

const getters = {
  allSkills: state => state.skills,
  oneSkill: state => state.skill
};

const actions = {
  //Get all skills present on bdd
  getAllSkills({ commit }) {
    axios
      .get(process.env.VUE_APP_API_URL + "/skills", {
        headers: headers
      })
      .then(response => {
        commit("SET_ALL_SKILL", response.data);
      })
      .catch(error => {
        errorRedirection(error);
      });
  },
  //Get a unique skill defined by his id
  getSkill({ commit }, id) {
    return axios
      .get(process.env.VUE_APP_API_URL + `/skills/${id}`, {
        headers: headers
      })
      .then(response => {
        commit("SET_ONE_SKILL", response.data);
      })
      .catch(error => {
        return Promise.reject(error.response);
      });
  },
  //Add a new skill
  addSkill({ commit }, formData) {
    return axios
      .post(process.env.VUE_APP_API_URL + "/skills", formData, {
        headers: authHeader()
      })
      .then(formData => {
        commit("NEW_SKILL", formData);
        return Promise.resolve(formData);
      })
      .catch(error => {
        return Promise.reject(error.response);
      });
  },
  //This function treat request with file. A parameter "_method: "PUT" set with a POST method 
  //due to an issue with Symfony to receive and treat a formData on PUT method
  updateSkillWithFile({ commit }, { id, formData }) {
    return axios
      .post(process.env.VUE_APP_API_URL + `/skills/${id}`, formData, {
        headers: authHeader(),
        params: {
          _method: "PUT"
        }
      })
      .then(response => {
        commit("UPDATE_SKILL", response.data);
        return Promise.resolve(response.data);
      })
      .catch(error => {
        return Promise.reject(error.response);
      });
  },
  //Classic PUT request to send a form with content-type: Application/json
  updateSkillWithoutFile({ commit }, { id, form }) {
    return axios
      .put(process.env.VUE_APP_API_URL + `/skills/${id}`, form, {
        headers: authHeader()
      })
      .then(response => {
        commit("UPDATE_SKILL", response.data);
        return Promise.resolve(response.data);
      })
      .catch(error => {
        return Promise.reject(error.response);
      });
  },
  //Delete a skill defined by his id
  deleteSkill({ commit }, id) {
    return axios
      .delete(process.env.VUE_APP_API_URL + `/skills/${id}`, {
        headers: authHeader()
      })
      .then(response => {
        commit("DELETE_SKILL", response.data);
        return Promise.resolve(response.data);
      })
      .catch(error => {
        return Promise.reject(error.response);
      });
  },
  //Reset the oneSkill state
  resetStateSkill({ commit }) {
    commit("RESET_STATE_SKILL");
  }
};

//Mutations applied to the desired state related to the above actions 
const mutations = {
  SET_ALL_SKILL(state, skills) {
    state.skills = skills;
  },
  SET_ONE_SKILL(state, skill) {
    state.skill = skill;
  },
  NEW_SKILL(state, newSkill) {
    state.skills.unshift(newSkill);
  },
  UPDATE_SKILL(state, updateSkill) {
    let skillPosition = "";
    state.skills.forEach((skill, index) => {
      if (skill.id === updateSkill.id) {
        skillPosition = index;
      }
    });
    state.skills.splice(skillPosition, 1, updateSkill);
  },
  DELETE_SKILL(state, id) {
    let skillPosition = "";
    state.skills.forEach((skill, index) => {
      if (skill.id === id) {
        skillPosition = index;
      }
    });
    state.skills.splice(skillPosition, 1);
  },
  RESET_STATE_SKILL(state) {
    state.skill = "";
  }
};

export default {
  state,
  getters,
  actions,
  mutations
};
