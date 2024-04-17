import csrf from '@/config/csrf'
import axios from '@/config/axios.js'

const state = {
    page: '1',
    data: [],
    pagination: []
}

const mutations = {
    setPage (state, page) {
        state.page = page
    },
    setData (state, data) {
        state.data = data
    },
    setPagination (state, response) {
        state.pagination = response
    },
    setDeleteRows (state, ids) {
        state.data = state.data.filter(item => !ids.includes(item.id))
    }
}

const getters = {
    getPage: (state) => state.page,
    getTableData: (state) => state.data,
    getPagination: (state) => state.pagination,
}

const actions = {
    async getData({commit}, {page, endpoint, query} ){
        var apiUrl = endpoint ;
        if( page !== undefined && page !== ''){
            apiUrl += '?page=' + page
        }
        if(query !== undefined){
            const queryStrings = Object.entries(query).map(([key,value]) => `${key}=${value}`).join('&')
            apiUrl +=  ((apiUrl.includes('?')) ? '&': '?')  + queryStrings
        }
        console.log(apiUrl);
        await csrf.getCookie()
        const response = await axios.get(apiUrl)

        commit('setPage', page)
        commit('setData', response.data)
        commit('setPagination', response)
    }, async deleteRows({commit}, ids) {
        try {
            commit('setDeleteRows', ids)
        } catch (error) {
            console.log(error);
        }
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters,
}

