import axios from "axios";
import errorRedirection from "../../services/errorRedirection";
import authHeader from "../../services/authHeader";

const headers = { "Content-Type": "application/json" };

const state = () => ({
  categories: [],
  category: ""
});

const getters = {
  allCategories: state => state.categories,
  oneCategory: state => state.category
};

const actions = {
  getAllCategories({ commit }) {
    axios
      .get(process.env.VUE_APP_API_URL + "/categories", {
        headers: headers
      })
      .then(response => {
        commit("ADD_CATEGORIES", response.data);
      })
      .catch(error => {
        errorRedirection(error);
      });
  },
  getCategory({ commit }, id) {
    return axios
      .get(process.env.VUE_APP_API_URL + `/categories/${id}`, {
        headers: headers
      })
      .then(response => {
        commit("SET_ONE_CATEGORY", response.data);
      })
      .catch(error => {
        return Promise.reject(error.response.data);
      });
  },
  addCategories({ commit }, formData) {
    return axios
      .post(process.env.VUE_APP_API_URL + "/categories", formData, {
        headers: authHeader()
      })
      .then(formData => {
        commit("NEW_CATEGORIES", formData);
        return Promise.resolve(formData);
      })
      .catch(error => {
        return Promise.reject(error.response);
      });
  },
  updateCategoriesWithFile({ commit }, { id, formData }) {
    return axios
      .post(process.env.VUE_APP_API_URL + `/categories/${id}`, formData, {
        headers: authHeader(),
        params: {
          _method: "PUT"
        }
      })
      .then(response => {
        commit("UPDATE_CATEGORIES", response.data);
        return Promise.resolve(response.data);
      })
      .catch(error => {
        return Promise.reject(error.response.data);
      });
  },
  updateCategoriesWithoutFile({ commit }, { id, form }) {
    return axios
      .put(process.env.VUE_APP_API_URL + `/categories/${id}`, form, {
        headers: authHeader()
      })
      .then(response => {
        commit("UPDATE_CATEGORIES", response.data);
        return Promise.resolve(response.data);
      })
      .catch(error => {
        return Promise.reject(error.response.data);
      });
  },
  deleteCategories({ commit }, id) {
    return axios
      .delete(process.env.VUE_APP_API_URL + `/categories/${id}`, {
        headers: authHeader()
      })
      .then(response => {
        commit("DELETE_CATEGORIES", response.data);
        return Promise.resolve(response.data);
      })
      .catch(error => {
        return Promise.reject(error.response.data);
      });
  },
  resetStateCategory({ commit }) {
    commit("RESET_STATE_CATEGORY");
  }
};

const mutations = {
  ADD_CATEGORIES(state, categories) {
    state.categories = categories;
  },
  SET_ONE_CATEGORY(state, category) {
    state.category = category;
  },
  NEW_CATEGORIES(state, newCategories) {
    state.categories.unshift(newCategories);
  },
  UPDATE_CATEGORIES(state, updateCategories) {
    let categoriesPosition = "";
    state.categories.forEach((categories, index) => {
      if (categories.id === updateCategories.id) {
        categoriesPosition = index;
      }
    });
    state.categories.splice(categoriesPosition, 1, updateCategories);
  },
  DELETE_CATEGORIES(state, id) {
    let categoriesPosition = "";
    state.categories.forEach((categories, index) => {
      if (categories.id === id) {
        categoriesPosition = index;
      }
    });
    state.categories.splice(categoriesPosition, 1);
  },
  RESET_STATE_CATEGORY(state) {
    state.category = "";
  }
};

export default {
  state,
  getters,
  actions,
  mutations
};
