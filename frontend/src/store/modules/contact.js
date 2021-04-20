import axios from "axios";
import errorRedirection from "../../services/errorRedirection";
import authHeader from "../../services/authHeader";

const headers = { "Content-Type": "application/json" };

//Two state for all contact and one contacts
const state = () => ({
  contacts: [],
  contact: ""
});

const getters = {
  allContacts: state => state.contacts,
  oneContact: state => state.contact
};

const actions = {
  //Get all contacts present on bdd
  getAllContacts({ commit }) {
    axios
      .get(process.env.VUE_APP_API_URL + "/contacts", {
        headers: headers
      })
      .then(response => {
        commit("SET_ALL_CONTACT", response.data);
      })
      .catch(error => {
        errorRedirection(error);
      });
  },
  //Get a unique contact defined by his id
  getContact({ commit }, id) {
    return axios
      .get(process.env.VUE_APP_API_URL + `/contacts/${id}`, {
        headers: headers
      })
      .then(response => {
        commit("SET_ONE_CONTACT", response.data);
      })
      .catch(error => {
        return Promise.reject(error.response.data);
      });
  },
  //Add a new contact
  addContact({ commit }, formData) {
    return axios
      .post(process.env.VUE_APP_API_URL + "/contacts", formData, {
        headers: authHeader()
      })
      .then(formData => {
        commit("NEW_CONTACT", formData);
        return Promise.resolve(formData);
      })
      .catch(error => {
        return Promise.reject(error.response.data);
      });
  },
  //This function treat request with file. A parameter "_method: "PUT" set with a POST method 
  //due to an issue with Symfony to receive and treat a formData on PUT method
  updateContactWithFile({ commit }, { id, formData }) {
    return axios
      .post(process.env.VUE_APP_API_URL + `/contacts/${id}`, formData, {
        headers: authHeader(),
        params: {
          _method: "PUT"
        }
      })
      .then(response => {
        commit("UPDATE_CONTACT", response.data);
        return Promise.resolve(response.data);
      })
      .catch(error => {
        return Promise.reject(error.response.data);
      });
  },
  //Classic PUT request to send a form with content-type: Application/json
  updateContactWithoutFile({ commit }, { id, form }) {
    return axios
      .put(process.env.VUE_APP_API_URL + `/contacts/${id}`, form, {
        headers: authHeader()
      })
      .then(response => {
        commit("UPDATE_CONTACT", response.data);
        return Promise.resolve(response.data);
      })
      .catch(error => {
        return Promise.reject(error.response.data);
      });
  },
  //Delete a contact defined by his id
  deleteContact({ commit }, id) {
    return axios
      .delete(process.env.VUE_APP_API_URL + `/contacts/${id}`, {
        headers: authHeader()
      })
      .then(response => {
        commit("DELETE_CONTACT", response.data);
        return Promise.resolve(response.data);
      })
      .catch(error => {
        return Promise.reject(error.response.data);
      });
  },
  //Reset the oneContact state
  resetStateContact({ commit }) {
    commit("RESET_STATE_CONTACT");
  }
};

//Mutations applied to the desired state related to the above actions 
const mutations = {
  SET_ALL_CONTACT(state, contacts) {
    state.contacts = contacts;
  },
  SET_ONE_CONTACT(state, contact) {
    state.contact = contact;
  },
  NEW_CONTACT(state, newContact) {
    state.contacts.unshift(newContact);
  },
  UPDATE_CONTACT(state, updateContact) {
    let contactPosition = "";
    state.contacts.forEach((contact, index) => {
      if (contact.id === updateContact.id) {
        contactPosition = index;
      }
    });
    state.contacts.splice(contactPosition, 1, updateContact);
  },
  DELETE_CONTACT(state, id) {
    let contactPosition = "";
    state.contacts.forEach((contact, index) => {
      if (contact.id === id) {
        contactPosition = index;
      }
    });
    state.contacts.splice(contactPosition, 1);
  },
  RESET_STATE_CONTACT(state) {
    state.contact = "";
  }
};

export default {
  state,
  getters,
  actions,
  mutations
};
