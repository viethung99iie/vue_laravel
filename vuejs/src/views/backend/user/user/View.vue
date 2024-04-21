<script setup>
import Breadcrumb from '@/components/backend/Breadcrumb.vue'
import IboxFilter from '@/components/backend/IboxFilter.vue'
import IboxTitle from '@/components/backend/IboxTitle.vue'
import Table from '@/components/backend/Table.vue'
import Layout from '@/components/backend/Layout.vue'
import axios from '@/config/axios'
import { ref } from 'vue'

const pageTitle = ref('Quản lí thành viên')
const tableTitle = ref('Danh Sách thành viên')
const endpoint = ref('/user')
const model = ref('User')

const filter = ref({
    createTitle: 'Thêm mới thành viên',
    createLink: '/user/store',
})

const actions = ref({
    deleteAll: 'user/deteleAll',
    updateStatusAll: '/update/status/all'
});

const formErrorMessage = ref({});
const tableConfig = ref({
    field: {
        thead: ['Tên', 'Email', 'Số điện thoại', 'Địa chỉ'],
        value: ['name', 'email', 'phone', 'address'],
        class: ['uk-text-left', 'uk-text-left', 'uk-text-left', 'uk-text-left']
    },
    data: [],
    route: {
        update: '/user/update',
        delete: '/user/delete',
    },
    action: []
})

</script>
<template lang="">
        <Layout >
            <template #template>
                    <Breadcrumb :pageTitle="pageTitle"/>
                     <div class="page-container">
                        <div class="ibox">
                            <IboxTitle :tableTitle="tableTitle"/>
                            <div class="ibox-content">
                                 <IboxFilter :filter="filter" />
                                    <Table :tableConfig="tableConfig" :endpoint="endpoint" :model="model" :actions="actions"/>
                            </div>
                        </div>
                    </div>
            </template>
</Layout>
</template>

<style lang="">

</style>
