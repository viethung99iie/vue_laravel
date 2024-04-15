<script setup>
    import { ref, onMounted, onBeforeUnmount } from 'vue'
    import Layout from '@/components/backend/Layout.vue'
    import Breadcrumb from '@/components/backend/Breadcrumb.vue'
    import axios from '@/config/axios.js'
    import csrf from '@/config/csrf'
    import { useRouter } from 'vue-router'
    import { useStore } from 'vuex'
    import { handleFormError } from '@/helpers/helpers'


    const router = useRouter();
    const store = useStore();
    const pageTitle = ref('Thêm mới nhóm thành viên')

    const formData = ref({
        name: '',
        description: ''
    })
    const formErrorMessage = ref({})

    const save = async () => {
        try {
            await csrf.getCookie()
            const response = await axios.post('/user/catalogue/store', formData.value)
            store.dispatch('message/showMessage', {message: response.message, type: 'success'})
            router.push({name: 'user.catalogue.index'})
        } catch (error) {
            handleFormError(error,formErrorMessage)
        }
    }

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
                                    <div>Nhập thông tin chung của nhóm thành viên</div>
                                    <div>Lưu ý: Những trường đánh dấu <span class="uk-text-danger">(*)</span> là bắt buộc</div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-3-5@m">
                            <div class="ibox">
                                <div class="ibox-content">
                                    <div v-if="formErrorMessage.message" class="uk-text-danger mb20">{{ '*' +  formErrorMessage.message }}</div>
                                    <div uk-grid>
                                        <div class="uk-width-1-2@m">
                                            <div class="form-row">
                                                <div class="label">Nhập vào tên nhóm thành viên <span class="uk-text-danger">*</span></div>
                                                <input
                                                    type="text"
                                                    v-model="formData.name"
                                                    class="form-control form-input"
                                                >
                                                <div v-if="formErrorMessage.name" class="uk-text-danger form-error">{{ '*' +  formErrorMessage.name }}</div>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-2@m">
                                            <div class="form-row">
                                                <div class="label">Mô tả</div>
                                                <input
                                                    type="text"
                                                    v-model="formData.description"
                                                    class="form-control form-input"
                                                >
                                                <div v-if="formErrorMessage.description" class="uk-text-danger form-error">{{ '*' +  formErrorMessage.description }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uk-flex uk-flex-right mt20">
                                        <button class="btn btn-primary">Lưu thông tin</button>
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
