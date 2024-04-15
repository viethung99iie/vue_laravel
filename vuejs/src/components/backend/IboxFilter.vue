<script setup>
    import { ref, onMounted,computed } from 'vue';
    import { useRouter } from 'vue-router'
    import { useStore } from 'vuex';
    import bus from '@/events/EventBus.js';

    const { filter } = defineProps(['filter'])

    const store = useStore();

    const perpage = ref(20)
    const publish = ref(0)
    const keyword = ref('')

    const publishFilter  =  store.getters['lang/getPublish'];
    const perpageFilter  =  store.getters['lang/getPerpage'];

    const search = () => {
        bus.emit('table-search', { perpage: perpage.value, publish: publish.value,  keyword: keyword.value})
    }
</script>

<template>
    <div class="ibox-filter">
        <form action="" method="" @submit.prevent="search()">
            <div class="uk-flex uk-flex-middle uk-flex-between">
                <select class="form-control " v-model="perpage">
                     <option v-for="(val,key) in perpageFilter" :key="key" :value=key >{{ val }}</option>
                </select>
                <div class="filter-action">
                    <div class="uk-flex uk-flex-middle">
                        <select class="form-control" v-model="publish"   >
                            <option v-for="(val,key) in publishFilter" :key="key" :value=key >{{ val }}</option>
                        </select>
                        <div class="filter-keyword ml10 uk-flex uk-flex-middle">
                            <input
                                type="text"
                                class="form-control input-text"
                                v-model="keyword"
                                placeholder="Nhập từ khóa cần tìm kiếm..."
                            >
                            <button class="btn btn-primary" ><i class="bx bx-search"></i></button>
                        </div>
                        <RouterLink  :to=filter.createLink class="ml10 btn btn-danger button"><i class="bx bx-plus"></i>{{ filter.createTitle }}</RouterLink>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<style scoped>
    .ibox-filter{
        margin-bottom:15px;
    }
</style>
