<script setup>
import { ref, onMounted, onBeforeMount } from 'vue'
import Layout from '@/components/backend/Layout.vue'
import Breadcrumb from '@/components/backend/Breadcrumb.vue'
import FormInput from '@/components/backend/FormInput.vue'
import InputImage from '@/components/backend/upload/InputImage.vue'
import Multiselect from '@vueform/multiselect'
import axios from '@/config/axios.js'
import csrf from '@/config/csrf'
import { useRouter } from 'vue-router'
import { useStore } from 'vuex'
import { handleFormError, setupDataDropbox, resizeImage } from '@/helpers/helper.js'
import { useUserCatalogues } from '@/services/UserCatalogue'
import { useProvinces, useDistricts, useWards, fetchLocation, useLocation } from '@/services/Location'


const router = useRouter();
const store = useStore();
const pageTitle = ref('Thêm mới thành viên')

const formData = ref({
    email: 'viethung99iie@gmail.com',
    name: 'Nguyễn Việt Hưng',
    password: '123123',
    repassword: '123123',
    image: '',
    phone: '0963526951',
    description: 'Ghi chú',
    userCatalogueId: 8,
    provinceId: '0',
    districtId: '0',
    wardId: '0',
    address: 'Việt Hàn'
})

const previewImage = ref('/src/assets/backend/img/profile.png')

const formErrorMessage = ref({})

const id = router.currentRoute.value.params.id
const url = router.currentRoute.value.name.split('.')
const action = url[url.length - 1]
console.log(action);


const save = async () => {
    try {
        let response;
        const form = new FormData()
        for (let key in formData.value) {

            // if (action === 'update' && key === 'password') continue

            form.append(key, formData.value[key])
        }

        // if (action === 'update') {
        //     form.append('_method', 'put')
        // }

        const apiUrl = '/user' + ((action === 'update') ? `/${id}` : '')
        await csrf.getCookie()
        response = await axios.post(apiUrl, form, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })

        // store.dispatch('message/showMessage', { message: response.message, type: 'success' })
        // router.push({ name: 'user.index' })

    } catch (error) {
        handleFormError(error, formErrorMessage)
    }
}

const isLoading = ref(false)
const { userCatalogues, getUserCatalogues } = useUserCatalogues()
const { provinces, getProvinces } = useProvinces()
const { districts, getDistricts } = useDistricts()
const { wards, getWards } = useWards()
const { getLocation } = useLocation()

const changeLocation = async (id, relation) => {
    getLocation(id, relation, districts, wards, getDistricts, getWards)
}

const fileInput = ref(null)

const openFileInput = () => {
    fileInput.value.click()
}

const handleClickInput = (event) => {
    const file = event.target.files[0]

    if (file) {
        const reader = new FileReader()
        reader.onload = () => {
            previewImage.value = reader.result
            formData.value.image = file
        }
        reader.readAsDataURL(file)
    }
}

const updateInputValue = (index, newData) => {
    formData.value[index] = newData
}

const detectAction = async () => {
    if (action === 'update') {
        pageTitle.value = 'Cập nhật thành viên'
        try {
            const response = await axios.get('/users/' + `${id}`)

            formData.value.email = response.data.email
            formData.value.name = response.data.name
            formData.value.description = response.data.description
            formData.value.userCatalogueId = response.data.userCatalogueId
            formData.value.provinceId = response.data.provinceId
            formData.value.districtId = response.data.districtId
            formData.value.wardId = response.data.wardId
            formData.value.phone = response.data.phone
            formData.value.address = response.data.address
            formData.value.birthday = response.data.birthday
            formData.value.image = response.data.image
            previewImage.value = resizeImage(response.data.image, 300, 300)


            if (response.data.provinceId !== null && response.data.provinceId !== undefined) {
                changeLocation(formData.value.provinceId, 'districts')
            }
            if (response.data.districtId !== null && response.data.districtId !== undefined) {
                changeLocation(formData.value.districtId, 'wards')
            }

        } catch (error) {

        }
    }
}


onMounted(async () => {
    await getUserCatalogues()
    await getProvinces()
    await getDistricts()
    await getWards()
    await detectAction()
    isLoading.value = true
})


</script>
<template>
    <Layout>
        <template #template>
            <Breadcrumb :pageTitle="pageTitle" />
            <div class="page-container">
                <form @submit.prevent="save()">
                    <div uk-grid>
                        <div class="uk-width-2-5@m">
                            <div class="panel-card">
                                <div class="panel-head">
                                    Thông tin chung
                                </div>
                                <div class="panel-body">
                                    <div>Nhập thông tin chung của nhóm thành
                                        viên</div>
                                    <div>Lưu ý: Những trường đánh dấu <span
                                            class="uk-text-danger">(*)</span> là
                                        bắt buộc</div>

                                </div>
                            </div>
                        </div>
                        <div class="uk-width-3-5@m">
                            <div class="ibox profile-container">
                                <div class="ibox-content">
                                    <div v-if="formErrorMessage.message"
                                        class="uk-text-danger mb20">{{ '*' +
                                            formErrorMessage.message }}</div>
                                    <div uk-grid>
                                        <div class="uk-width-1-2@m">
                                            <FormInput label="Email" type="text"
                                                v-model="formData.email"
                                                :required="true"
                                                :errorMessage="formErrorMessage.email"
                                                @update:value="updateInputValue('email', $event)" />
                                        </div>
                                        <div class="uk-width-1-2@m">
                                            <FormInput label="Họ tên"
                                                type="text"
                                                :value="formData.name"
                                                :required="true"
                                                :errorMessage="formErrorMessage.name"
                                                v-model="formData.name"
                                                @update:value="updateInputValue('name', $event)" />
                                        </div>
                                    </div>
                                    <div uk-grid v-if="action === 'create'">
                                        <div class="uk-width-1-2@m">
                                            <FormInput label="Mật khẩu"
                                                type="password"
                                                :value="formData.password"
                                                :required="true"
                                                :errorMessage="formErrorMessage.password"
                                                v-model="formData.password"
                                                @update:value="updateInputValue('password', $event)" />
                                        </div>
                                        <div class="uk-width-1-2@m">
                                            <FormInput label="Nhập lại mật khẩu"
                                                type="password"
                                                :value="formData.repassword"
                                                :required="true"
                                                :errorMessage="formErrorMessage.repassword"
                                                v-model="formData.repassword"
                                                @update:value="updateInputValue('repassword', $event)" />
                                        </div>
                                    </div>

                                    <div uk-grid>
                                        <div class="uk-width-1-2@m">
                                            <div class="form-row">
                                                <div class="label">Chọn nhóm
                                                    thành viên <span
                                                        class="uk-text-danger">*</span>
                                                </div>
                                                <Multiselect v-if="isLoading"
                                                    v-model="formData.userCatalogueId"
                                                    :options="userCatalogues && setupDataDropbox(userCatalogues, 'Chọn Nhóm Thành Viên')"
                                                    :searchable="true" />
                                            </div>
                                        </div>
                                        <div class="uk-width-1-2@m">
                                            <FormInput label="Ngày sinh"
                                                type="date"
                                                :value="formData.birthday"
                                                :errorMessage="formErrorMessage.birthday"
                                                v-model="formData.birthday"
                                                @update:value="updateInputValue('birthday', $event)" />
                                        </div>
                                    </div>
                                    <div uk-grid>
                                        <div class="uk-width-1-1@m">
                                            <div
                                                class="form-row uk-text-center">
                                                <div class="user-avatar">
                                                    <img :src="previewImage"
                                                        alt=""
                                                        @click="openFileInput">
                                                    <input type="file"
                                                        class="uk-hidden"
                                                        @change="handleClickInput"
                                                        ref="fileInput">

                                                </div>
                                                <div v-if="formErrorMessage.image"
                                                    class="uk-text-danger form-error">
                                                    {{ '*' +
                                                        formErrorMessage.image }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div uk-grid>
                        <div class="uk-width-2-5@m">
                            <div class="panel-card">
                                <div class="panel-head">
                                    Thông tin liên hệ
                                </div>
                                <div class="panel-body">
                                    <div>Nhập thông tin liên hệ của người sử
                                        dụng</div>
                                    <div>Lưu ý: Những trường đánh dấu <span
                                            class="uk-text-danger">(*)</span> là
                                        bắt buộc</div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-3-5@m">
                            <div class="ibox">
                                <div class="ibox-content">
                                    <div v-if="formErrorMessage.message"
                                        class="uk-text-danger mb20">{{ '*' +
                                            formErrorMessage.message }}</div>
                                    <div uk-grid>
                                        <div class="uk-width-1-2@m">
                                            <FormInput label="Số điện thoại"
                                                type="text"
                                                :value="formData.phone"
                                                :required="true"
                                                :errorMessage="formErrorMessage.phone"
                                                v-model="formData.phone"
                                                @update:value="updateInputValue('phone', $event)" />
                                        </div>
                                        <div class="uk-width-1-2@m">
                                            <FormInput label="Ghi chú"
                                                type="text"
                                                :value="formData.description"
                                                :required="true"
                                                :errorMessage="formErrorMessage.description"
                                                v-model="formData.description"
                                                @update:value="updateInputValue('description', $event)" />
                                        </div>
                                    </div>
                                    <div uk-grid>

                                        <div class="uk-width-1-2@m">
                                            <div class="form-row">
                                                <div class="label">Thành Phố
                                                </div>
                                                <Multiselect v-if="isLoading"
                                                    v-model="formData.provinceId"
                                                    :options="provinces && setupDataDropbox(provinces, 'Chọn Thành Phố', 'code')"
                                                    :searchable="true"
                                                    @change="changeLocation($event, 'districts')" />
                                            </div>
                                        </div>


                                        <div class="uk-width-1-2@m">
                                            <div class="form-row">

                                                <div class="label">Quận/Huyện
                                                </div>
                                                <Multiselect v-if="isLoading"
                                                    v-model="formData.districtId"
                                                    :options="setupDataDropbox(districts, 'Chọn Quận/Chuyện', 'code')"
                                                    :searchable="true"
                                                    @change="changeLocation($event, 'wards')" />
                                            </div>
                                        </div>
                                    </div>
                                    <div uk-grid>
                                        <div class="uk-width-1-2@m">
                                            <div class="form-row">
                                                <div class="label">Phường Xã
                                                </div>
                                                <Multiselect v-if="isLoading"
                                                    v-model="formData.wardId"
                                                    :options="setupDataDropbox(wards, 'Chọn Phường/Xã', 'code')"
                                                    :searchable="true" />
                                            </div>
                                        </div>
                                        <div class="uk-width-1-2@m">
                                            <FormInput label="Địa chỉ"
                                                type="text"
                                                :value="formData.address"
                                                :required="true"
                                                :errorMessage="formErrorMessage.address"
                                                v-model="formData.address"
                                                @update:value="updateInputValue('address', $event)" />
                                        </div>
                                    </div>


                                    <div class="uk-flex uk-flex-right mt20">
                                        <button class="btn btn-primary">Lưu
                                            thông tin</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </template>
    </Layout>
</template>

<style src="@vueform/multiselect/themes/default.css"></style>
<style scoped>
.ibox {
    position: relative;
}

.user-avatar {
    width: 100px;
    height: 100px;
    display: inline-block;
    position: absolute;
    border-radius: 50%;
    box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
    top: 50%;
    left: -120px;
    transform: translate(0, -50%);
    cursor: pointer;
}

.user-avatar img {
    border-radius: 50%;
    height: 100%;
    object-fit: cover;
    width: 100%;
}
</style>
