import axios from "axios";
import errorRedirection from "../../services/errorRedirection";
import authHeader from "../../services/authHeader";

const headers = { "Content-Type": "application/json" };

const state = () => ({
  contacts: [],
  contact: ''
});

const getters = {
  allContacts: state => state.contacts,
  oneContact: state => state.contact
};

const actions = {
  getAllContacts({ commit }) {
    axios.get(process.env.VUE_APP_API_URL + "/contacts", {
        headers: headers
      })
      .then(response => {
        commit("SET_ALL_CONTACT", response.data);
      })
      .catch(error => {
        errorRedirection(error);
      });
  },
  getContact({ commit }, id) {
    return axios.get(process.env.VUE_APP_API_URL + `/contacts/${id}`, {
        headers: headers
      })
      .then(response => {
        commit("SET_ONE_CONTACT", response.data);
      })
      .catch(error => {
        console.log(error.response.data);
        return Promise.reject(error.response.data);
      });
  },
  addContact({ commit }, formData) {
    return axios.post(process.env.VUE_APP_API_URL + '/contacts', formData, {
      headers: authHeader()
    })
    .then(formData => {
      commit("NEW_CONTACT", formData);
      return Promise.resolve(formData);
    })
    .catch(error => {
      return Promise.reject(error.response.data);
    })
  },
  updateContactWithFile({ commit }, { id, formData }) {
    return axios.post(process.env.VUE_APP_API_URL + `/contacts/${id}`, formData, {
      headers: authHeader(),
      params: {
        "_method": "PUT"
      }
    })
    .then(response => {
      commit("UPDATE_CONTACT", response.data);
      return Promise.resolve(response.data);
    })
    .catch(error => {
      return Promise.reject(error.response.data);
    })
  },
  updateContactWithoutFile({ commit }, { id, form }) {
    return axios.put(process.env.VUE_APP_API_URL + `/contacts/${id}`, form, {
      headers: authHeader(),
    })
    .then(response => {
      commit("UPDATE_CONTACT", response.data);
      return Promise.resolve(response.data);
    })
    .catch(error => {
      return Promise.reject(error.response.data);
    })
  },
  deleteContact({ commit }, id) {
    return axios.delete(process.env.VUE_APP_API_URL + `/contacts/${id}`, {
      headers: authHeader()
    })
    .then(response => {
      commit("DELETE_CONTACT", response.data);
      return Promise.resolve(response.data);
    })
    .catch(error => {
      return Promise.reject(error.response.data);
    })
  },
  resetStateContact({ commit }) {
    commit("RESET_STATE_CONTACT")
  }
};

const mutations = {
  SET_ALL_CONTACT(state, contacts) {
    state.contacts = contacts;
  },
  SET_ONE_CONTACT(state, contact) {
    state.contact = contact;
  },
  NEW_CONTACT(state, newContact) {
    state.contacts.unshift(newContact)
  },
  UPDATE_CONTACT(state, updateContact) {
    let contactPosition = '';
    state.contacts.forEach((contact, index) => {
      if(contact.id === updateContact.id) {
        contactPosition = index;
      }
    });
    state.contacts.splice(contactPosition, 1, updateContact);
  },
  DELETE_CONTACT(state, id) {
    let contactPosition = '';
    state.contacts.forEach((contact, index) => {
      if(contact.id === id) {
        contactPosition = index;
      }
    });
    state.contacts.splice(contactPosition, 1);
  }, 
  RESET_STATE_CONTACT(state) {
    state.contact = '';
  }
};

export default {
  state,
  getters,
  actions,
  mutations
};