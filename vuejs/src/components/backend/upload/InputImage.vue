<script setup>

import { ref, onMounted } from 'vue';
import FormInput from '@/components/backend/FormInput.vue'

const value = ref('')


const openWindow = () => {
    const newWindow = window.open('', '_blank', 'width=600,height=400,resizable=yes,scrollbars=yes');
    if (newWindow) {
        newWindow.location.href = 'http://127.0.0.1:8000/api/open-image';
    } else {
        console.error('Popup window blocked!');
    }
};

const handleMessage = (event) => {
    if (event.origin !== 'http://127.0.0.1:8000') {
        return
    }



    console.log(event.data.imageUrl);
}



onMounted(() => {
    window.addEventListener('message', handleMessage)
})

</script>

<template>
    <FormInput label="Ảnh đại diện" type="text" :value="value" v-model="value"
        :required="false" @click="openWindow" />
</template>
