const state = {
  authUser: {},
  token: ''
}

const getters = {
}

const mutations = {
  SET_AUTH_USER (state, payload) {
    state.authUser = payload
  },
  SET_API_TOKEN (state, payload) {
    state.token = payload
  }
}

const actions = {
}

export default {
  state,
  getters,
  mutations,
  actions
}
