<script setup>
    import { ref, watch } from 'vue';
    const { label, modelValue, required, errorMessage, type} = defineProps(['label', 'modelValue', 'required', 'errorMessage', 'type'])
    
    const emit = defineEmits(['update:value'])

    const handleChange = (event) => {
        emit('update:value', event.target.value)
    }

</script>

<template>
    <div class="form-row">
        <div class="label">{{ label }} <span v-if="required" class="uk-text-danger">*</span></div>
        <input 
            :type="type"
            class="form-control form-input"
            @input="handleChange"
            :value="modelValue"
        >
        <div v-if="errorMessage" class="uk-text-danger form-error">{{ '*' +  errorMessage }}</div>
    </div>
</template>
