import axios from 'axios'
import router from '../../router'

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
            if (error.response) {
                this.errors = JSON.parse(JSON.stringify(error.response.data)); 
                commit('ADD_ERROR', this.errors.message);
                router.push({ name: 'WhatError', params: { errorStatus: 'Erreur Api -' + this.errors.code}});
            } else if (error.request) {
                commit('ADD_ERROR', "Le serveur semble être indisponible");
                router.push({ name: 'WhatError', params: { errorStatus: '500' }});
            } else {
                router.push({ name: 'WhatError', params: { errorStatus: '404' }});
            }
            return Promise.reject(error.response.data);
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