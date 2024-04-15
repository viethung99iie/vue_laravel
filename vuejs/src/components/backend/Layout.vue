<script setup>
import { onBeforeMount } from 'vue';
import Sidebar from '@/components/backend/Sidebar.vue'
import Navbar from './Navbar.vue';
import {store} from '@/store'
import { toast } from 'vue3-toastify';

const setLanguage = () =>{
    store.commit('lang/setLanguage','vn');
}

const showNotifications = () =>{
    const message = store.getters['message/getMessage'];
    const type = store.getters['message/getType'];
    if(message !==null){
        if(type === 'success'){
            toast.success(message)
        }else if(type === 'error'){
            toast.error(message)
        }
        store.dispatch('message/removeMessage');
    }
}

const setToken = () => {
    const token = localStorage.getItem('token');
    store.commit('auth/setToken',token);
    };

onBeforeMount(()=>{
    setLanguage();
    setToken();
    showNotifications();
})

</script>

<template >
    <Sidebar />
        <div class="page-wrapper">
            <Navbar/>
            <slot name="template">

            </slot>
        </div>
</template>

<style scoped >
.page-wrapper {
    margin-left: 240px;
}
</style>
