<script setup>
    import { ref, computed, onMounted } from 'vue'
    import { useStore } from 'vuex'
    import csrf from '@/config/csrf'
    import { useRouter } from 'vue-router'
    import bus from '@/events/EventBus.js'
    import axios from '@/config/axios'
    import { handleFormError } from '@/helpers/helpers'
    import Switch from '@/components/Switch.vue'

    const { tableConfig, endpoint, model } = defineProps(['tableConfig','endpoint', 'model'])

    const formErrorMessage = ref({});

    const store = useStore();
    const router = useRouter()

    let allChecked = ref(false);
    let selectedRow = ref([]);

     const field = ref({
        publish: 'publish',
    })

    const tableData = computed(() => {
        return store.getters['pagination/getTableData'];
    })

    const pagination = computed(() => {
        return store.getters['pagination/getPagination'];
    })
    onMounted(() =>{
        renderData();
        emitSearch()
    })
    const renderData =  async (page, query) => {
            try {
                let currentPage = page
                let dispatchQuery = query || {}
                if(!currentPage){
                    const queryPage = router.currentRoute.value.query.page
                    currentPage = queryPage || 1
                }
                if(!query){
                    dispatchQuery = { ...router.currentRoute.value.query }
                    delete dispatchQuery.page
                }

                await store.dispatch('pagination/getData', {page: currentPage, endpoint: endpoint, query: dispatchQuery})

                /* HANDEL QUERT STRING  */
                const hasQueryData = dispatchQuery && Object.keys(dispatchQuery).length !== 0 ;
                const hasPageData =  currentPage !== undefined && currentPage !== '';

                if(hasQueryData || hasPageData){
                    const queryString = {}
                    if(hasPageData){
                        queryString.page = currentPage
                    }
                    if(hasQueryData){
                        Object.assign(queryString, dispatchQuery)
                    }
                    router.push({ query: queryString })
                }

            } catch (error) {
                handleFormError(error,formErrorMessage)
            }
    }
    const checkAll = () =>{
        if(allChecked.value){
            selectedRow.value = tableData.value.map((_,index) =>index)
        }else{
            selectedRow.value = []
        }
    }
    const updateCheckAll = () => {
        const totalRow = tableData.value.length
        allChecked.value = (selectedRow.value.length == totalRow) ? true : false;
    }

    const emitSearch = () => {
        bus.on('table-search', searchData => {
            const searchPage = 1;
            renderData(searchPage, searchData)
        })
    }


</script>
<template>
    <table class="table table-bordered">
            <thead>
                <tr>
                    <th>
                        <input
                            type="checkbox"
                            class="input-checkbox check-box-item"
                            v-model="allChecked"
                            @change="checkAll()"
                        >
                    </th>
                    <td
                        v-for="(val,index) in tableConfig.field.thead"
                        :key="index"
                        :class="tableConfig.field.class[index]"
                     > {{ val }} </td>
                    <th >Trạng thái</th>
                    <th >Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <template v-if="tableData.length >0">
                    <tr v-for="(val,key) in tableData"
                        :key="key"
                        :class="(selectedRow.includes(key)) ?  'selected-row':  ''"
                       @change="updateCheckAll()"
                    >
                        <td>
                            <div class="uk-flex uk-flex-center">
                                <input
                                    type="checkbox"
                                    class="input-checkbox check-box-item "
                                    v-model="selectedRow"
                                    :value="key"

                                >
                            </div>
                        </td>
                        <td
                            v-for="(field,index) in tableConfig.field.value"
                            :key="index"
                            :class="tableConfig.field.class[index]"
                        >{{ val[field] }}</td>
                     <td>
                            <Switch :checked=" (val.publish == 2) ? true  : false" :id=val.id :field="field.publish" :model="model" />
                            </td>
                      <td class="uk-flex-center text-center uk-flex">
                            <router-link :to=tableConfig.route.update class="btn btn-primary mr10">
                                <i class="bx bx-edit"></i>
                            </router-link>
                            <RouterLink :to=tableConfig.route.delete class="btn btn-danger mr10">
                                <i class="bx bx-trash-alt"></i>
                            </RouterLink>
                            <template v-if="tableConfig.action.length >0">
                                <RouterLink
                                    v-for="(action,actionIndex) in tableConfig  .action"
                                    :key="actionIndex"
                                    :to=action.route
                                    class="btn"
                                    :class="action.color"
                                >
                                    <i :class="action.icon"></i>
                                </RouterLink>
                            </template>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
        <div class="paginate" v-if="tableData.length > 0 && tableData !== null">
            <ul class="uk-pagination uk-flex-center" uk-margin >
                <li><a href="#"><span uk-pagination-></span></a></li>
                <li v-for="(val,index) in pagination.links" :key="index"
                    :class="{ 'uk-active' : val.active }"
                    @click="renderData(val.label)"
                >
                    <span v-if="!isNaN(val.label)">{{ val.label }}</span>
                </li>

                <li><a href="#"><span ></span></a></li>
            </ul>
        </div>
</template>
<style scoped>

    .selected-row{
        background: #ffc !important;
    }

    .uk-pagination li:not(:last-child){
        margin-right:5px;
    }
    .uk-pagination span{
        cursor: pointer;
        background: #eaeaea;
    }
    .uk-pagination li.uk-active span{
        background: var(--secondary-color);
        color:#fff
    }


</style>
