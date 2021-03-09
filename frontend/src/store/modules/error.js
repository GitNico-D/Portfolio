
const state = () => ({
    errors: [{ 
        message: "La page demandée est introuvable"
    }]
})

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
    },
    defaultMessage: (state) => {
        return state.errors[0].message
    }
}

export default {
    state,
    getters,
    mutations
};