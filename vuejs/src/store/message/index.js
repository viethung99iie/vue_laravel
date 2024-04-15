import csrf from '@/config/csrf'
import axios from '@/config/axios.js'
import sidebarVn from '@/lang/vn/sidebar.js'
import sidebarEn from '@/lang/en/sidebar.js'

const state = {
    message: null,
    type : null,
}

const mutations = {
    setMessage (state, {message,type}) {
        state.message = message,
        state.type = type
    },clearMessage(){
        state.message = null
    }

}

const getters = {
    getMessage : (state) => state.message,
    getType : (state) => state.type,
}

const actions = {
     showMessage({commit},{message,type}) {
        commit('setMessage',{message,type})
     },

     removeMessage({commit}){
        commit('clearMessage')
     }
}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters,
}

