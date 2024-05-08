import { ref, onMounted } from 'vue'
import axios from '@/config/axios'

const  useUserCatalogues = () => {

    const userCatalogues = ref({})
    const getUserCatalogues = async () => {
        try {
            const response = await axios.get('/user/catalogue/all')
            userCatalogues.value = response.data
        } catch (error) {
            console.log(error)
        }
    }
    return { userCatalogues, getUserCatalogues }
}

export { useUserCatalogues }
