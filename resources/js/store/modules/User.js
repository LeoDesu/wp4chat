import axios from "axios";

const state = {
    user: null
};
const getters = {
    user: state => state.user
};
const actions = {
    fetchUser({commit}){
        axios.get("/api/user").then(res => commit('setUser', res.data))
    },
    resetUser({commit}){
        commit('setUser', null)
    }
};
const mutations = {
    setUser: (state, user) => state.user = user
};

export default {
    state,
    getters,
    actions,
    mutations
}