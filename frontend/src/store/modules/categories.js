import axios from 'axios'
import errorRedirection from '../../services/errorRedirection'

const headers = { "Content-Type": "application/json" }

const state = () => ({
    categories: [],
})

const getters = {
    allCategories: (state) => state.categories
}

const actions = {
    getAllCategories ({ commit }) {
        axios.get(process.env.VUE_APP_API_URL + '/categories', {
            headers: headers
        })
        .then(response => {
            commit('ADD_CATEGORIES', response.data);
        })
        .catch(error => { 
            errorRedirection(error);
        });
    }
}

const mutations = {
    ADD_CATEGORIES(state, categories) {
        state.categories = categories
    }
}

export default {
    state,
    getters,
    actions,
    mutations
};