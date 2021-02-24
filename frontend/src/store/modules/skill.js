import axios from 'axios';

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
            return Promise.resolve(response.data);
        })
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