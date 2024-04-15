import csrf from '@/config/csrf'
import axios from '@/config/axios.js'
import sidebarVn from '@/lang/vn/sidebar.js'
import sidebarEn from '@/lang/en/sidebar.js'
import publishVn from '@/lang/vn/array.js'
import publishEn from '@/lang/en/array.js'
const state = {
    language: 'vn',
    sidebar: {
        vn: sidebarVn,
        en: sidebarEn
    },
    publish :{
        vn: publishVn,
        en: publishEn
    },
    perpage : {
        vn: publishVn,
        en: publishEn
    }
}

const mutations = {
    setLanguage (state, language) {
        state.language = language
    },

}

const getters = {
    getSidebar: (state) => state.sidebar[state.language],
    getCurrentLanguage: (state) => state.language,
    getPublish : (state) => state.publish[state.language].PUBLISH,
    getPerpage : (state) => state.perpage[state.language].PERPAGE,
}

const actions = {

}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters,
}

