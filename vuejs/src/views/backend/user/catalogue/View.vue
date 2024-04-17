<script setup>
    import Breadcrumb from '@/components/backend/Breadcrumb.vue'
    import IboxFilter from '@/components/backend/IboxFilter.vue'
    import IboxTitle from '@/components/backend/IboxTitle.vue'
    import Table from '@/components/backend/Table.vue'
    import Layout from '@/components/backend/Layout.vue'
    import axios from '@/config/axios'
    import { ref } from 'vue'
    const pageTitle = ref('Quản lí nhóm thành viên')
    const tableTitle = ref('Danh Sách nhóm thành viên')
    const endpoint = ref('/user/catalogue')
    const model = ref('UserCatalogue')
    const filter = ref({
        createTitle : 'Thêm mới thành viên',
        createLink : '/user/catalogue/store',
    })
    const actions = ref({
        deleteAll : 'user/catalogue/deteleAll',
        updateStatusAll : '/update/status/all'
    });

    const formErrorMessage = ref({});
    const tableConfig = ref({
        field : {
            thead: ['Nhóm thành viên','Số lượng','Mô tả'],
            value: ['name','users_count','description'],
            class: ['uk-text-left','uk-text-center','uk-text-left','uk-text-center']
        },
        data : [],
        route : {
            update : '/user/catalogue/update',
            delete : '/user/catalogue/delete',
        },
        action : []
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
