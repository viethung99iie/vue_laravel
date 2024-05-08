import { ref, onMounted } from 'vue'
import axios from '@/config/axios'


const  useProvinces = () => {
    const provinces = ref({})
    const getProvinces = async () => {
        try {
            const response = await axios.get('/provinces')
            provinces.value = response.data
        } catch (error) {
            console.log(error)
        }
    }
    return { provinces, getProvinces }
}


const  useDistricts = () => {

    const districts = ref({})
    const getDistricts = async () => {
        try {

            districts.value = [
                {
                    label: 'Chọn Quân/Huyện',
                    value: 0
                }
            ]

        } catch (error) {
            console.log(error)
        }
    }
    return { districts, getDistricts }
}


const  useWards = () => {

    const wards = ref({})
    const getWards = async () => {
        try {

            wards.value = [
                {
                    label: 'Chọn Phường/Xã',
                    value: 0
                }
            ]

        } catch (error) {
            console.log(error)
        }
    }
    return { wards, getWards }
}

const fetchLocation = async (id, relation) => {
    try {

        const response = await axios.get('/locations', {
            params: {
                id: id,
                relation: relation
            }
        })

        return response.data

    } catch (error) {

    }
}

const useLocation = () => {
    const getLocation = async (id, relation, districts, wards, getDistricts, getWards, abc) => {
        if(id !== null && id !== undefined){
            if(id === 0){
                getDistricts()
                getWards()
            }else{
                if(relation === 'districts'){
                    getWards()
                    districts.value = await fetchLocation(id, relation)

                }else if(relation === 'wards'){
                    wards.value = await fetchLocation(id, relation)
                }
            }
        }
    }

    return { getLocation }
}

export { useProvinces,  useDistricts, useWards, fetchLocation, useLocation }
