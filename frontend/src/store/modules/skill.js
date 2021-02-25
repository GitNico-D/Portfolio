import axios from 'axios'
import router from '../../router'

const state = () => ({
    skills: [],
})

const getters = {
    allSkills: (state) => state.skills
}

const actions = {
    getAllSkills ({ commit }) {
        axios.get(process.env.VUE_APP_API_URL + '/skills', {
            headers: {
                "Content-Type": "application/json"
            },
        })
        .then(response => {
            commit('ADD_SKILL', response.data);
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
    ADD_SKILL(state, skills) {
        state.skills = skills
    }
}

export default {
    state,
    getters,
    actions,
    mutations
};