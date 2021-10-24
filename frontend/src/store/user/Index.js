import axios from 'axios'
import { user as userService } from '../../services'

const state = {
  status: '',
  token: '',
  user: {}
}

const mutations = {
  auth_request (state) {
    state.status = 'loading'
  },

  auth_success (state, token, user) {
    state.status = 'success'
    state.token = token
    state.user = user
  },

  setTokenAndUser (state, tokenUser) {
    state.status = 'success'
    state.token = tokenUser.token
    state.user = tokenUser.user
  },

  setToken (state, token) {
    state.status = 'success'
    state.token = token
  },

  setUser (state, user) {
    state.user = user
    this._vm.user_scopes = user.can
  },

  auth_error (state) {
    state.status = 'error'
  },

  logout (state) {
    state.status = ''
    state.token = ''
  }

}

const actions = {
  login ({ commit }, user) {
    return new Promise((resolve, reject) => {
      commit('auth_request')
      userService.login(user).then(resp => {
        const token = 'Bearer ' + resp.data.api_token
        document.cookie = '_token=' + token + '; path=/; expires=none; Secure; SameSite=Lax'
        axios.defaults.headers.common.Authorization = token
        commit('auth_success', token, user)
        resolve(resp.data)
      }).catch(err => {
        commit('auth_error')
        document.cookie = '_token='
        reject(err)
      })
    })
  },

  user ({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get('/api/user')
        .then((resp) => {
          commit('setUser', resp.data)
          resolve(resp)
        })
        .catch(err => {
          reject(err)
        })
    })
  },

  logout ({ commit }) {
    return new Promise((resolve, reject) => {
      commit('logout')
      document.cookie = '_token='
      delete axios.defaults.headers.common.Authorization
      resolve()
    })
  }
}

const getters = {
  isAuthenticated: state => !!state.token,
  authStatus: state => state.status
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
