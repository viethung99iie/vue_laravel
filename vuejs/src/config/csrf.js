import axios from '@/config/axios.js'


export default {
    getCookie(){
        return axios.get('/csrf-cookie')
    }
}
