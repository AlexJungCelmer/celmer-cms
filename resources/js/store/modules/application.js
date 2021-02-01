import axios from "axios";
import { reject } from "lodash";

const state = {
  current: {},
  applications: [],
};

const mutations = {
  setCurrent(state, app) {
    state.current = app
  },
  setApplications(state, apps) {
    state.applications = apps
  }
};

const actions = {
  getApplications({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get("/api/apps").then((resp) => {
        console.log(resp);
        commit('setApplications', resp.data)
        resolve(resp);
      });
    }).catch(err => {
      reject(err);
    })
  },

  getApplication({ commit }, slug) {
    return new Promise((resolve, reject) => {
      axios.get("/api/apps/"+slug).then((resp) => {
        commit('setCurrent', resp.data);
        resolve(resp);
      })
    }).catch(err => {
      reject(err);
    })
  }
}

const getters = {
  currentApp: state => state.current,
  applications: state => state.applications
}

export default {
  // namespaced: true,
  state,
  getters,
  actions,
  mutations
}