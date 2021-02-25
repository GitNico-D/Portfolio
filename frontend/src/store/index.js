import Vue from 'vue';
import Vuex from 'vuex';
import skill from './modules/skill';
import error from './modules/error';
import software from './modules/software'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {},
    mutations: {},
    getters: {},
    actions: {},
    modules: { 
        skill,
        error,
        software 
    }
})