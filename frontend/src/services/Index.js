import axios from 'axios'
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded'

const baseUrl = 'http://localhost/celmer-cms/public/api/'

const user = {
  url: baseUrl + 'user',

  login: function (data) {
    return axios.post(baseUrl + 'login', data)
  },

  get: function () {
    return axios.get(user.url)
  }
}

export { user }
