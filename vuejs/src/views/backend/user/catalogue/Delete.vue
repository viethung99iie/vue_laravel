<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import Layout from '@/components/backend/Layout.vue'
import Breadcrumb from '@/components/backend/Breadcrumb.vue'
import axios from '@/config/axios.js'
import csrf from '@/config/csrf'
import { useRouter } from 'vue-router'
import { useStore } from 'vuex'
import { handleFormError } from '@/helpers/helpers'
import DeleteForm from '@/components/backend/DeleteForm.vue'


const router = useRouter();
const store = useStore();
const pageTitle = ref('Xóa nhóm thành viên');

const endpoint = ref('user/catalogue/delete');

</script>

<template>
    <Layout>
        <template #template>
            <Breadcrumb :pageTitle="pageTitle" />
            <div class="page-container">
                <DeleteForm :endpoint="endpoint"/>
            </div>
        </template>
    </Layout>
</template>
