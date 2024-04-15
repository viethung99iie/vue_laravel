import axios from "axios";
import { store } from "@/store";


axios.interceptors.request.use(
    config => {
        const token = store.getters['auth/getToken']
        if(token){
            config.headers.Authorization = `Bearer ${token}`
        }

        const cancelTokenSource = axios.CancelToken.source()
        config.cancelToken = cancelTokenSource.token
        config.cancelTokenSource = cancelTokenSource

        return config
    },
    error => {
        return Promise.reject(error)
    }
)
axios.interceptors.response.use(
    response => {
        return response.data
    },
    error => {
        return Promise.reject(error)
    }
)

axios.defaults.withCredentials = true
axios.defaults.baseURL = 'http://127.0.0.1:8000/api'


export default axios
