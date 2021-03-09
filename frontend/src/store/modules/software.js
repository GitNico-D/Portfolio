import axios from 'axios'
import errorRedirection from '../../services/errorRedirection'

const state = () => ({
    softwares: [],
})

const getters = {
    allSoftwares: (state) => state.softwares
}

const actions = {
    getAllSoftwares ({ commit }) {
        axios.get(process.env.VUE_APP_API_URL + '/softwares', {
            headers: {
                "Content-Type": "application/json"
            },
        })
        .then(response => {
            commit('ADD_SOFTWARE', response.data);
        })
        .catch(error => { 
            errorRedirection(error);
        });
    }
}

const mutations = {
    ADD_SOFTWARE(state, softwares) {
        state.softwares = softwares
    }
}

export default {
    state,
    getters,
    actions,
    mutations
};