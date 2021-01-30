import axios from "axios";

let teste = document.cookie.split(';')[0].split('=')[1];
console.log(teste);
const state = {
  status: '',
  token: teste,
  user: {}
};

const mutations = {
  auth_request(state) {
    state.status = 'loading'
  },
  auth_success(state, token, user) {
    state.status = 'success';
    state.token = token;
    state.user = user;
  },
  setTokenAndUser(state, tokenUser) {
    state.status = 'success';
    state.token = tokenUser.token;
    state.user = tokenUser.user;
  },
  setToken(state, token) {
    state.status = 'success';
    state.token = token;
  },
  setUser(state, user) {
    state.status = 'success';
    state.user = user;
  },
  auth_error(state) {
    state.status = 'error'
  },
  logout(state) {
    state.status = ''
    state.token = ''
  },
};

const actions = {
  login({ commit }, user) {
    return new Promise((resolve, reject) => {
      let toRequest = {
        email: user.email,
        password: user.password,
        password_confirmation: user.password_confirmation,
      }
      commit('auth_request')
      axios({ url: '/api/sanctum/token', data: toRequest, method: 'POST' })
        .then(resp => {
          console.log("resp", resp);
          const token = 'Bearer ' + resp.data;
          document.cookie = "_token=" + token; '; path=/; expires=none; Secure; SameSite=Lax';
          axios.defaults.headers.common['Authorization'] = token;
          commit('auth_success', token, user)
          resolve(resp)
        })
        .catch(err => {
          commit('auth_error')
          document.cookie = "_token="
          reject(err)
        })
    })
  },

  user({ }) {
    return new Promise((resolve, reject) => {
      axios.get("/api/user")
        .then((resp) => {
          console.log('aqui', resp);
          commit('setUser', resp.data);
          resolve(resp);
        })
        .catch(err => {
          reject(err)
        })
    });
  },

  logout({ commit }) {
    return new Promise((resolve, reject) => {
      commit('logout')
      document.cookie = "_token="
      delete axios.defaults.headers.common['Authorization']
      resolve()
    })
  }
}

const getters = {
  isAuthenticated: state => !!state.token,
  authStatus: state => state.status,
}

export default {
  // namespaced: true,
  state,
  getters,
  actions,
  mutations
}