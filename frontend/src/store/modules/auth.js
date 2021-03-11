import AuthServices from '../../services/authServices'

const user = JSON.parse(localStorage.getItem('user'));
const state = 
    user ? { status: { loggedIn: true },user } : { status: { loggedIn: false}, user: null };


const actions = {
  login({ commit }, user) {
    return AuthServices.login(user)
    .then (
      user => {
        commit('loginSuccess', user);
        return Promise.resolve(user);
      },
      error => {
        commit('loginFailure');
        return Promise.reject(error);
      }
    );
  },
  logout({ commit }) {
    AuthServices.logout();
    commit('logout');
  }
}

const mutations = {
  loginSuccess(state, user) {
    state.status.loggedIn = true;
    state.user = user;
  },
  loginFailure(state) {
    state.status.loggedIn = false;
    state.user = null;
  },
  logout(state) {
    state.status.loggedIn = false;
    state.user = null;
  }
}

export default {
    namespaced: true,
    state, 
    actions, 
    mutations
}