    import csrf from '@/config/csrf';
    import axios from '@/config/axios.js';
   const states = {
        authCheck: null,
        token: null,
        user: null,
    }
   const mutations = {
        loginSuccess(state, {authCheck, token,user}) {
            state.authCheck = true
            state.token = token
            state.user = user
        },
        setToken(state,token){
            state.token = token
        }
    }
    const getters = {
        getToken : (state) => state.token,
    }
   const actions = {
        async login({commit},{email, password}) {
            await csrf.getCookie();
            const response = await axios.post('auth/login',{
                email: email,
                password: password
            })
            localStorage.setItem('token', response.token);
            localStorage.setItem('token_expires', response.token_exprires_at)
            commit('loginSuccess',{authCheck:true, token:response.token, user: response.user})
        }
    }
export default {
    namespaced :true,
    states,
    mutations,
    getters,
    actions,
}
