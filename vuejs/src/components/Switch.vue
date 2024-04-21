<template>
    <div for="" class="label" @click="updateStatus">
        <input type="checkbox" :checked="checked" class="js-switch"
            v-model="isChecked">
        <span class="switch"></span>
    </div>
</template>

<script setup>
import { ref, defineProps } from 'vue';
import axios from '@/config/axios';
import { useStore } from 'vuex'
import { toast } from 'vue3-toastify';

const store = useStore();


const props = defineProps({
    checked: {
        type: Boolean,
        required: true
    },
    id: {
        type: Number,
        required: true
    },
    field: {
        type: String,
        required: true
    },
    model: {
        type: String,
        required: true
    }
})

const isChecked = ref(props.checked)


const updateStatus = async () => {
    isChecked.value = !isChecked.value
    try {

        const response = await axios.put('update/status', {
            id: props.id,
            checked: isChecked.value,
            field: props.field,
            model: props.model
        })

        // toast.success(response.messages)

    } catch (error) {
        console.log(error);
    }
}



</script>

<style scoped>
.label {
    margin-left: 12px;
    color: #1a202c;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    display: flex;
    justify-content: center;
    margin-bottom: 0 !important;
}

.js-switch {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border-width: 0;
}

.switch {
    --switch-container-width: 42px;
    --switch-size: calc(var(--switch-container-width) / 2);
    --light-gray: #e2e8f0;
    --gray: #cbd5e0;
    --dark-gray: #a0aec0;
    --teal: #4fd1c5;
    --dark-teal: #319795;
    /* Vertically center the inner circle */
    display: flex;
    align-items: center;
    position: relative;
    height: var(--switch-size);
    flex-basis: var(--switch-container-width);
    /* Make the container element rounded */
    border-radius: var(--switch-size);
    background-color: var(--light-gray);
    /* In case the label gets really long, the toggle shouldn't shrink. */
    flex-shrink: 0;
    transition: background-color 0.25s ease-in-out;
    width: 35px;
    cursor: pointer;
}

.switch::before {
    content: "";
    position: absolute;
    left: 3px;
    height: calc(var(--switch-size) - 4px);
    width: calc(var(--switch-size) - 4px);
    border-radius: 9999px;
    background-color: white;
    border: 2px solid var(--light-gray);
    transition: transform 0.375s ease-in-out;
}

.js-switch:checked+.switch {
    background-color: var(--teal);
}

.js-switch:checked+.switch::before {
    border-color: var(--teal);
    /* Move the inner circle to the right */
    transform: translateX(calc(var(--switch-container-width) - var(--switch-size)));
}

.js-switch:focus+.switch::before {
    border-color: var(--gray);
}

.js-switch:focus:checked+.switch::before {
    border-color: var(--dark-teal);
}

.js-switch:disabled+.switch {
    background-color: var(--gray);
}

.js-switch:disabled+.switch::before {
    background-color: var(--dark-gray);
    border-color: var(--dark-gray);
}
</style>
