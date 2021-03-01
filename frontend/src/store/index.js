import Vue from 'vue';
import Vuex from 'vuex'

Vue.use(Vuex)

const state = () => ({
    errors: [{ 
        message: "La page demandée est introuvable"
    }]
});

const mutations = {
    ADD_ERROR: (state, message) => {
        state.errors.push({
            message: message
        })
    }
}

const getters = {
    allErrors: (state) => {
        return state.errors
    },
    lastErrorMessage: (state, getters) => {
        return getters.allErrors[getters.allErrors.length -1].message
    }
}

export default new Vuex.Store({
    state: state,
    mutations: mutations,
    getters: getters,
    actions: {
    },
    modules: {
    }
})